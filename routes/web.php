<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\WelcomeController;

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

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);
// Post
// Route::get('/posts/{id}', 'PostController@translate')->name('posts.translate');

Route::get('/posts-translate/{id}', [App\Http\Controllers\PostController::class, 'translate'])->name('posts.translate');

Route::post('/posts-addtranslation', [App\Http\Controllers\PostController::class, 'addtranslation'])->name('posts.addtranslate');


// translation rows routes
Route::get('/posts/show-trans/{id},{langid}', [App\Http\Controllers\PostController::class, 'showtrans'])->name('posts.showtrans');
Route::get('/posts/edit-trans/{id},{langid}', [App\Http\Controllers\PostController::class, 'edittrans'])->name('posts.edittrans');
Route::post('/posts-updatetrans', [App\Http\Controllers\PostController::class, 'updatetrans'])->name('posts.updatetrans');
Route::delete('/posts/delete-trans/{id},{langid}', [App\Http\Controllers\PostController::class, 'deletetrans'])->name('posts.deletetrans');

Route::resource('/posts', App\Http\Controllers\PostController::class);




// Route::post('posts/media', 'PostController@storeMedia')->name('posts.storeMedia');
Route::post('posts/ckmedia', 'PostController@storeCKEditorImages')->name('posts.storeCKEditorImages');
// Language

// Route::resource('languages', 'LanguageController');
Route::resource('/languages', App\Http\Controllers\LanguageController::class);
