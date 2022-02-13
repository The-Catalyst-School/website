<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Workshop;
use App\Models\User;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'user_id'];

    protected static function booted()
    {
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'desc');
        });
    }

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
