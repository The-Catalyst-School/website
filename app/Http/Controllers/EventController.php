<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EventController extends Controller
{
    public function index()
    {
      $events = Event::all();
      return inertia('Event/Calendar', compact('events'));
    }

}
