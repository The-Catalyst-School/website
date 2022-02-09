<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Support\Facades\Storage;

use App\Models\Course;
use App\Models\Lesson;

class Attachment extends Model
{
    use HasFactory;
    use Sluggable;
    use SluggableScopeHelpers;
    use \App\Traits\Seo;

    protected $fillable = [
      'slug', 'title', 'file', 'size'
    ];

    public function setFileAttribute($value)
    {
        $disk = 'public';
        $destination_path = "uploads/attachments";
        if (filter_var($value, FILTER_VALIDATE_URL)) {
          $contents = file_get_contents($value);
          $filename = basename($value);
          Storage::disk($disk)->put($destination_path.'/'.$filename, $contents);
          $path = Storage::url($destination_path.'/'.$filename);
          $this->attributes['file'] = $path;
          if (Storage::exists($this->attributes['file'])) {
            $this->attributes['size'] = Storage::size($this->attributes['file']);
          }
        }
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
        return $this->belongsTo(Lesson::class);
    }
}
