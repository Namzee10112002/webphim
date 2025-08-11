<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MovieVariant;
use App\Models\Movie;

class MovieVariantController extends Controller
{
    /**
     * Toggle a genre or country for a movie. 
     * If checking a genre: create variants (genre,country) for all countries currently assigned to movie.
     * If unchecking a genre: delete all variants for that genre for this movie.
     * Same for country.
     */
    public function toggle(Request $request)
{
    $data = $request->validate([
        'movie_id' => 'required|integer|exists:movies,id',
        'type'     => 'required|in:genre,country',
        'type_id'  => 'required|integer',
        'checked'  => 'required|boolean',
    ]);

    $movieId = $data['movie_id'];
    $type    = $data['type']; // genre hoặc country
    $typeId  = $data['type_id'];
    $checked = (bool)$data['checked'];

    // Lấy danh sách genre và country hiện tại của phim
    $currentGenres = MovieVariant::where('movie_id', $movieId)
                        ->pluck('genre_id')->filter()->unique()->toArray();
    $currentCountries = MovieVariant::where('movie_id', $movieId)
                        ->pluck('country_id')->filter()->unique()->toArray();

    // Nếu đang tick genre mà chưa có country nào -> báo lỗi
    if ($type === 'genre' && $checked && empty($currentCountries)) {
        return response()->json([
            'success' => false,
            'message' => 'Vui lòng chọn ít nhất 1 quốc gia trước khi thêm thể loại.'
        ], 422);
    }

    // Nếu đang tick country mà chưa có genre nào -> báo lỗi
    if ($type === 'country' && $checked && empty($currentGenres)) {
        return response()->json([
            'success' => false,
            'message' => 'Vui lòng chọn ít nhất 1 thể loại trước khi thêm quốc gia.'
        ], 422);
    }

    // Nếu OK thì xử lý như trước
    DB::beginTransaction();
    try {
        if ($type === 'genre') {
            if ($checked) {
                foreach ($currentCountries as $countryId) {
                    MovieVariant::firstOrCreate([
                        'movie_id'   => $movieId,
                        'genre_id'   => $typeId,
                        'country_id' => $countryId,
                    ]);
                }
            } else {
                MovieVariant::where('movie_id', $movieId)
                    ->where('genre_id', $typeId)
                    ->delete();
            }
        } else { // country
            if ($checked) {
                foreach ($currentGenres as $genreId) {
                    MovieVariant::firstOrCreate([
                        'movie_id'   => $movieId,
                        'genre_id'   => $genreId,
                        'country_id' => $typeId,
                    ]);
                }
            } else {
                MovieVariant::where('movie_id', $movieId)
                    ->where('country_id', $typeId)
                    ->delete();
            }
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thành công.',
            'variants' => MovieVariant::where('movie_id', $movieId)->get()
        ]);
    } catch (\Throwable $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Có lỗi xảy ra khi cập nhật.'
        ], 500);
    }
}

}
