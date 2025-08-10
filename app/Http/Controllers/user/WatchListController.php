<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\WatchList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class WatchListController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $watchLists = WatchList::where('user_id', $user->id)->with('movieDetail.movie')->get();

        return view('user.pages.watch-list', compact('watchLists'));
    }
}
