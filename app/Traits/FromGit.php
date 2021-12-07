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

    public function parseContent($content) {
      $content = $content['content'];
      $decoded = base64_decode($content);
      $html = new HtmlString(
        app(Parsedown::class)->setSafeMode(true)->text($decoded)
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
