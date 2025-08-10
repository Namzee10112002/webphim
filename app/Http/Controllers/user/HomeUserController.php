<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;

class HomeUserController extends Controller
{
    public function index()
    {
        $latestMovies = Movie::getLatestActive();
        $mostViewedMovies = Movie::getMostView();
        return view('user.pages.home', compact('latestMovies', 'mostViewedMovies'));
    }
}
