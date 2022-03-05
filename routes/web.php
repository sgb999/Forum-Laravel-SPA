<?php

use App\Http\Controllers\{
    Index,
    UserController,
    CategoryController,
    PostController,
    CommentController
};
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

Route::inertia('/', 'home')->name('home');
Route::get('/categories', [CategoryController::class, 'index']);
Route::controller(PostController::class)->group(function (){
    Route::get('/view-topics/{id}', 'viewTopics')->name('viewTopics');
    Route::get('/view-topics-ajax/{id}', 'viewTopicsAjax');
    Route::get('/view-profile-posts/{id}', 'getProfilePosts');
    Route::get('/view-post/{id}', 'viewPost')->name('viewPost');
});
Route::get('/comment/view/{id}', [CommentController::class, 'getComments']);
Route::get('/profile/{user:username}', [UserController::class, 'profile']);

Route::middleware(['auth'])->group(function(){
    Route::controller(CommentController::class)->group(function (){
        Route::post('/comment/','store');
        Route::put('/comment/{comment}','edit');
        Route::delete('/comment/{comment}', 'destroy');
    });
    Route::get('/profile/update/{user:username}', [UserController::class, 'updateProfilePage']);
    Route::put('/profile/update/{user}', [UserController::class, 'updateProfile']);
    Route::get('/log-out', [UserController::class, 'logOutMethod']);

    //Post routing
    Route::prefix('/post')->controller(PostController::class)->group(function () {
        Route::get('/', 'postPage');
        Route::post('/', 'store');
        Route::get('/update/{post}', 'updatePostPage');
        Route::post('/update-post/{id}', 'edit')->name('updatePost');
        Route::delete('/{post}', 'destroy');
    });
});

Route::middleware(['guest'])->controller(UserController::class)->group(function(){
    Route::inertia('/login', 'Login')->name('login');
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::inertia('/register', 'Register');
});
