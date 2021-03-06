<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GrahamCampbell\GitHub\GitHubManager;
use App\Models\Page;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Workshop;
use voku\helper\HtmlDomParser;
use Erusev\Parsedown\Parsedown;

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
    protected $signature = 'gitbook:pull';

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
      $parsedown = new Parsedown();
      $content = $content['content'];
      $decoded = base64_decode($content);
      $html = $parsedown->toHtml($decoded);
      return $html;
    }

    public function createLesson($entry, $parent, $idx) {
      $lesson = new Lesson;
      $resource = $this->exploreFile($entry['path']);
      $lesson = $lesson->actionFromGit($resource, $entry['title'], $parent, $idx);
    }

    public function createCourses($tree) {
      $courses_ids = [];
      foreach ($tree as $entry) {
        $course = new Course;
        $resource = $this->exploreFile($entry['path']);
        $course = $course->actionFromGit($resource, $entry['title'], false, false);

        foreach ($entry['children'] as $idx => $child) {
          $this->createLesson($child, $course, $idx);
        }
        array_push($courses_ids, $entry['path']);
      }
      // Collect all old courses and lessons and delete them
      // if not present anymore.
      Course::whereNotIn('github_path', $courses_ids)->delete();
    }

    public function createWorkshops($tree) {
      $workshops_ids = [];
      foreach ($tree as $entry) {
        $workshop = new Workshop;
        $resource = $this->exploreFile($entry['path']);
        $workshop = $workshop->actionFromGit($resource, $entry['title'], false, false);
        array_push($workshops_ids, $entry['path']);
      }
      // Collect all old courses and lessons and delete them
      // if not present anymore.
      Workshop::whereNotIn('github_path', $workshops_ids)->delete();
    }

    public function createPages($tree) {
      foreach ($tree as $entry) {
        $page = new Page;
        $resource = $this->exploreFile($entry['path']);
        $page = $page->actionFromGit($resource, $entry['title'], false, false);

      }
      // Collect all old courses and lessons and delete them
      // if not present anymore.
    }

    public function exploreFile($path)
    {
        $resource = $this->github->repository()
          ->contents()
          ->show($this->organization, $this->repo, $path);

        return $resource;
    }

    public function baseParseEntry($entry)
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
          }
        }
      }
      return $parsedEntry;

    }

    public function parseEntry($entry)
    {
      $parsedEntry = false;
      if (is_a($entry, 'voku\helper\SimpleHtmlDom')) {
        if ($entry->tagName == 'li') {
          $link = $entry->findOneOrFalse('a');
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
        $parsedPages = [];
        $parsedCourses = [];
        $parsedWorkshops = [];
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
          $sections = $websiteTree->childNodes();
          foreach($sections as $section) {
            $parsedSection = $this->baseParseEntry($section);
            if ($parsedSection) {
              if ($parsedSection['title'] == 'Home') {
                $this->info('Parsing Home page...');
                $parsedAbout = $this->parseEntry($section);
                array_push($parsedPages, $parsedAbout);
              }
              if ($parsedSection['title'] == 'About') {
                $this->info('Parsing About page...');
                $parsedAbout = $this->parseEntry($section);
                array_push($parsedPages, $parsedAbout);
              }
              if ($parsedSection['title'] == 'Workshops') {
                $this->info('Parsing Workshops...');
                $childrenList = $section->findOneOrFalse('ul');
                if ($childrenList) {
                  $children = $childrenList->find('li');
                  foreach($children as $child) {
                    $parsedWorkshop = $this->parseEntry($child);
                    if ($parsedWorkshop) {
                      if (count($parsedWorkshop['children']) == 0) {
                        array_push($parsedWorkshops, $parsedWorkshop);
                      }
                    }
                  }
                }
              }
              if ($parsedSection['title'] == 'Courses') {
                $this->info('Parsing Courses...');
                $childrenList = $section->findOneOrFalse('ul');
                if ($childrenList) {
                  $children = $childrenList->find('li');
                  foreach($children as $child) {
                    $parsedCourse = $this->parseEntry($child);
                    if ($parsedCourse) {
                      if (count($parsedCourse['children']) > 0) {
                        array_push($parsedCourses, $parsedCourse);
                      }
                    }
                  }
                }
              }
              if ($parsedSection['title'] == 'FAQ') {
                $this->info('Parsing FAQ...');
                $parsedFaq = $this->parseEntry($section);
                array_push($parsedPages, $parsedFaq);
              }
              if ($parsedSection['title'] == 'Events') {
                $this->info('Parsing Events...');
                $parsedEvents = $this->parseEntry($section);
                array_push($parsedPages, $parsedEvents);
              }
            }
          }
        }
        $this->createCourses($parsedCourses);
        $this->createWorkshops($parsedWorkshops);
        $this->createPages($parsedPages);
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
