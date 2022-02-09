<?php

namespace App\Traits;

use App\Models\Course;
use App\Models\Attachment;
use App\Models\Topic;
use App\Models\Embed;
use App\Models\Event;
use Illuminate\Support\HtmlString;
use voku\helper\HtmlDomParser;
use Erusev\Parsedown\Parsedown;
use Carbon\Carbon;

trait FromGit
{

    public function parseParentPath($path) {
        $elements = explode('/', $path);
        array_pop($elements);
        $merged =implode('/', $elements);
        return $merged;
    }

    public function parseGitbookAdvSyntax($content) {
        // Hint detection
        $content = preg_replace(
          '/{% hint( style="(.*)")? %}([\S\s]+){% endhint %}/mU',
          '<div class="hint is-$2"><p>$3</p></div>',
          $content
        );
        // Complete embed detection
        $embeds = [];
        preg_match_all(
          '/{% embed url="(.+)" %}([\S\s]+){% endembed %}/mU',
          $content,
          $embeds,
          PREG_SET_ORDER
        );
        $content = preg_replace(
          '/{% embed url="(.+)" %}\n([\S\s]+)\n{% endembed %}/mU',
          '<div data-embed alt="$2" src="$1"></div>',
          $content
        );

        $content = preg_replace(
          '/<div data-embed alt="(.+)" src=".+[\?\&]v=([^\?\&]+)"><\/div>/mU',
          '<div class="embed-responsive video is-16by9"><iframe src="//www.youtube.com/embed/$2" frameborder="0" allowfullscreen></iframe><div class="caption">$1</div></div>',
          $content
        );
        $lightEmbeds = [];
        /*
        // Light embed detection
        preg_match_all(
          '/{% embed url="(.+)" %}/mU',
          $content,
          $lightEmbeds,
          PREG_SET_ORDER
        );
        $content = preg_replace(
          '/{% embed url="(.+)" %}/mU',
          '<div class="embed" src="$1"></div>',
          $content
        );
        */
        // Complete file detection
        $files = [];
        preg_match_all(
          '/{% file src="(.+)" %}([\S\s]+){% endfile %}/mU',
          $content,
          $files,
          PREG_SET_ORDER
        );
        $content = preg_replace(
          '/{% file src="(.+)" %}([\S\s]+){% endfile %}/mU',
          '<div class="file" alt="$2" src="$1"></div>',
          $content
        );
        // Light file detection
        $lightFiles = [];
        preg_match_all(
          '/{% file src="(.+)" %}/mU',
          $content,
          $lightFiles
        );
        $content = preg_replace(
          '/{% file src="(.+)" %}/mU',
          '<div class="file" src="$1"></div>',
          $content
        );

        // Tabs
        $content = preg_replace(
          '/{% tabs %}/mU',
          '<div class="tabs">',
          $content
        );
        $content = preg_replace(
          '/{% endtabs %}/mU',
          '</div>',
          $content
        );
        $content = preg_replace(
          '/{% tab title="(.+)" %}([\S\s]+){% endtab %}/mU',
          '<div class="tab" title="$1">$2</div>',
          $content
        );

        return [
          'content' => $content,
          'embeds' => array_merge($embeds, $lightEmbeds),
          'files' => $files
        ];
    }

    public function parseCustomFields($table) {
      $custom_fields = [];
      // check if first
      if ($table) {
        $previous = $table->previousNonWhitespaceSibling();
        if ($previous->getTag() == 'h1') {
          $rows = $table->find('tr');
          foreach($rows as $row) {
            $key = $row->find('td', 0)->text();
            if ($key != '') {
              $value = $row->find('td', 1)->innerHtml();
              $custom_fields[$key] = $value;
            }
          }
          return $custom_fields;
        }
      }
      return false;
    }

    public function parseJsonCustomFields($table) {
      $custom_fields = [];
      // check if first
      if ($table) {
        $previous = $table->previousNonWhitespaceSibling();
        if ($previous->getTag() == 'h1') {
          $keys = [];
          $headers = $table->find('th');
          foreach($headers as $header) {
            $keys[] = $header->text();
          }
          $rows = $table->find('tr');
          foreach($rows as $row_idx => $row) {
            $test = $row->find('td', 0)->text();
            if ($test != '') {
              $tmp = [];
              $tmp['idx'] = $row_idx;
              foreach($keys as $idx => $key) {
                $tmp[$key] = $row->find('td', $idx)->text();
              }
              $custom_fields[] = $tmp;
            }
          }
          return $custom_fields;
        }
      }
      return false;
    }

