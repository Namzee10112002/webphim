<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Comment;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
{
    $movies = Movie::withCount('comments')
        ->orderBy('id', 'desc')
        ->get();

    return view('admin.pages.reviews.index', compact('movies'));
}

public function show($movieId)
{
    $movie = Movie::findOrFail($movieId);

    $comments = Comment::with(['user', 'movieDetail'])
        ->whereHas('movieDetail', function($q) use ($movieId) {
            $q->where('movie_id', $movieId);
        })
        ->orderBy('id', 'desc')
        ->get();

    return view('admin.pages.reviews.show', compact('movie', 'comments'));
}

public function toggleStatus($id)
{
    $comment = Comment::findOrFail($id);
    $comment->status_comment = $comment->status_comment ? 0 : 1;
    $comment->save();

    return response()->json([
        'success' => true,
        'status' => $comment->status_comment
    ]);
}

}

