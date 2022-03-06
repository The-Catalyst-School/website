<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

use App\Models\Topic;
use App\Models\Attachment;
use App\Models\Embed;
use App\Models\Image;
use App\Models\Comment;
use App\Models\User;

class Workshop extends Model
{
    use HasFactory;
    use Sluggable;
    use SluggableScopeHelpers;
    use \App\Traits\Seo;
    use \App\Traits\FromGit;

    protected $fillable = [
      'title', 'content', 'sha', 'github_path', 'teacher',
      'estimated_time', 'difficulty', 'featured', 'subtitle', 'intro',
      'scheduled_at', 'seo_description', 'embeds_counter'
    ];

    protected $appends = ['subscribed'];

    public function getSubscribedAttribute()
    {
        $user = Auth::user();
        if ($user) {
          $res = (bool) $user->whereHas('workshops', function ($query) {
            $query->where('workshop_id', $this->id);
          })->count();
          return $res;
        }
        return false;
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function embeds()
    {
        return $this->hasMany(Embed::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
