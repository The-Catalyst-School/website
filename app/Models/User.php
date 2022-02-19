<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Comment;
use App\Models\Event;
use App\Models\Course;
use App\Models\Workshop;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'avatar_url'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'avatar' => 'object'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class)
          ->withPivot('current_lesson');
    }

    public function workshops()
    {
        return $this->belongsToMany(Workshop::class);
    }
}
