<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

use App\Models\Course;
use App\Models\Topic;
use App\Models\Quiz;
use App\Models\Attachment;
use App\Models\Embed;
use App\Models\Image;
use App\Models\Comment;

class Lesson extends Model
{
    use HasFactory;
    use Sluggable;
    use SluggableScopeHelpers;
    use \App\Traits\Seo;
    use \App\Traits\FromGit;

    protected $fillable = [
      'title', 'content', 'sha', 'github_path', 'course_id',
      'seo_description'
    ];
    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class);
    }

    public function quizzes()
    {
        return $this->belongsTo(Quiz::class);
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
}
