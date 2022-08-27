<?php

namespace App;

use App\User;
use Parsedown;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'category', 'content', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['content'] = $value;
        $this->attributes['catagory'] = $value;
        $this->attributes['status'] = $value;
        $this->attributes['title'] = $value;
    }

    public function getUrlAttribute()
    {
        return route("posts.show", $this->id);
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        if ($this->status > 'Draft') {
            return $this->status("Draft");
        } else {
            return $this->status("Publish");
        }
    }

    public function getContentHtmlAttribute()
    {
        return Parsedown::instance()->text($this->content);
    }
}
