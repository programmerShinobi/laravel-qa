<?php
namespace App\Models;

use App\Models\User;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

trait VotableTrait
{
    use HasApiTokens, HasFactory;

    public function votes()
    {
        return $this->morphToMany(User::class, 'votable');
    }

    public function downVotes()
    {
        return $this->votes()->wherePivot('vote', -1);
    }

    public function upVotes()
    {
        return $this->votes()->wherePivot('vote', 1);
    }
}
