<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GrahamCampbell\GitHub\GitHubManager;
use App\Models\Course;
use App\Models\Lesson;
use voku\helper\HtmlDomParser;
use Parsedown;

class PullGitbook extends Command
{
    protected $github;
    protected $organization;
    protected $repo;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pull-gitbook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This commands pulls the content from the Gitbook repo.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(GitHubManager $github)
    {
        $this->github = $github;
        $this->organization = env('GITHUB_GITBOOK_ORG');
        $this->repo = env('GITHUB_GITBOOK_REPO');
        parent::__construct();
    }

    public function parseContent($content) {
      $content = $content['content'];
      $decoded = base64_decode($content);
      $html = app(Parsedown::class)->setSafeMode(true)->text($decoded);
      return $html;
    }

    public function createLesson($entry, $parent) {
      $lesson = new Lesson;
      $resource = $this->exploreFile($entry['path']);
      $lesson = $lesson->actionFromGit($resource, $entry['title'], $parent);
    }

    public function createCourses($tree) {
      foreach ($tree as $entry) {
        $course = new Course;
        $resource = $this->exploreFile($entry['path']);
        $course = $course->actionFromGit($resource, $entry['title'], false);

        foreach ($entry['children'] as $child) {
          $this->createLesson($child, $course);
        }
      }
    }

    public function exploreFile($path)
    {
        $resource = $this->github->repository()
          ->contents()
          ->show($this->organization, $this->repo, $path);

        return $resource;
    }

    public function parseEntry($entry)
    {
      $parsedEntry = false;
      if (is_a($entry, 'voku\helper\SimpleHtmlDom')) {
        if ($entry->tagName == 'li') {
          $link = $entry->findOneOrFalse('a');
          //print_r($link);
          if ($link) {
            $parsedEntry = [
              'title' => $link->text(),
              'path' => $link->getAttribute('href')
            ];
            $childrenList = $entry->findOneOrFalse('ul');
            $parsedChildren = [];
            if ($childrenList) {
              $children = $childrenList->find('li');
              foreach($children as $child) {
                $parsedChild = $this->parseEntry($child);
                if ($parsedChild) {
                  array_push($parsedChildren, $parsedChild);
                }
              }
            }
            $parsedEntry['children'] = $parsedChildren;
          }
        }
      }
      return $parsedEntry;
    }

    public function getWebsiteTree()
    {
        $parsedCourses = [];
        $summary = $this->exploreFile('SUMMARY.md');
        $html_summary = $this->parseContent($summary);
        $dom = HtmlDomParser::str_get_html($html_summary);
        $headings = $dom->find('h2');
        $websiteTree = false;
        foreach ($headings as $index => $heading) {
          if ($heading->nodeValue === 'Website') {
            $websiteTree = $heading->nextNonWhitespaceSibling();
          }
        }
        if ($websiteTree) {
          $courses = $websiteTree->childNodes();
          foreach($courses as $course) {
            $parsedCourse = $this->parseEntry($course);
            if ($parsedCourse) {
              array_push($parsedCourses, $parsedCourse);
            }
          }
        }
        $this->createCourses($parsedCourses);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->getWebsiteTree();
        // $this->exploreTree('website', 0);
        return Command::SUCCESS;
    }
}
