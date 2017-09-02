<?php

namespace Foro;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = ['title', 'content'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setTitleAttribute($value)
    {
        if ($value) {
            $this->attributes['title'] = $value;
            $this->attributes['slug'] = Str::slug($value);
        }
    }

    public function getUrlAttribute()
    {
        return route('post.show', [$this->id, $this->slug]);
    }
}
