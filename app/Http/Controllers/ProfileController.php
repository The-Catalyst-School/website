<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function overview()
    {
      $user = Auth::user()->makeVisible('email');
      $courses = $user->courses()->with('topics')->limit(1)->get();
      $workshops = $user->workshops()->with('topics')->limit(1)->get();
      $events = $user->events()->where('scheduled_at', '>=', Carbon::now())->get();
      $e_workshops = $user->workshops()->where('scheduled_at', '>=', Carbon::now())->get();
      return inertia('Profile/Overview', compact(
        'user', 'courses', 'events', 'workshops', 'e_workshops'
      ));
    }

    public function courses()
    {
      $user = Auth::user();
      $courses = $user->courses()->with('topics')->get()->unique();
      return inertia('Profile/Courses', compact(
        'user', 'courses'
      ));
    }

    public function workshops()
    {
      $user = Auth::user();
      $workshops = $user->workshops()->with('topics')->get();
      return inertia('Profile/Workshops', compact(
        'user', 'workshops'
      ));
    }

    public function comments()
    {
      $user = Auth::user();
      $comments = $user->comments()->with('user')->get();
      return inertia('Profile/Comments', compact(
        'user', 'comments'
      ));
    }

    public function createAvatar()
    {
        $user = Auth::user();
        return inertia('Profile/Avatar', compact('user'));
    }

    public function storeAvatar(Request $request)
    {
        $user = Auth::user();
        $avatar = $request->input('avatar');
        $user->avatar = $avatar;
        if ($avatar) {
          $user->avatar_url = '/images/avatars/' . $avatar['eyes'] . '-' . $avatar['mouth'] . '.svg';
        }
        if ($user->save()) {
          return Redirect::back()->with('success', 'Avatar updated!');
        } else {
          return Redirect::back()->with('error', 'Error saving avatar!');
        }
    }
}
