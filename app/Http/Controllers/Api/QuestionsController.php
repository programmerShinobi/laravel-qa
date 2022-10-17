<?php

namespace App\Http\Controllers\Api;

use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;
use App\Http\Requests\AskQuestionRequest;
use Illuminate\Support\Facades\Validator;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $question = Question::with('user')->latest()->paginate(10);
        return response([
            'success' => true,
            'message' => 'List All Questions',
            'data' => QuestionResource::collection($question)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate data
        $validator = Validator::make(
            $request->all(),
            [
                'title'  => 'required|max:50',
                'body'   => 'required',
            ],
            [
                'title.required'    => 'Enter Question Title  !',
                'body.required'     => 'Enter Question Body  !',
            ]
        );

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Please Fill in the Empty Columns',
                'data'    => $validator->errors()
            ], 400);
        } else {

            // $question = Question::create([
            //     'title' => $request->input('title'),
            //     'body'  => $request->input('body'),
            // ]);

            $question = $request->user()->questions()->create($request->only('title', 'body'));

            if ($question) {
                return response()->json([
                    'success' => true,
                    'message' => 'Your question has been submitted!',
                    'question' => new QuestionResource($question),
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Your question has not been submitted!',
                    'question' => new QuestionResource($question),
                ], 400);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
    }
}
