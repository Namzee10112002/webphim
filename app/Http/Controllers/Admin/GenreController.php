<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::orderBy('id', 'desc')->get();
        return view('admin.pages.genres.index', compact('genres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_genre' => 'required|string|max:255'
        ]);

        Genre::create([
            'name_genre' => $request->name_genre,
            'status_genre' => 0
        ]);

        return redirect()->route('admin.genres.index')->with('success', 'Thêm thể loại thành công.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_genre' => 'required|string|max:255'
        ]);

        $genre = Genre::findOrFail($id);
        $genre->update([
            'name_genre' => $request->name_genre
        ]);

        return redirect()->route('admin.genres.index')->with('success', 'Cập nhật thể loại thành công.');
    }

    public function toggleStatus($id)
    {
        $genre = Genre::findOrFail($id);
        $genre->status_genre = $genre->status_genre == 0 ? 1 : 0;
        $genre->save();

        return response()->json([
            'success' => true,
            'status_genre' => $genre->status_genre
        ]);
    }
}
