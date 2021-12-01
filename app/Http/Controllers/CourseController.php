<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
      $courses = Course::all();
      return inertia('Course/List', compact('courses'));
    }

    public function show($slug)
    {
      $course = Course::with('lessons')->whereSlug($slug)->firstOrFail();
      return inertia('Course/Show', compact('course'));
    }

}
