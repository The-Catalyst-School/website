<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Course;
use App\Models\Workshop;
use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PageController extends Controller
{
    public function show($slug)
    {
      $page = Page::findBySlugOrFail($slug);
      $sentences = [];
      $courses = [];
      $workshops = [];
      $faqs = [];
      $events = [];
      $e_workshops = [];
      if ($page->template === 'home') {
        $about = Page::findBySlugOrFail('about');
        $faq = Page::findBySlugOrFail('faq');
        $courses = Course::with('topics', 'lessons', 'comments.user', 'users:avatar_url')->get();
        $workshops = Workshop::with('topics')->get();
        $start = Carbon::now()->format('Y-m-d H:i:s');
        $end = Carbon::now()->addMonths(1)->format('Y-m-d H:i:s');
        $events = Event::whereBetween('scheduled_at', [$start, $end])->get();
        $e_workshops = Workshop::whereBetween('scheduled_at', [$start, $end])->get();
        $sentences = $page->sentences;
        if ($faq) {
          $faqs = array_slice($faq->sentences, 0, 6);
        }
      }
      return inertia('Page/Show', compact(
        'page', 'courses', 'workshops', 'sentences', 'faqs', 'events', 'e_workshops'
      ));
    }

    public function home()
    {
      return $this->show('home');
    }
}
