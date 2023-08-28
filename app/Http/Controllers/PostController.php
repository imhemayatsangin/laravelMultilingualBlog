<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    public function index()
    {

        $posts = Post::with(['user', 'languages'])->get();

        return view('posts.index', compact('posts'));
    }

    public function create()
    {

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $languages = Language::pluck('name', 'id');

        return view('posts.create', compact('languages', 'users'));
    }

    public function store(StorePostRequest $request)
    {
        $post = Post::create($request->all());
        $post->languages()->sync($request->input('languages', []));

        return redirect()->route('posts.index');
    }

    public function edit(Post $post)
    {

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $languages = Language::pluck('name', 'id');

        $post->load('user', 'languages');

        return view('posts.edit', compact('languages', 'post', 'users'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->all());
        $post->languages()->sync($request->input('languages', []));

        return redirect()->route('posts.index');
    }

    public function show(Post $post)
    {



        return view('posts.show', compact('post'));
    }

    public function destroy(Post $post)
    {

        $post->delete();

        return back();
    }
}
