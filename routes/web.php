<?php

use App\Http\Controllers\TinyMceImageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Add MediaLibrary routes to support temporary file uploads.
 */
Route::mediaLibrary();

Route::get('/', 'HomeController@index');
Route::post('/tinymce/image', [TinyMceImageController::class, 'store'])->name('tinymce.image.store');
