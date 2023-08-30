<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Symfony\Component\HttpFoundation\Response;


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


        $language = $request->input('languages');
        $title = $request->input('title');
        $content = $request->input('content');
        $publish_date = $request->input('publish_date');
        $publish_time = $request->input('publish_time');
        $status =  $request->input('status');






        $post = Post::create($request->all());
        if ($language != '') {
            $post->languages()->attach($language, ['title' => $title, 'content' => $content, 'publish_date' => $publish_date, 'publish_time' => $publish_time, 'status' => $status]);
        }






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

    public function translate($id)
    {

        $post = Post::with(['user', 'languages'])->where('id', $id)->first();


        // Retrieve the languages associated with the given post
        $translatedLanguages = Post::findOrFail($id)->languages->pluck('id');

        // Retrieve all languages except the ones associated with the post which is already translated.
        // $availableLanguages = Language::whereNotIn('id', $translatedLanguages)->get();

        $availableLanguages = Language::whereNotIn('id', $translatedLanguages)->pluck('name', 'id');



        // dd($posts);
        return view('posts.translate', compact('post', 'availableLanguages'));
    }

    public function addtranslation($post_id)
    {

        dd($post_id);
    }

    public function storeCKEditorImages(Request $request)
    {

        $model         = new Post();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
