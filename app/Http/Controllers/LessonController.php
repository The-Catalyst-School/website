<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function show($c_slug, $l_slug)
    {
      $lesson = Course::whereSlug($c_slug)
        ->firstOrFail()->lessons()->with('course', 'embeds', 'attachments')
        ->whereSlug($l_slug)->firstOrFail();
      $next = Course::whereSlug($c_slug)
        ->firstOrFail()->lessons()
        ->where('slug', '!=', $l_slug)
        ->where('id', '>', $lesson->id)->first();
      $prev = Course::whereSlug($c_slug)
        ->firstOrFail()->lessons()
        ->where('slug', '!=', $l_slug)
        ->where('id', '<', $lesson->id)->first();
      $related = Course::where('slug', '!=', $c_slug)->take(3)->get();
      return inertia('Lesson/Show', compact('lesson', 'next', 'prev', 'related'));
    }
}
