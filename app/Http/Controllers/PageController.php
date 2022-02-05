<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Course;
use App\Models\Workshop;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
      $page = Page::findBySlugOrFail($slug);
      $sentences = [];
      $courses = [];
      $workshops = [];
      $faqs = [];
      if ($page->template === 'home') {
        $about = Page::findBySlugOrFail('about');
        $faq = Page::findBySlugOrFail('faq');
        $courses = Course::with('topics')->get();
        $workshops = Workshop::with('topics')->get();
        if ($about) {
          $sentences = $about->sentences;
        }
        if ($faq) {
          $faqs = $faq->sentences;
        }
      }
      return inertia('Page/Show', compact(
        'page', 'courses', 'workshops', 'sentences', 'faqs'
      ));
    }

    public function home()
    {
      return $this->show('home');
    }
}