    public function parseContent($content, $title) {
      $parsedown = new Parsedown();
      $params = [];
      $files = [];
      $embeds = [];
      $custom_fields = false;
      $decoded = base64_decode($content['content']);
      $parsed = $this->parseGitbookAdvSyntax($decoded);
      foreach($parsed['embeds'] as $embed) {
        $e_args = [
          'url' => $embed[1]
        ];
        if (array_key_exists(2, $embed)) {
          $e_args['title'] = trim($embed[2]);
        }
        $embed = Embed::create($e_args);
        array_push($embeds, $embed);
      }
      foreach($parsed['files'] as $file) {
        $original_path = $file[1];
        if (substr($original_path, 0, 4 ) !== "http") {
          $original_path = env('GITHUB_REPO_PUBLIC_URL')
            . dirname($content['path']) . '/' . $original_path;
        }
        $attachment = Attachment::create([
          'title' => $file[2],
          'file' => $original_path
        ]);
        array_push($files, $attachment);
        $parsed['content'] = str_replace(
          '<div class="file" alt="' . $file[2] . '" src="' . $file[1] . '"></div>',
          '<div class="file"><a target="_blank" href="' . $attachment->file . '" download>'. $file[2] .'</a></div>',
          $parsed['content']
        );
        // Update links in HTML
      }
      // Save and link Images
      $draft_html = $parsedown->toHtml($parsed['content']);
      $dom = HtmlDomParser::str_get_html($draft_html);
      if ($title == 'About') {
        $sentences = $this->parseJsonCustomFields(
          $dom->findOneOrFalse('table')
        );
        if ($sentences) {
          $custom_fields['sentences'] = $sentences;
        }
      } elseif ($title == 'FAQ') {
        $faqs = $this->parseJsonCustomFields(
          $dom->findOneOrFalse('table')
        );
        if ($faqs) {
          $custom_fields['sentences'] = $faqs;
        }
      } elseif ($title == 'Events') {
        $events = $this->parseJsonCustomFields(
          $dom->findOneOrFalse('table')
        );
        if ($events) {
          Event::whereNotNull('id')->delete();
          foreach($events as $event) {
            $event = Event::create([
              'title' => $event['title'],
              'link' => $event['link'],
              'description' => $event['description'],
              'scheduled_at' => Carbon::createFromTimestamp(strtotime($event['datetime']))->toDateTimeString()
            ]);
          }
        }
      } else {
        $custom_fields = $this->parseCustomFields(
          $dom->findOneOrFalse('table')
        );
      }
      if ($custom_fields) {
        $dom->findOneOrFalse('table')->delete();
        foreach($custom_fields as $key => $value) {
          $params[$key] = $value;
        }
      }


      $html = new HtmlString($dom->html());

      $html = preg_replace_callback(
        '/<img src="(.+)"/mU',
        function($m) {
          return '<img src="' . env('GITHUB_REPO_PUBLIC_URL') . '.gitbook/assets/' . basename($m[1]). '"';
        },
        $html
      );

      $params['html'] = $html;
      $params['files'] = $files;
      $params['embeds'] = $embeds;
      return $params;
    }

    public function createFromGit($content, $title, $parent) {
      $parsed = $this->parseContent($content, $title);
      $args = [
        'title' => $title,
        'github_path' => $content['path'],
        'sha' => $content['sha'],
        'content' => $parsed['html']
      ];

      $args = $this->setCustomFieldsAsArgs($args, $parsed);

      if ($parent) {
        $args['course_id'] = $parent->id;
      }

      $entity = $this->create($args);

      $this->setTags($entity, $parsed);
      $this->attachAttachments($entity, $parsed);
      $this->setEmbeds($entity, $parsed);
      return $entity;
    }

    public function updateFromGit($content, $entity, $title, $parent) {
      echo 'Update';
      $parsed = $this->parseContent($content, $title);
      $args = [
        'title' => $title,
        'github_path' => $content['path'],
        'sha' => $content['sha'],
        'content' => $parsed['html'],
      ];

      $args = $this->setCustomFieldsAsArgs($args, $parsed);

      if ($parent) {
        $args['course_id'] = $parent->id;
      }
      $entity->update($args);

      $this->setTags($entity, $parsed);
      $this->attachAttachments($entity, $parsed);
      $this->setEmbeds($entity, $parsed);
      return $entity;
    }

    public function setCustomFieldsAsArgs($args, $parsed) {
      $available_custom_fields = [
        'teacher', 'estimated_time', 'difficulty', 'featured',
        'subtitle', 'intro', 'scheduled_at', 'sentences'
      ];
      $dates = ['scheduled_at'];
      foreach($available_custom_fields as $cf) {
        if (array_key_exists($cf, $parsed)) {
          if (in_array($cf, $dates)) {
            $parsed[$cf] = Carbon::createFromTimestamp(strtotime($parsed[$cf]))->toDateTimeString();
          }
          $args[$cf] = $parsed[$cf];
        }
      }
      return $args;
    }

    public function setTags($entity, $parsed) {
      $tagModels = [];
      if (array_key_exists('topics', $parsed)) {
        $tags = explode(',', $parsed['topics']);
        foreach($tags as $tag) {
          $t = Topic::firstOrCreate(['title' => trim($tag)]);
          if ($t) {
            $tagModels[] = $t->id;
          }
        }
        $entity->topics()->syncWithoutDetaching($tagModels);
      }
    }

    public function attachAttachments($entity, $parsed) {
      if (method_exists($entity, 'attachments')) {
        $entity->attachments()->delete();
        if (array_key_exists('files', $parsed)) {
          foreach($parsed['files'] as $embed) {
            $className = get_class($entity);
            $baseClass = strtolower(class_basename($className));
            $embed->$baseClass()->associate($entity);
            $embed->save();
          }
        }
      }
    }

    public function setEmbeds($entity, $parsed) {
      if (method_exists($entity, 'embeds')) {
        $entity->embeds()->delete();
        $embedsIds = [];
        if (array_key_exists('embeds', $parsed)) {
          foreach($parsed['embeds'] as $embed) {
            $className = get_class($entity);
            $baseClass = strtolower(class_basename($className));
            $embed->$baseClass()->associate($entity);
            $embed->save();
          }
        }
      }

    }

    public function actionFromGit($content, $title, $parent) {
      $entity = $this->where('github_path', $content['path'])->first();
      if (is_null($entity)) {
        return $this->createFromGit($content, $title, $parent);
      } else if ($content['sha'] != $entity->sha) {
        return $this->updateFromGit($content, $entity, $title, $parent);
      }
    }

}
