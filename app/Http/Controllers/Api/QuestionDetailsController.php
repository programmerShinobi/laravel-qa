<?php

namespace App\Http\Controllers\Api;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
    public function index(Question $question)
    {
        if ($question) {
            $question->increment('views');
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
