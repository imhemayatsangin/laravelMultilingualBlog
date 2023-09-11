<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class WelcomeController extends Controller
{
    //
    public function index()
    {
        $language = Language::where('code', App::getLocale())->first();
        $language_id = $language->id;

        if ($language) {
            // $posts = $language->languagePosts()->with('user')->where('language_id', $language_id)->get();

            $posts = DB::table('language_post')
                // ->where('post_id', $post_id)
                ->where('language_id', $language_id)
                // ->join('posts', 'language_post.post_id', '=', 'posts.id')
                // ->join('languages', 'language_post.language_id', '=', 'languages.id')
                ->select('language_post.title', 'language_post.content', 'language_post.publish_date', 'language_post.publish_time', 'language_post.status')
                ->get();
        } else {
            // Fallback to the default language if the selected language is not found
            // $posts = Post::with('languagePosts')->get();
        }

        return view('welcome', compact('posts'));
    }
}
