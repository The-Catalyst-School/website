<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CourseController extends Controller
{
    public function index(Request $request)
    {
      $courses = Course::with('lessons:title,slug,id,course_id', 'topics', 'comments.user', 'users:avatar_url');
      $filter_topics = $request->input('topics');
      if ($filter_topics) {
        $courses = $courses->whereHas('topics', function($query) use ($filter_topics) {
          $query->whereIn('topics.id', $filter_topics);
        });
      }
      $all_courses = Course::all();
      $topics = Topic::whereHas('courses', function($query) use ($all_courses) {
        $query->whereIn('courses.id', $all_courses->pluck('id')->unique());
      })->get();
      $courses = $courses->get();
      if ($filter_topics) {
        $filter_topics = Topic::whereIn('id', $filter_topics)->get();
      }
      return inertia('Course/List', compact('courses', 'topics', 'filter_topics'));
    }

    public function show($slug)
    {
      $course = Course::with('lessons')
        ->whereSlug($slug)->firstOrFail();
      $lesson = $course->lessons()->firstOrFail();
      return Redirect::route('web.lesson.show', [$slug, $lesson->slug]);
    }

    public function subscribe(Request $request, $id)
    {
        $request->validate([
          'current_lesson' => ['required'],
        ]);
        $lesson = $request->input('current_lesson');
        Auth::user()->courses()->attach($id, ['current_lesson' => $lesson]);
        return Redirect::back()->with('success', 'Lesson registered!');
    }

}
