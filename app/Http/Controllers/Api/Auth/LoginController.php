<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $request->request->add([
            'grant_type' => 'password',
            'client_id' => 2,
            'client_secret' => '6h37X5akdoSSzMw9NMSf0dzSY6P076sIIqa5Wbvt',
            'username' => $request->username,
            'password' => $request->password,
        ]);

        $requestToken = Request::create(env('APP_URL') . '/oauth/token', 'post');
        return Route::dispatch($requestToken);
    }

    public function destroy(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->noContent();
    }
}
