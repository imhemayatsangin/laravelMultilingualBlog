<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreLanguageRequest;


use App\Http\Requests\UpdateLanguageRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\MassDestroyLanguageRequest;



class LanguageController extends Controller
{

    public function switchLang($lang)
    {
        if (array_key_exists($lang, Config::get('languages'))) {
            Session::put('applocale', $lang);
        }
        return Redirect::back();
    }


    public function index()
    {

        $languages = Language::all();

        return view('languages.index', compact('languages'));
    }

    public function create()
    {

        return view('languages.create');
    }

    public function store(StoreLanguageRequest $request)
    {
        $language = Language::create($request->all());

        return redirect()->route('languages.index');
    }

    public function edit(Language $language)
    {

        return view('languages.edit', compact('language'));
    }

    public function update(UpdateLanguageRequest $request, Language $language)
    {
        $language->update($request->all());

        return redirect()->route('languages.index');
    }

    public function show(Language $language)
    {

        // $language->load('languagePosts', 'languagePostcontents');

        return view('languages.show', compact('language'));
    }
    public function destroy(Language $language)
    {

        $language->delete();

        return back();
    }
}
