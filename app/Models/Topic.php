<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Workshop;

class Topic extends Model
{
    use HasFactory;
    use Sluggable;
    use SluggableScopeHelpers;
    use \App\Traits\Seo;

    protected $fillable = [
      'slug', 'title'
    ];
    protected $hidden = ['pivot', 'slug', 'created_at', 'updated_at'];

    // Relationships
    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class);
    }

    public function workshops()
    {
        return $this->belongsToMany(Workshop::class);
    }
}
