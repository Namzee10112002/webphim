<?php

use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\HomeAdminController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\MovieDetailController;
use App\Http\Controllers\Admin\MovieVariantController;
use App\Http\Controllers\admin\ReviewController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\user\ProfileController;
use App\Http\Controllers\user\UserMovieController;
use App\Http\Controllers\user\WatchListController;
use App\Http\Middleware\CheckAdminOrStaff;
use App\Http\Middleware\CheckUser;
use App\Http\Middleware\CheckLoggedIn;
use App\Http\Middleware\CheckGuest;

Route::get('/', [HomeUserController::class, 'index'])->name( 'home');
Route::post('/chatbot/message', [ChatController::class, 'sendMessage'])->name('chatbot.message');
Route::get('/chatbot/history', [ChatController::class, 'getHistory'])->name('chatbot.history');
Route::get('/movies', [UserMovieController::class, 'index'])->name('movies.index');
Route::get('/movie/{id}', [UserMovieController::class, 'show'])->name('movies.show');
Route::get('/movie/{id}/episode/{episodeId}', [UserMovieController::class, 'watch'])->name('movies.watch');
// Auth routes
Route::middleware([CheckGuest::class])->group(function () {
    Route::get('/auth', [AuthController::class, 'index'])->name('auth');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});
Route::middleware([CheckLoggedIn::class])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
Route::middleware([CheckLoggedIn::class, CheckUser::class])->group(function () {
    Route::post('/movie/{movieId}/like', [UserMovieController::class, 'toggleLike'])->name('movies.like');
Route::post('/movie-detail/{movieDetailId}/watch-list', [UserMovieController::class, 'toggleWatchList'])->name('movies.watchlist');

Route::post('/movie-detail/{movieDetailId}/comment', [UserMovieController::class, 'postComment'])->name('movies.comment');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/watchlist', [WatchListController::class, 'index'])->name('watchlist.index');
});

//route chi truy cập nếu là admin hoặc staff
Route::prefix('admin')->as('admin.')->middleware([CheckLoggedIn::class, CheckAdminOrStaff::class])->group(function () {
    Route::get('/', [HomeAdminController::class, 'index']);
    Route::get('/home', [HomeAdminController::class, 'index'])->name('home');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/toggle-status/{id}', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    Route::get('/genres', [GenreController::class, 'index'])->name('genres.index');
    Route::post('/genres', [GenreController::class, 'store'])->name('genres.store');
    Route::post('/genres/{id}', [GenreController::class, 'update'])->name('genres.update');
    Route::post('/genres/toggle-status/{id}', [GenreController::class, 'toggleStatus'])->name('genres.toggle-status');

    Route::get('/countries', [CountryController::class, 'index'])->name('countries.index');
    Route::post('/countries', [CountryController::class, 'store'])->name('countries.store');
    Route::post('/countries/{id}', [CountryController::class, 'update'])->name('countries.update');
    Route::post('/countries/toggle-status/{id}', [CountryController::class, 'toggleStatus'])->name('countries.toggle-status');

    // Movies
    Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
    Route::post('/movies/toggle-status/{id}', [MovieController::class, 'toggleStatus'])->name('movies.toggle-status');
    Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');
    Route::post('/movies/update/{id}', [MovieController::class, 'update'])->name('movies.update');

    // Movie detail
    Route::post('/movies/{movieId}/details', [MovieDetailController::class, 'store'])->name('movies.details.store');
    Route::post('/movies/details/update/{id}', [MovieDetailController::class, 'update'])->name('movies.details.update');
    Route::post('/movies/details/delete/{id}', [MovieDetailController::class, 'destroy'])->name('movies.details.delete');

    // routes/web.php (bên trong group prefix 'admin' mà bạn đã có)
    Route::post('/movies/variants/toggle', [App\Http\Controllers\Admin\MovieVariantController::class, 'toggle'])
    ->name('movies.variants.toggle');

    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/{movieId}', [ReviewController::class, 'show'])->name('reviews.show');
    Route::post('/reviews/toggle-status/{id}', [ReviewController::class, 'toggleStatus'])->name('reviews.toggle-status');

    Route::get('/statistics', [StatisticController::class, 'index'])->name('statistics.index');

});