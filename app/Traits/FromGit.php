<?php

namespace App\Traits;

use App\Models\Course;
use App\Models\Attachment;
use App\Models\Topic;
use Illuminate\Support\HtmlString;
use voku\helper\HtmlDomParser;
use Erusev\Parsedown\Parsedown;

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
          '<div class="hint is-$2">$3</div>',
          $content
        );
        // Complete embed detection
        $embeds = [];
        preg_match(
          '/{% embed url="(.+)" %}([\S\s]+){% endembed %}/mU',
          $content,
          $embeds
        );
        $content = preg_replace(
          '/{% embed url="(.+)" %}([\S\s]+){% endembed %}/mU',
          '<div class="embed" alt="$2" src="$1"></div>',
          $content
        );
        // Light embed detection
        $lightEmbeds = [];
        preg_match(
          '/{% embed url="(.+)" %}/mU',
          $content,
          $lightEmbeds
        );
        $content = preg_replace(
          '/{% embed url="(.+)" %}/mU',
          '<div class="embed" src="$1"></div>',
          $content
        );

        // Complete file detection
        $files = [];
        preg_match_all(
          '/{% file src="(.+)" %}([\S\s]+){% endfile %}/mU',
          $content,
          $files
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

    public function parseContent($content) {
      $parsedown = new Parsedown();
      $params = [];
      $files = [];
      $decoded = base64_decode($content['content']);
      $parsed = $this->parseGitbookAdvSyntax($decoded);
      foreach($parsed['embeds'] as $embed) {
        // Create and link model Embed
      }
      foreach($parsed['files'][1] as $file) {
        $original_path = $file;
        if (substr($original_path, 0, 4 ) !== "http") {
          $original_path = env('GITHUB_REPO_PUBLIC_URL')
            . dirname($content['path']) . '/' . $original_path;
        }
        $attachment = Attachment::create([
          'title' => $file,
          'file' => $original_path
        ]);
        array_push($files, $attachment);
        // Update links in HTML
      }
      // Save and link Images
      $draft_html = $parsedown->toHtml($parsed['content']);
      $dom = HtmlDomParser::str_get_html($draft_html);
      $custom_fields = $this->parseCustomFields(
        $dom->findOneOrFalse('table')
      );

      if ($custom_fields) {
        $dom->findOneOrFalse('table')->delete();
        foreach($custom_fields as $key => $value) {
          $params[$key] = $value;
        }
      }

      $html = new HtmlString($dom->html());
      $params['html'] = $html;
      $params['files'] = $files;
      return $params;
    }

    public function createFromGit($content, $title, $parent) {
      $parsed = $this->parseContent($content);
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

      foreach($parsed['files'] as $file) {
        $file->course()->associate($entity);
        $file->save();
      }
      return $entity;
    }

    public function updateFromGit($content, $entity, $title, $parent) {
      echo 'Update';
      $parsed = $this->parseContent($content);
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

      foreach($parsed['files'] as $file) {
        $file->course()->associate($entity);
        $file->save();
      }
      return $entity;
    }

    public function setCustomFieldsAsArgs($args, $parsed) {
      $available_custom_fields = [
        'teacher', 'estimated_time', 'difficulty', 'featured', 'subtitle'
      ];
      foreach($available_custom_fields as $cf) {
        if (array_key_exists($cf, $parsed)) {
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

    public function actionFromGit($content, $title, $parent) {
      $entity = $this->where('github_path', $content['path'])->first();
      if (is_null($entity)) {
        return $this->createFromGit($content, $title, $parent);
      } else if ($content['sha'] != $entity->sha) {
        return $this->updateFromGit($content, $entity, $title, $parent);
      }
    }

}
