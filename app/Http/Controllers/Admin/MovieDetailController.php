<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MovieDetail;

class MovieDetailController extends Controller
{
    public function store(Request $request, $movieId)
    {
        $request->validate([
            'name_detail' => 'required|string|max:255',
            'link' => 'required|string',
        ]);

        // Lấy orders cao nhất của phim này
        $maxOrder = MovieDetail::where('movie_id', $movieId)->max('orders');
        $nextOrder = $maxOrder ? $maxOrder + 1 : 1;

        MovieDetail::create([
            'movie_id' => $movieId,
            'name_detail' => $request->name_detail,
            'link' => $request->link,
            'orders' => $nextOrder,
        ]);

        return back()->with('success', 'Thêm tập mới thành công');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_detail' => 'required|string|max:255',
            'link' => 'required|string',
            'orders' => 'nullable|integer',
        ]);

        $detail = MovieDetail::findOrFail($id);
        $detail->update($request->only(['name_detail', 'link', 'orders']));

        return back()->with('success', 'Cập nhật tập thành công');
    }

    public function destroy($id)
    {
        $detail = MovieDetail::findOrFail($id);
        $detail->delete();

        return back()->with('success', 'Xóa tập thành công');
    }
}
