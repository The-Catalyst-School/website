<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

use App\Models\Topic;

class Workshop extends Model
{
    use HasFactory;
    use Sluggable;
    use SluggableScopeHelpers;
    use \App\Traits\Seo;

    protected $fillable = ['title'];

    public function topics()
    {
        return $this->belongsToMany(Topic::class);
    }
}
