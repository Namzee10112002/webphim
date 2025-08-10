<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\user\ProfileController;
use App\Http\Controllers\user\UserMovieController;
use App\Http\Controllers\user\WatchListController;

Route::get('/', [HomeUserController::class, 'index']);

// Auth routes
Route::get('/auth', [AuthController::class, 'index'])->name('auth');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/movies', [UserMovieController::class, 'index'])->name('movies.index');
Route::get('/movie/{id}', [UserMovieController::class, 'show'])->name('movies.show');
Route::get('/movie/{id}/episode/{episodeId}', [UserMovieController::class, 'watch'])->name('movies.watch');

Route::post('/movie/{movieId}/like', [UserMovieController::class, 'toggleLike'])->name('movies.like');
Route::post('/movie-detail/{movieDetailId}/watch-list', [UserMovieController::class, 'toggleWatchList'])->name('movies.watchlist');
Route::post('/movie-detail/{movieDetailId}/comment', [UserMovieController::class, 'postComment'])->name('movies.comment');

// Hiển thị form cập nhật
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

// Xử lý cập nhật
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/watchlist', [WatchListController::class, 'index'])->name('watchlist.index');

Route::post('/chatbot/message', [ChatController::class, 'sendMessage'])->name('chatbot.message');
Route::get('/chatbot/history', [ChatController::class, 'getHistory'])->name('chatbot.history');