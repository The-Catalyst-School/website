<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Course;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
      $page = Page::findBySlugOrFail($slug);
      $courses = [];
      if ($page->template === 'home') {
        $courses = Course::with('topics')->get();
      }
      return inertia('Page/Show', compact('page', 'courses'));
    }

    public function home()
    {
      return $this->show('home');
    }
}
