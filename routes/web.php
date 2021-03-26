<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LoginController;

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

/*Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/', [BlogController::class, 'index'])->name('home');
Route::post('/create', [BlogController::class, 'store'])->name('create');
Route::get('/login', [LoginController::class, 'index'])->name('login.form');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/blog/{blog:slug}', [BlogController::class, 'blog'])->name('blog.desc');
Route::post('/comment/{blog}', [CommentController::class, 'store'])->name('comment');
Route::post('/like/{blog}', [BlogController::class, 'like'])->name('like');