<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use Illuminate\Http\Request;

class WorkshopController extends Controller
{

    public function index()
    {
      $workshops = Workshop::all();
      return inertia('Workshop/List', compact('workshops'));
    }

    public function show($slug)
    {
      $workshop = Workshop::with('embeds')
        ->whereSlug($slug)->firstOrFail();
      return inertia('Workshop/Show', compact('workshop'));
    }
}
