<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index($date = null)
    {
      if ($date) {
        $query_date = Carbon::createFromTimestamp(strtotime($date));
        $start = $query_date->startOfMonth()->format('Y-m-d H:i:s');
        $end = $query_date->endOfMonth()->format('Y-m-d H:i:s');
      } else {
        $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');
      }
      $events = Event::whereBetween('scheduled_at', [$start, $end])->get();
      $workshops = Workshop::whereBetween('scheduled_at', [$start, $end])->get();
      return inertia('Event/Calendar', compact('date','events', 'workshops'));
    }

    public function list($date = null)
    {
      if ($date) {
        $query_date = Carbon::createFromTimestamp(strtotime($date));
        $start = $query_date->startOfMonth()->format('Y-m-d H:i:s');
        $end = $query_date->endOfMonth()->format('Y-m-d H:i:s');
      } else {
        $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');
      }
      $events = Event::whereBetween('scheduled_at', [$start, $end])->get();
      $workshops = Workshop::whereBetween('scheduled_at', [$start, $end])->get();
      return inertia('Event/List', compact('date','events', 'workshops'));
    }

    public function subscribe($id)
    {
        Auth::user()->events()->attach($id);
        return Redirect::back()->with('success', 'Event Subscribed!');
    }

    public function unsubscribe($id)
    {
        Auth::user()->events()->detach($id);
        return Redirect::back()->with('success', 'Event Unsubscribed!');
    }

}
