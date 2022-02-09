<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EventController extends Controller
{
    public function index()
    {
      $events = Event::get();
      return inertia('Event/List', compact('events'));
    }

}
