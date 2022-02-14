<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

use App\Models\Lesson;
use App\Models\Topic;
use App\Models\Attachment;
use App\Models\Embed;
use App\Models\Image;
use App\Models\Comment;
use App\Models\User;

class Course extends Model
{
    use HasFactory;
    use Sluggable;
    use SluggableScopeHelpers;
    use \App\Traits\Seo;
    use \App\Traits\FromGit;

    protected $fillable = [
      'title', 'content', 'sha', 'github_path', 'teacher',
      'estimated_time', 'difficulty', 'featured', 'subtitle'
    ];

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
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
