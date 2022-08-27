<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(3);

        return view('posts.index', compact('posts'));
    }
}
