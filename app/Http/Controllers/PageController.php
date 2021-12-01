<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
      $page = Page::findBySlugOrFail($slug);
      return inertia('Page/Show', compact('page'));
    }

    public function home()
    {
      return $this->show('home');
    }
}
