<?php

namespace App\Traits;

use App\Models\Course;
use Illuminate\Support\HtmlString;
use Parsedown;

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
        preg_match(
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
        preg_match(
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
          'files' => array_merge($files, $lightFiles)
        ];
    }

    public function parseContent($content) {
      $content = $content['content'];
      $decoded = base64_decode($content);
      $parsed = $this->parseGitbookAdvSyntax($decoded);
      foreach($parsed['embeds'] as $embed) {
        // Create and link model Embed
      }
      foreach($parsed['files'] as $file) {
        // Create and link model File
        // Update links in HTML
      }
      // Save and link Images
      $html = new HtmlString(
        app(Parsedown::class)->setSafeMode(false)->text($parsed['content'])
      );
      return $html;
    }

    public function createFromGit($content, $title, $parent) {
      $args = [
        'title' => $title,
        'github_path' => $content['path'],
        'sha' => $content['sha'],
        'content' => $this->parseContent($content)
      ];

      if ($parent) {
        $args['course_id'] = $parent->id;
      }

      return $this->create($args);
    }

    public function updateFromGit($content, $entity, $title, $parent) {
      echo 'Update';
      $args = [
        'title' => $title,
        'github_path' => $content['path'],
        'sha' => $content['sha'],
        'content' => $this->parseContent($content)
      ];

      if ($parent) {
        $args['course_id'] = $parent->id;
      }
      return $entity->update($args);
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
