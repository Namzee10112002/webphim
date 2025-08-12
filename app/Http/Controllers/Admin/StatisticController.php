<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\User;
use App\Models\MovieLike;
use App\Models\Comment;

class StatisticController extends Controller
{
    public function index()
    {
        // Tổng lượt xem tất cả phim
        $totalViews = Movie::sum('likes');

        // Tổng lượt thích tất cả phim
        $totalLikes = MovieLike::count();

        // Tổng lượt bình luận
        $totalComments = Comment::count();

        // Tổng số phim đang hiển thị và đang ẩn
        $moviesVisible = Movie::where('status_movie', 0)->count();
        $moviesHidden = Movie::where('status_movie', 1)->count();

        // Tổng số user role = 0 (người dùng thường)
        $totalUsers = User::where('role', 0)->count();
        $usersActive = User::where('role', 0)->where('status_user', 0)->count();
        $usersBlocked = User::where('role', 0)->where('status_user', 1)->count();

        // Top phim được xem nhiều nhất
        $topViewMovies = Movie::orderBy('likes', 'desc')
            ->take(5)
            ->get();

        // Top phim được thích nhiều nhất
        $topLikeMovies = Movie::withCount('movieLikes')
            ->orderBy('movie_likes_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.pages.statistics.index', compact(
            'totalViews',
            'totalLikes',
            'totalComments',
            'moviesVisible',
            'moviesHidden',
            'totalUsers',
            'usersActive',
            'usersBlocked',
            'topViewMovies',
            'topLikeMovies'
        ));
    }
}
