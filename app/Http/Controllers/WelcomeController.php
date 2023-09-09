<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Language;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    //
    public function index()
    {


        $nav_languages = Language::all();

        $posts = Post::with(['user', 'languages'])->get();


        return view('welcome', compact('posts', 'nav_languages'));
    }
}
