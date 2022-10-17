<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Api\QuestionsController;

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

Route::post('token', [LoginController::class, 'getToken']);

// routes/api.php
Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('/questions', 'Api\QuestionsController')->except('index');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

