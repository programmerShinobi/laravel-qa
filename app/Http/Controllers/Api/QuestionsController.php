<?php

namespace App\Http\Controllers\Api;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\QuestionResource;
use App\Http\Requests\AskQuestionRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\QuestionDetailsResource;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::with('user')->latest()->paginate(5);

        if (env('APP_ENV') == 'local') sleep(2);

        return response([
            'success' => true,
            'message' => 'List All Questions',
            'data' => QuestionResource::collection($questions),
            'links' => $questions,
            'meta'=> $questions,
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
        if (env('APP_ENV') == 'local') sleep(2);

        //validate data
        $validator = Validator::make(
            $request->all(),
            [
                'title'  => 'required|max:255|unique:questions,title,',
                'body'   => 'required',
            ],
            [
                'title.required'    => 'Enter Question Title  !',
                'title.unique'    => 'Duplicate Entry Question Title  !',
                'body.required'     => 'Enter Question Body  !',
            ]
        );

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Please fill in / check again in each column : Required | Duplicate Entry | Title Max:255',
                'data'    => $validator->errors()
            ], 400);
        } else {

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
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $question = Question::whereId($question->id)->first();

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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        Gate::authorize("update", $question);

        //validate data
        $validator = Validator::make(
            $request->all(),
            [
                'title'  => 'required|max:255|unique:questions,title,'. $question->id . ',id',
                'body'   => 'required',
            ],
            [
                'title.required'    => 'Enter Question Title  !',
                'title.unique'    => 'Duplicate Entry Question Title  !',
                'body.required'     => 'Enter Question Body  !',
            ]
        );

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Please fill in / check again in each column : Required | Duplicate Entry | Title Max:255',
                'data'    => $validator->errors()
            ], 400);
        } else {

            $question->update($request->only('title', 'body'));

            if ($question) {
                return response()->json([
                    'success' => true,
                    'message' => 'Your question has been Updated!',
                    'question' => new QuestionDetailsResource($question),
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Your question has not been Updated!',
                    'question' => '',
                ], 400);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        Gate::authorize("delete", $question);

        if (env('APP_ENV') == 'local') sleep(2);

        $question = Question::findOrFail($question->id);
        $question->delete();

        if ($question) {
            return response()->json([
                'success' => true,
                'message' => 'Question Deleted Successfully !',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Question Failed to Delete !',
            ], 500);
        }

    }
}
