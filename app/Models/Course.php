<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Lesson;
use App\Models\Topic;

class Course extends Model
{
    use HasFactory;

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function topics()
    {
        return $this->belongsTo(Topic::class);
    }
}
