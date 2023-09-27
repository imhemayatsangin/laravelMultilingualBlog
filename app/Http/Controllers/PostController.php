<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Requests\StoreTransPostRequest;
use App\Http\Requests\UpdateTransPostRequest;
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


        // Initialize flags to track success in both parts
        $postSuccess = false;
        $languagesSuccess = false;
        // Start a database transaction
        DB::beginTransaction();
        try {
            // 1. Create a new post
            $post = Post::create($request->all());
            // Set the flag for post success
            $postSuccess = true;
            // 2. Attach languages to the post
            if ($language != '') {
                $post->languages()->attach($language, [
                    'title' => $title,
                    'content' => $content,
                    'publish_date' => $publish_date,
                    'publish_time' => $publish_time,
                    'status' => $status,
                ]);
                // Set the flag for languages success
                $languagesSuccess = true;
            }
            // If both parts were successful, commit the transaction
            if ($postSuccess && $languagesSuccess) {
                DB::commit();
                return redirect()->route('posts.index');
            } else {
                // If either part failed, rollback the transaction
                DB::rollback();
                return back()->with('error', 'An error occurred while saving the data.');
            }
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction and handle the exception
            DB::rollback();
            // You can log or handle the exception here
            // For example, you can return an error message to the user
            return back()->with('error', 'An error occurred while saving the data.');
        }
        // $post = Post::create($request->all());
        // if ($language != '') {
        //     $post->languages()->attach($language, ['title' => $title, 'content' => $content, 'publish_date' => $publish_date, 'publish_time' => $publish_time, 'status1' => $status]);
        // }
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
        // $post->languages()->sync($request->input('languages', []));
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

    public function addtranslation(StoreTransPostRequest $request)
    {

        $post_id = $request->input('post_id');
        $language = $request->input('languages');
        $title = $request->input('title');
        $content = $request->input('content');
        $publish_date = $request->input('publish_date');
        $publish_time = $request->input('publish_time');
        $status =  $request->input('status');

        $post = Post::where('id', $post_id)->first();



        if ($language != '') {
            $post->languages()->attach($language, ['title' => $title, 'content' => $content, 'publish_date' => $publish_date, 'publish_time' => $publish_time, 'status' => $status]);
        }



        $posts = Post::with(['user', 'languages'])->get();

        return view('posts.index', compact('posts'));
    }

    public function storeCKEditorImages(Request $request)
    {

        $model         = new Post();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function showtrans($post_id, $lang_id)
    {

        // Retrieve the data from the language_post table where post_id and language_id match
        $data = DB::table('language_post')
            ->where('post_id', $post_id)
            ->where('language_id', $lang_id)
            ->join('posts', 'language_post.post_id', '=', 'posts.id')
            ->join('languages', 'language_post.language_id', '=', 'languages.id')
            ->select('posts.main_title', 'languages.name', 'language_post.title', 'language_post.content', 'language_post.publish_date', 'language_post.publish_time', 'language_post.status')
            ->first();

        // dd($posts);
        return view('posts.showtrans', compact('data'));
    }
    public function edittrans($post_id, $lang_id)
    {

        $post = Post::with(['user', 'languages'])->findOrFail($post_id);

        // Retrieve the language_post entries for the specified post_id
        $translatedLanguages = DB::table('language_post')
            ->where('post_id', $post_id)
            ->pluck('language_id');

        // Remove the currently edited language from the list of translated languages
        $translatedLanguages = $translatedLanguages->reject(function ($language) use ($lang_id) {
            return $language == $lang_id;
        });

        // Retrieve all available languages that are not in the list of translated languages
        $availableLanguages = Language::whereNotIn('id', $translatedLanguages)->pluck('name', 'id');

        // If the selected language is not in available languages, add it
        if (!$availableLanguages->has($lang_id)) {
            $availableLanguages->put($lang_id, $post->languages->find($lang_id)->name);
        }



        // Retrieve the data from the language_post table where post_id and language_id match
        $data = DB::table('language_post')
            ->where('post_id', $post_id)
            ->where('language_id', $lang_id)
            ->join('posts', 'language_post.post_id', '=', 'posts.id')
            ->join('languages', 'language_post.language_id', '=', 'languages.id')
            ->select('language_post.post_id', 'language_post.language_id', 'posts.main_title', 'languages.name', 'language_post.title', 'language_post.content', 'language_post.publish_date', 'language_post.publish_time', 'language_post.status')
            ->first();

        // dd($posts);
        return view('posts.edittrans', compact('data', 'availableLanguages'));
    }

    public function updateTrans(UpdateTransPostRequest $request)
    {
        $post_id = $request->input('post_id');
        $language_id = $request->input('language_id'); //this id is when we sending language id for edit to find a record with this id here.

        $lang_id = $request->input('lang_id'); // this id is select option language id
        $title = $request->input('title');
        $content = $request->input('content');
        $publish_date = $request->input('publish_date');
        $publish_time = $request->input('publish_time');
        $status = $request->input('status');

        // Find the specific language_post record to update
        $languagePost = DB::table('language_post')
            ->where('post_id', $post_id)
            ->where('language_id', $language_id)
            ->first();

        // Check if the record exists
        if (!$languagePost) {
            return redirect()->route('posts.edittrans', [$post_id, $language_id])
                ->with('success', 'Translation not updated.');
        }

        if ($languagePost) {

            // Update the language_post record with the new values
            DB::table('language_post')
                ->where('post_id', $post_id)
                ->where('language_id', $language_id)
                ->update([
                    'language_id' => $lang_id,
                    'title' => $title,
                    'content' => $content,
                    'publish_date' => $publish_date,
                    'publish_time' => $publish_time,
                    'status' => $status,
                ]);
        }
        // Redirect back to the edit page or any other  page
        return redirect()->route('posts.edittrans', [$post_id, $lang_id])
            ->with('success', 'Translation updated successfully');
    }

    public function deleteTrans($post_id, $lang_id)
    {
        // Retrieve the specific language_post record to delete
        $languagePost = DB::table('language_post')
            ->where('post_id', $post_id)
            ->where('language_id', $lang_id)
            ->first();

        // Check if the record exists
        if (!$languagePost) {
            $posts = Post::with(['user', 'languages'])->get();
            return view('posts.index', compact('posts'))->with('error', 'Translation not found');
        }

        // Delete the language_post record
        DB::table('language_post')
            ->where('post_id', $post_id)
            ->where('language_id', $lang_id)
            ->delete();


        $posts = Post::with(['user', 'languages'])->get();
        return view('posts.index', compact('posts'))->with('success', 'Translation deleted successfully');
    }
}
