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
      $course = Course::findBySlugOrFail($slug);
      return inertia('Course/Show', compact('course'));
    }

}
