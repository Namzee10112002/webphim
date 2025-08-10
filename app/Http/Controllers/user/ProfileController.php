<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ProfileController extends Controller
{
     public function edit()
    {
        $user = Auth::user();
        return view('user.pages.edit-profile', compact('user'));
    }

    // Xử lý cập nhật thông tin
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        // Cập nhật thông tin
        User::where('id', $user->id)->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('profile.edit')->with('success', 'Cập nhật thông tin cá nhân thành công!');
    }
}
