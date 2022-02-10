<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index($date = null)
    {
      if ($date) {
        $query_date = Carbon::createFromTimestamp(strtotime($date));
        $start = $query_date->startOfMonth()->format('Y-m-d H:i:s');
        $end = $query_date->endOfMonth()->format('Y-m-d H:i:s');
        $events = Event::whereBetween('scheduled_at', [$start, $end])->get();
        $workshops = Workshop::whereBetween('scheduled_at', [$start, $end])->get();
      } else {
        $events = Event::all();
        $workshops = Workshop::all();
      }
      return inertia('Event/Calendar', compact('date','events', 'workshops'));
    }

}
