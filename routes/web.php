<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

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

Route::get('/login', 'LoginController@index');
Route::get('/register', 'RegisterController@index');

Auth::routes(['verify' => true]);

Route::middleware('verified')->group(function () {
    $index = 'QuestionsController@index';
    Route::get('/home', $index)->name('home');
    Route::get('/questions/create', $index)->name('questions.create');
    Route::get('/questions/{id}/edit', $index)->name('questions.edit');
    Route::get('/my-posts', $index)->name('my-posts');
});

Route::view('/', 'spa');
$index_guest = 'QuestionsController@index';
Route::get('/questions', $index_guest)->name('questions');
Route::get('/questions/{id}', $index_guest)->name('questions.show');
Route::get('/questions/{slug}', $index_guest)->name('questions.show');