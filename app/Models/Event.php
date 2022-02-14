<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

use App\Models\User;

class Event extends Model
{
    use HasFactory;
    use Sluggable;
    use SluggableScopeHelpers;
    use \App\Traits\Seo;

    protected $fillable = [
      'title', 'slug', 'link', 'description', 'scheduled_at', 'short_title', 'special'
    ];

    protected $appends = ['subscribed'];

    public function getSubscribedAttribute()
    {
        $user = Auth::user();
        if ($user) {
          $res = (bool) $user->whereHas('events', function ($query) {
            $query->where('event_id', $this->id);
          })->count();
          return $res;
        }
        return false;
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
