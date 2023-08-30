<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);
// Post
// Route::get('/posts/{id}', 'PostController@translate')->name('posts.translate');

Route::get('/posts/{id}', [App\Http\Controllers\PostController::class, 'translate'])->name('posts.translate');

Route::post('/posts/{id}', [App\Http\Controllers\PostController::class, 'addtranslation'])->name('posts.addtranslate');

// Route::resource('posts', 'PostController');
Route::resource('/posts', App\Http\Controllers\PostController::class);


// Route::post('posts/media', 'PostController@storeMedia')->name('posts.storeMedia');
Route::post('posts/ckmedia', 'PostController@storeCKEditorImages')->name('posts.storeCKEditorImages');
// Language

// Route::resource('languages', 'LanguageController');
Route::resource('/languages', App\Http\Controllers\LanguageController::class);
