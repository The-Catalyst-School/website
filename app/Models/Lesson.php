<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Course;
use App\Models\Topic;
use App\Models\Quiz;

class Lesson extends Model
{
    use HasFactory;

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function topics()
    {
        return $this->belongsTo(Topic::class);
    }

    public function quizzes()
    {
        return $this->belongsTo(Quiz::class);
    }
}
