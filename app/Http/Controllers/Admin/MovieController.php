<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\MovieDetail;
use App\Models\MovieVariant;
use App\Models\Genre;
use App\Models\Country;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    // Danh sách phim
    public function index()
    {
        $movies = Movie::withCount(['movieLikes', 'movieDetails'])
            ->with(['genres', 'countries'])
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.pages.movies.index', compact('movies'));
    }

    // Toggle status
    public function toggleStatus($id)
    {
        $movie = Movie::findOrFail($id);
        $movie->status_movie = $movie->status_movie == 0 ? 1 : 0;
        $movie->save();

        return response()->json(['status' => $movie->status_movie]);
    }

    // Trang chi tiết phim
    public function show($id)
    {
        $movie = Movie::with(['genres', 'countries', 'movieDetails' => function ($q) {
            $q->orderBy('orders', 'asc');
        }])->findOrFail($id);

        $allGenres = Genre::where('status_genre', 0)->get();
        $allCountries = Country::where('status_country', 0)->get();

        return view('admin.pages.movies.show', compact('movie', 'allGenres', 'allCountries'));
    }

    // Cập nhật thông tin phim
    public function update(Request $request, $id)
    {
        $movie = Movie::findOrFail($id);
        $movie->update($request->all());

        return redirect()->back()->with('success', 'Cập nhật thành công');
    }
}
