<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', 'IndexController@index')->name('index');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('posts.index');

// Route::resource('questions', 'QuestionsController')->except('show');

// Route::get('/questions/{slug}', 'QuestionsController@show')->name('questions.show');


Route::resource('posts', 'PostsController')->except('show');

Route::get('/posts/{id}', 'PostsController@show')->name('posts.show');
