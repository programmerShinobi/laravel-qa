<?php

namespace App;

use Parsedown;

use App\Answer;
use GuzzleHttp\Psr7\LimitStream;
use HTMLPurifier_AttrDef_HTML_Length;
use Illuminate\Cache\RateLimiter;
use Mews\Purifier\Purifier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use LengthException;

class Question extends Model
{
    use VotableTrait;

    protected $fillable = ['title', 'body'];

    protected $appends = ['created_date', 'is_favorited', 'favorites_count', 'body_html'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

    public function setBodyAttribute($value)
    {
         $this->attributes['body'] = $value;
    }

    public function body()
    {
        return $this->setBodyAttribute();
    }

    public function getUrlAttribute()
    {
        return route("questions.show", $this->slug);
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        if ($this->answers_count > 0) {
            if ($this->best_answer_id) {
                return "answered-accepted";
            }
            return "answered";
        }
        return "unanswered";
    }

    public function getBodyHtmlAttribute()
    {
        return clean(\Parsedown::instance()->text($this->body));
    }

    private function bodyHtml()
    {
        return $this->getBodyHtmlAttribute();
    }

    public function answers()
    {
        return $this->hasMany(Answer::class)->orderBy('votes_count', 'DESC');
    }

    public function acceptBestAnswer(Answer $answer)
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps(); //, 'question_id', 'user_id');
    }

    public function isFavorited()
    {
        // return $this->favorites()->where('user_id', auth()->id())->count() > 0;
        return $this->favorites()->where('user_id', request()->user()->id())->count() > 0;
        // return $this->favorites()->where('user_id', auth('api')->id())->count() > 0;
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }
    
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function getExcerptAttribute()
    {
        return $this->excerpt(250);
    }

    public function excerpt($length)
    {
        return str_limit(strip_tags($this->bodyHtml()), $length);        
    }

}
