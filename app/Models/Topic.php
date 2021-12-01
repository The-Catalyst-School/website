<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Workshop;

class Topic extends Model
{
    use HasFactory;

    // Relationships
    public function courses()
    {
        return $this->belongsTo(Course::class);
    }

    public function lessons()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function workshops()
    {
        return $this->belongsTo(Workshop::class);
    }
}
