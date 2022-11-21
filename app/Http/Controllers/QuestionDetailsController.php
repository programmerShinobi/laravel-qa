<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\QuestionDetailsResource;

class QuestionDetailsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Question $question)
    {
        $question->increment('views');

        if ($question) {
            return response()->json([
                'success' => true,
                'message' => 'Question Details !',
                'data'    => new QuestionDetailsResource($question)
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Question Not Found!',
                'data'    => ''
            ], 404);
        }
    }
}
