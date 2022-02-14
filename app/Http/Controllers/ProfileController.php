<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function overview()
    {
      $user = Auth::user();
      $courses = $user->courses;
      $comments = $user->comments;
      $workshops = $user->workshops;
      $events = $user->events;
      return inertia('Profile/Overview', compact(
        'user', 'courses', 'comments', 'events', 'workshops'
      ));
    }
}
