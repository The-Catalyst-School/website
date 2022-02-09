<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CourseController extends Controller
{
    public function index()
    {
      $courses = Course::with('lessons', 'topics')->get();
      return inertia('Course/List', compact('courses'));
    }

    public function show($slug)
    {
      $course = Course::with('lessons', 'topics')
        ->whereSlug($slug)->firstOrFail();
      $lesson = $course->lessons()->firstOrFail();
      return Redirect::route('web.lesson.show', [$slug, $lesson->slug]);
    }

}
