<?php

namespace App\Http\Controllers\Api;

use App\Answer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VoteAnswerController extends Controller
{
    public function __invoke(Answer $answer)
    {
        $vote = (int) request()->vote;

        $votesCount = auth()->user()->voteAnswer($answer, $vote);

        if (request()->expectsJson()) {
            return response()->json([
                'message' => 'Thanks for the feedbacks',
                'answer' => $answer->body,
                'votesCount' => $votesCount,
            ]);
        }

        return back();
    }
}
