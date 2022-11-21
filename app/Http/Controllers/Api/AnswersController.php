<?php

namespace App\Http\Controllers\Api;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\AnswerResource;
use Illuminate\Support\Facades\Validator;

class AnswersController extends Controller
{
    public function index(Question $question)
    {
        $answers = $question->answers()->with('user')->where(function ($q) {
            if (request()->has('excludes')) {
                $q->whereNotIn('id', request()->query('excludes'));
            }
        })->simplePaginate(3);

        return response([
            'success' => true,
            'message' => 'List All Answers',
            'question' => $question->title,
            'data' => AnswerResource::collection($answers),
            'links' => $answers,
            'meta' => $answers,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question, Request $request)
    {

        //validate data
        $validator = Validator::make(
            $request->all(),
            ['body'   => 'required',],
            ['body.required'     => 'Enter Answer Body  !',]
        );

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Please Fill in the Empty Columns',
                'data'    => $validator->errors()
            ], 400);
        } else {

            $answer = $question->answers()->create($request->only('body') + ['user_id' => Auth::id()]);

            if ($question) {
                if (env('APP_ENV') == 'local') sleep(2);
                return response()->json([
                    'success' => true,
                    'message' => 'Your answer has been submitted!',
                    'questionTitle' => $question->title,
                    'answer' => new AnswerResource($answer->load('user')),
                ], 200);
            } else {
                if (env('APP_ENV') == 'local') sleep(2);
                return response()->json([
                    'success' => false,
                    'message' => 'Your answer has not been submitted!',
                    'questionTitle' => $question->title,
                    'answer' => new AnswerResource($answer->load('user')),
                ], 400);
            }
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question, Answer $answer)
    {
        Gate::authorize('update', $answer);

        //validate data
        $validator = Validator::make(
            $request->all(),
            ['body'   => 'required'],
            ['body.required'     => 'Enter Question Body  !']
        );

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Please Fill in the Empty Columns',
                'data'    => $validator->errors()
            ], 400);
        } else {

            $answer->update($request->only('body'));

            if ($answer) {
                return response()->json([
                    'success' => true,
                    'message' => 'Your answer has been Updated!',
                    'questionTitle' => $question->title,
                    'answer' => new AnswerResource($answer),
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Your answer has not been Updated!',
                    'questionTitle' => $question->title,
                    'answer' => '',
                ], 400);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Answer $answer)
    {
        Gate::authorize('delete', $answer);

        $answer->delete();

        if ($answer) {
            return response()->json([
                'success' => true,
                'question' => $question->title,
                'answer' => $answer->body,
                'message' => 'Answer Deleted Successfully !',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'question' => $question->title,
                'answer' => $answer->body,
                'message' => 'Answer Failed to Delete !',
            ], 500);
        }

    }
}
