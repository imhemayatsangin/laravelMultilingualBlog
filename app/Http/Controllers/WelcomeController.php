<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    //
    public function index()
    {
        $posts = Post::with(['user', 'languages'])->get();


        return view('welcome', compact('posts'));
    }
}
