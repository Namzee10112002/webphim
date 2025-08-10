<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Country;
use App\Models\MovieDetail;
use Illuminate\Http\Request;
use App\Models\MovieLike;
use App\Models\WatchList;
use Illuminate\Support\Facades\Auth;


class UserMovieController extends Controller
{
    public function index(Request $request)
    {
        // Lấy tất cả thể loại & quốc gia để render checkbox
        $genres = Genre::orderBy('name_genre')->get();
        $countries = Country::orderBy('name_country')->get();

        // Min và Max năm
        $minYear = Movie::min('year_release');
        $maxYear = Movie::max('year_release');

        // Query phim
        $query = Movie::with(['genres', 'countries'])->where('status_movie', 0);

        // Lọc theo tên
        if ($request->filled('search')) {
            $query->where('name_movie', 'like', '%' . $request->search . '%');
        }

        // Lọc theo năm (range)
        if ($request->filled('year_min') && $request->filled('year_max')) {
            $query->whereBetween('year_release', [$request->year_min, $request->year_max]);
        }

        // Lọc theo thể loại
        if ($request->filled('genres')) {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->whereIn('genres.id', $request->genres);
            });
        }

        // Lọc theo quốc gia
        if ($request->filled('countries')) {
            $query->whereHas('countries', function ($q) use ($request) {
                $q->whereIn('countries.id', $request->countries);
            });
        }

        if ($request->filled('is_series') && $request->is_series !== '') {
        $query->where('is_series', $request->is_series);
    }

        // Lấy danh sách phim
        $movies = $query->paginate(12)->appends($request->all());

        return view('user.pages.movies-list', compact(
            'movies',
            'genres',
            'countries',
            'minYear',
            'maxYear'
        ));
    }
    public function show($id)
{
    $movie = Movie::with(['genres', 'countries', 'movieLikes'])
              ->withCount('movieLikes')
              ->findOrFail($id);
    $movie->clicks += 1;        
    $movie->save(); 

    $episodes = MovieDetail::where('movie_id', $id)
                ->orderBy('orders')
                ->get();
$userCheckLike = MovieLike::where('user_id', Auth::id())
                ->firstWhere('movie_id', $id);
    // Nếu chỉ 1 tập → chuyển thẳng sang trang watch
    if ($episodes->count() === 1) {
        return redirect()->route('movies.watch', [$id, $episodes->first()->id]);
    }

    return view('user.pages.movie-show', compact('userCheckLike', 'movie', 'episodes'));
}

public function watch($id, $episodeId)
{
    $movie = Movie::with(['genres', 'countries', 'movieLikes'])
              ->withCount('movieLikes')
              ->findOrFail($id);
    $movie->clicks += 1;        
    $movie->save();           
    $episodes = MovieDetail::where('movie_id', $id)
                ->orderBy('orders')
                ->get();
    $userCheckWatchList = WatchList::where('user_id', Auth::id())
                ->firstWhere('movie_detail_id', $episodeId);
    $userCheckLike = MovieLike::where('user_id', Auth::id())
                ->firstWhere('movie_id', $id);
    $currentEpisode = $episodes->firstWhere('id', $episodeId);

    // Lấy comment theo movie_detail
    $comments = Comment::where('movie_detail_id', $episodeId)
                ->orderBy('id')
                ->get();

    return view('user.pages.movie-watch', compact('userCheckWatchList', 'userCheckLike', 'movie', 'episodes', 'currentEpisode', 'comments'));
}

public function toggleLike($movieId)
{
    if (!Auth::check()) {
        return redirect()->route('auth')->with('error', 'Bạn cần đăng nhập để thích phim.');
    }

    $like = MovieLike::where('user_id', Auth::id())
                     ->where('movie_id', $movieId)
                     ->first();

    if ($like) {
        $like->delete();
        $movie = Movie::findOrFail($movieId);
         return response()->json([
        'movie_likes_count' => $movie->movieLikes()->count(),
        'clear' => 1
    ]);
    } else {
        MovieLike::create([
            'user_id' => Auth::id(),
            'movie_id' => $movieId
        ]);
        $movie = Movie::findOrFail($movieId);
         return response()->json([
        'movie_likes_count' => $movie->movieLikes()->count(),
        'clear' => 0
    ]);
    }

            
}

public function toggleWatchList($movieDetailId)
{
    if (!Auth::check()) {
        return redirect()->route('auth')->with('error', 'Bạn cần đăng nhập để thêm vào danh sách xem sau.');
    }

    $item = WatchList::where('user_id', Auth::id())
                     ->where('movie_detail_id', $movieDetailId)
                     ->first();

    if ($item) {
        $item->delete();
        return response()->json([
            'message' => 'Cập nhật danh sách xem sau thành công',
            'clear' => 1
        ]);
    } else {
        WatchList::create([
            'user_id' => Auth::id(),
            'movie_detail_id' => $movieDetailId
        ]);
        return response()->json([
        'message' => 'Cập nhật danh sách xem sau thành công',
        'clear' => 0
    ]);
    }

    
}

public function postComment(Request $request, $movieDetailId)
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để bình luận.');
    }

    $request->validate([
        'content' => 'required|string|max:1000'
    ]);

    Comment::create([
        'user_id' => Auth::id(),
        'movie_detail_id' => $movieDetailId,
        'content' => $request->content
    ]);

   $comments = Comment::with(['user'])->where('movie_detail_id', $movieDetailId)->OrderBy('comments.id')->get();

    return response()->json(['comments' => $comments]);
}

}
