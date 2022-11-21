<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\VoteAnswerController;
use App\Http\Controllers\AcceptAnswerController;
use App\Http\Controllers\VoteQuestionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServi`ceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [LoginController::class, 'index']);
Route::get('/register', [RegisterController::class, 'index']);

Auth::routes(['verify' => true]);
Route::middleware('verified')->group(function () {
    $question = [QuestionsController::class, 'index'];
    // $acceptAnswer = AcceptAnswerController::class;
    // $favorites = FavoritesController::class;
    // $voteQuestion = VoteQuestionController::class;
    // $voteAnswer = VoteAnswerController::class;

    Route::get('/home', $question)->name('home');
    Route::get('/questions/create', $question)->name('questions.create');
    Route::get('/questions/{id}/edit', $question)->name('questions.edit');
    Route::get('/my-posts', $question)->name('my-posts');
    // Route::post('/answers/{answer}/accept', $acceptAnswer);
    // Route::post('/questions/{question}/favorites', [$favorites , 'store']);
    // Route::delete('/questions/{question}/favorites', [$favorites , 'destroy']);
    // Route::post('/questions/{question}/vote', $voteQuestion);
    // Route::post('/answers/{answer}/vote', $voteAnswer);
});

$question_guest = [QuestionsController::class, 'index'];

Route::view('/', 'spa');
Route::get('/questions', $question_guest)->name('questions');
Route::get('/questions/{question}', $question_guest)->name('questions.show');
Route::get('/questions/{slug}', $question_guest)->name('questions.show');
