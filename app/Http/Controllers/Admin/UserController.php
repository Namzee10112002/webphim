<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MovieLike;
use App\Models\Comment;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount([
            'movieLikes as likes_count',
            'comments as comments_count'
        ])->where('role', 0)->get();

        return view('admin.pages.users.index', compact('users'));
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status_user = $user->status_user == 0 ? 1 : 0;
        $user->save();

        return response()->json([
            'success' => true,
            'status_user' => $user->status_user
        ]);
    }
}
