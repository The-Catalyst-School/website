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
      $courses = [];
      $workshops = [];
      if ($page->template === 'home') {
        $courses = Course::with('topics')->get();
        $workshops = Workshop::with('topics')->get();
      }
      return inertia('Page/Show', compact('page', 'courses', 'workshops'));
    }

    public function home()
    {
      return $this->show('home');
    }
}
