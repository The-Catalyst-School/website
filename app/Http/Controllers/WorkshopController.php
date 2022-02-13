<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use App\Models\Topic;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WorkshopController extends Controller
{

    public function index(Request $request)
    {
      $filter_topics = $request->input('topics');
      $filter_month = $request->input('month');
      $workshops = Workshop::with('topics');
      if ($filter_month) {
        $query_date = Carbon::createFromTimestamp(strtotime($filter_month));
        $start = $query_date->startOfMonth()->format('Y-m-d H:i:s');
        $end = $query_date->endOfMonth()->format('Y-m-d H:i:s');
        $workshops = $workshops->whereBetween('scheduled_at', [$start, $end]);
      }
      if ($filter_topics) {
        $workshops = $workshops->whereHas('topics', function($query) use ($filter_topics) {
          $query->whereIn('topics.id', $filter_topics);
        });
      }
      $workshops = $workshops->get();
      $all_workshops = Workshop::all();
      $topics = Topic::whereHas('workshops', function($query) use ($all_workshops) {
        $query->whereIn('workshops.id', $all_workshops->pluck('id')->unique());
      })->get();
      $months = $all_workshops->pluck('scheduled_at')->map(function($el) {
        return Carbon::createFromTimestamp(strtotime($el))->format('Y-m');
      })->unique();
      if ($filter_topics) {
        $filter_topics = Topic::whereIn('id', $filter_topics)->get();
      }
      return inertia(
        'Workshop/List',
        compact('workshops', 'topics', 'months', 'filter_month', 'filter_topics')
      );
    }

    public function show($slug)
    {
      $workshop = Workshop::with('embeds', 'attachments')
        ->whereSlug($slug)->firstOrFail();
      $related = Workshop::where('id', '!=', $workshop->id)->take(3)->get();
      return inertia('Workshop/Show', compact('workshop', 'related'));
    }
}
