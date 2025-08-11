<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('id', 'desc')->get();
        return view('admin.pages.countries.index', compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_country' => 'required|string|max:255'
        ]);

        Country::create([
            'name_country' => $request->name_country,
            'status_country' => 0
        ]);

        return redirect()->route('admin.countries.index')->with('success', 'Thêm quốc gia thành công.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_country' => 'required|string|max:255'
        ]);

        $country = Country::findOrFail($id);
        $country->update([
            'name_country' => $request->name_country
        ]);

        return redirect()->route('admin.countries.index')->with('success', 'Cập nhật quốc gia thành công.');
    }

    public function toggleStatus($id)
    {
        $country = Country::findOrFail($id);
        $country->status_country = $country->status_country == 0 ? 1 : 0;
        $country->save();

        return response()->json([
            'success' => true,
            'status_country' => $country->status_country
        ]);
    }
}
