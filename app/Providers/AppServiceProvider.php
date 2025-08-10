<?php

namespace App\Providers;

use App\Models\Genre;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $genres = Genre::orderBy('name_genre')->get();

    // Chia sẻ biến $genres cho tất cả view
    View::share('genres', $genres);
    }
}
