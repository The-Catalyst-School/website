<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Workshop;

class Embed extends Model
{
    use HasFactory;

    protected $fillable = [
      'title', 'url'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }
}
