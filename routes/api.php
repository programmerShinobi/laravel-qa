<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AnswersController;
use App\Http\Controllers\Api\MyPostsController;
use App\Http\Controllers\Api\FavoritesController;
use App\Http\Controllers\Api\QuestionsController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\VoteAnswerController;
use App\Http\Controllers\Api\AcceptAnswerController;
use App\Http\Controllers\Api\VoteQuestionController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\QuestionDetailsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Auth::routes();

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'store']);
Route::delete('/logout', [LoginController::class, 'destroy'])->middleware('auth:api');

Route::get('/questions', [QuestionsController::class, 'index']);
Route::get('/questions/{question}/answers', [AnswersController::class, 'index']);
Route::get('/questions/{question}-{slug}', [QuestionDetailsController::class, 'index']);

Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('/questions', QuestionsController::class)->except('index');
    Route::apiResource('/questions.answers', AnswersController::class)->except('index');
    Route::post('/questions/{question}/vote', VoteQuestionController::class);
    Route::post('/answers/{answer}/vote', VoteAnswerController::class);
    Route::post('/answers/{answer}/accept', AcceptAnswerController::class)->name('answers.accept');
    Route::post('/questions/{question}/favorites', [FavoritesController::class, 'store'])->name('questions.favorite');
    Route::delete('/questions/{question}/favorites', [FavoritesController::class, 'destroy'])->name('questions.unfavorite');
    Route::get('/my-posts', [MyPostsController::class, 'index']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

