<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function show($c_slug, $l_slug)
    {
      $lesson = Course::whereSlug($c_slug)
        ->firstOrFail()->lessons()->with('course')
        ->whereSlug($l_slug)->firstOrFail();
      return inertia('Lesson/Show', compact('lesson'));
    }
}
