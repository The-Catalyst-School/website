<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Page extends Model
{
    use HasFactory;
    use Sluggable;
    use SluggableScopeHelpers;
    use \App\Traits\Seo;
    use \App\Traits\FromGit;

    protected $fillable = [
      'title', 'content', 'sha', 'github_path', 'sentences'
    ];

    protected $casts = [
      'sentences' => 'object'
    ];
}
