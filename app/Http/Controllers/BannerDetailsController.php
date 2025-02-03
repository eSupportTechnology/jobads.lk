<?php

namespace App\Http\Controllers;

use App\Models\BannerDetail;
use Illuminate\Http\Request;

class BannerDetailsController extends Controller
{

    public function create()
    {
        $post = BannerDetail::first();
        return view('Admin.banner.Details.create', compact('post'));
    }
    // Store a new banner detail
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'effective_date' => 'required',
            'mbsize' => 'required',
            'cbsize' => 'required',
            'description_one' => 'required',
            'description_two' => 'required',
            'description_three' => 'required',
        ]);

        $post = BannerDetail::first();

        if ($post) {
            $post->update([
                'email' => $request->email,
                'effective_date' => $request->effective_date,
                'mbsize' => $request->mbsize,
                'cbsize' => $request->cbsize,
                'description_one' => $request->description_one,
                'description_two' => $request->description_two,
                'description_three' => $request->description_three,
            ]);
        } else {
            $post = BannerDetail::create([
                'email' => $request->email,
                'effective_date' => $request->effective_date,
                'mbsize' => $request->mbsize,
                'cbsize' => $request->cbsize,
                'description_one' => $request->description_one,
                'description_two' => $request->description_two,
                'description_three' => $request->description_three,
            ]);
        }

        return back()->with('success', 'Package details added successfully.');
    }

    // Fetch all banner details
    public function index()
    {
        $banners = BannerDetail::all();
        return view('User.banner.index', compact('banners'));
    }

    // Show a specific banner detail
    public function show($id)
    {
        $banner = BannerDetail::findOrFail($id);
        return response()->json($banner);
    }

    // Update a specific banner detail
    public function update(Request $request, $id)
    {
        $banner = BannerDetail::findOrFail($id);

        $request->validate([
            'title' => 'required|unique:banner_details,title,' . $banner->id,
            'description_one' => 'required',
            'description_two' => 'required',
            'description_three' => 'required',
            'is_active' => 'boolean',
        ]);

        $banner->update($request->all());

        return redirect()->route('bannerdetails.create')->with('success', 'Banner created successfully!');
    }

    // Delete a specific banner detail
    public function destroy($id)
    {
        $banner = BannerDetail::findOrFail($id);
        $banner->delete();

        return redirect()->route('bannerdetails.create')->with('success', 'Banner created successfully!');
    }
}
