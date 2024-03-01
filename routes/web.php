<?php

use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\CategoriesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\Admin;

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

Route::group(["middleware" => "auth"], function(){
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
    Route::get('/post/create', [App\Http\Controllers\PostController::class, 'create'])->name('post.create');
    Route::post('/post/store', [App\Http\Controllers\PostController::class, 'store'])->name('post.store');
    Route::delete('/post/delete/{id}', [App\Http\Controllers\PostController::class, 'destroy'])->name('post.delete');
    Route::get('/post/edit/{id}', [App\Http\Controllers\PostController::class, 'edit'])->name('post.edit');
    Route::patch('/post/update/{id}', [App\Http\Controllers\PostController::class, 'update'])->name('post.update');
    Route::get('/post/show/{post}', [App\Http\Controllers\PostController::class, 'show'])->name('post.show');

    Route::post('/comment/store/{post_id}', [App\Http\Controllers\CommentController::class, 'store'])->name('comment.store');
    Route::delete('/comment/delete/{comment}', [App\Http\Controllers\CommentController::class, 'destroy'])->name('comment.delete');

    Route::get('/profile/show/{user_id}', [App\Http\Controllers\UserController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit/{user_id}', [App\Http\Controllers\UserController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update/{user_id}', [App\Http\Controllers\UserController::class, 'update'])->name('profile.update');
    Route::get('/profile/followers/{user_id}', [App\Http\Controllers\UserController::class, 'follower'])->name('profile.follower');
    Route::get('/profile/following/{user_id}', [App\Http\Controllers\UserController::class, 'following'])->name('profile.following');


    Route::post('/like/store', [App\Http\Controllers\LikeController::class, 'store'])->name('like.store');
    Route::delete('/like/delete', [App\Http\Controllers\LikeController::class, 'destroy'])->name('like.delete');

    Route::post('/follow/store', [App\Http\Controllers\FollowController::class, 'store'])->name('follow.store');
    Route::delete('/follow/delete', [App\Http\Controllers\FollowController::class, 'destroy'])->name('follow.delete');

    Route::get('/suggestions', [App\Http\Controllers\HomeController::class, 'all_suggest'])->name('suggestions');

    Route::get('/search', [App\Http\Controllers\HomeController::class, 'search'])->name('search');

    Route::group(['middleware' => 'admin'], function () {
        // 管理者用のルートやコントローラーを定義
        Route::get('/admin/user', [UsersController::class, 'index'])->name('admin.index')->middleware('admin');
        Route::delete('/admin/users/deactivate/{id}',[UsersController::class,'deactivate'])->name('admin.users.deactivate');
        Route::patch('/admin/users/activate/{id}',[UsersController::class,'activate'])->name('admin.users.activate');

        Route::get('/admin/posts', [PostsController::class, 'index'])->name('admin.posts');
        Route::delete('/admin/posts/hide/{id}',[PostsController::class,'hide'])->name('admin.posts.hide');
        Route::patch('/admin/posts/show/{id}',[PostsController::class,'show'])->name('admin.posts.show');

        Route::get('/admin/categories', [CategoriesController::class, 'index'])->name('admin.categories');
        Route::delete('/admin/categories/delete/{id}', [CategoriesController::class, 'delete'])->name('admin.categories.delete');
        Route::post('/admin/categories/store', [CategoriesController::class, 'store'])->name('admin.categories.store');
        Route::patch('/admin/categories/update/{id}',[CategoriesController::class,'update'])->name('admin.categories.update');
    });
});
