<?php

namespace App\Http\Controllers\Api;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\AnswerResource;
use Illuminate\Support\Facades\Validator;

class AnswersController extends Controller
{
    public function index(Question $question)
    {
        $answers = $question->answers()->with('user')->simplePaginate(3);

        return response([
            'success' => true,
            'message' => 'List All Answers For Question Title : '. $question->title,
            'data' => AnswerResource::collection($answers)
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
                return response()->json([
                    'success' => true,
                    'message' => 'Your answer has been submitted!',
                    'question' => $question->title,
                    'answer' => new AnswerResource($answer->load('user')),
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Your answer has not been submitted!',
                    'question' => $question->title,
                    'answer' => new AnswerResource($answer->load('user')),
                ], 400);
            }
        }
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);

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
                    'question' => $question->title,
                    'answer' => new AnswerResource($answer),
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Your answer has not been Updated!',
                    'question' => $question->title,
                    'answer' => new AnswerResource($answer),
                ], 400);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Answer $answer)
    {
        $this->authorize('delete', $answer);

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
