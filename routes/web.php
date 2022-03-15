<?php

use App\Http\Controllers\{MessageController,
    UserController,
    CategoryController,
    PostController,
    CommentController,
    ChatController};
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

Route::inertia('/', 'LoadTitles', ['url' => '/view-all-topics/'])->name('home');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::controller(PostController::class)->group(function (){
    Route::get('/view-all-topics/', 'viewAllTopics');
    Route::get('/view-topics/{id}', 'viewTopics')->name('topics.show');
    Route::get('/view-topics-ajax/{id}', 'viewTopicsAjax');
    Route::get('/view-profile-posts/{id}', 'getProfilePosts');
    Route::get('/view-post/{id}', 'viewPost')->name('post.show');
});
Route::get('/comment/view/{id}', [CommentController::class, 'index'])->name('comment.index');
Route::get('/profile/{user:username}', [UserController::class, 'profile'])->name('profile');
Route::get('/profile/user-posts/{id}', [UserController::class, 'getUserPosts']);

Route::middleware(['auth'])->group(function(){
    Route::controller(CommentController::class)
        ->prefix('/comment')->group(function (){
        Route::post('/','store')->name('comment.store');
        Route::put('/{comment}','edit')->name('comment.edit');
        Route::delete('/{comment}', 'destroy')->name('comment.destroy');
    });
    Route::controller(UserController::class)
        ->group(function (){
            Route::get('/log-out', 'logOutMethod')->name('log-out');
            Route::get('/profile/update/{user:username}', 'updateProfilePage')->name('user.index');
            Route::put('/profile/update/{user}', 'updateProfile')->name('user.edit');
            Route::delete('/profile/update{user}', 'destroy')->name('user.destroy');
        });

    Route::inertia('/chats', 'chat')->name('chat.index');
    Route::get('/user-chats', [ChatController::class, 'getChats'])->name('chat.get-chats');
    Route::get('/message/user/{user}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/message', [MessageController::class, 'store'])->name('message.store');
    Route::get('/message{chat}', [MessageController::class, 'index'])->name('message.index');

    //Post routing
    Route::prefix('/post')->controller(PostController::class)->group(function () {
        Route::get('/', 'postPage');
        Route::post('/', 'store')->name('post.store');
        Route::get('/update/{post}', 'updatePostPage')->name('post.edit');
        Route::put('/{post}', 'edit')->name('post.thing');
        Route::delete('/{post}', 'destroy')->name('post.destroy');
    });
});

Route::middleware(['guest'])->controller(UserController::class)->group(function(){
    Route::inertia('/login', 'Login')->name('login.index');
    Route::post('/login', 'login')->name('login.post');
    Route::post('/register', 'register')->name('register.post');
    Route::inertia('/register', 'Register')->name('register.index');
});
