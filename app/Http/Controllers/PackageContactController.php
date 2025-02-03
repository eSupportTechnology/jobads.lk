<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\BannerDetail;
use App\Models\BannerPackage;
use App\Models\Contact;
use App\Models\ContactUs;
use App\Models\Package;
use App\Models\PackageContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PackageContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'effective_date' => 'required',
            'description_one' => 'required|string',
            'description_two' => 'required|string',
            'description_three' => 'required|string',
        ]);

        // Retrieve existing record or create a new one
        $post = PackageContact::first();

        if ($post) {
            $post->update([
                'email' => $request->email,
                'effective_date' => $request->effective_date,
                'description_one' => $request->description_one,  
                'description_two' => $request->description_two,  
                'description_three' => $request->description_three,  
            ]);
        } else {
            $post = PackageContact::create([
                'email' => $request->email,
                'effective_date' => $request->effective_date,
                'description_one' => $request->description_one,  
                'description_two' => $request->description_two,  
                'description_three' => $request->description_three,  
            ]);
        }

        return back()->with('success', 'Package details added successfully.');
    }




    // Fetch all posts
    public function index()
    {
        $packageDetails = PackageContact::first();
        $contacts = ContactUs::all();
        $contactsList = Contact::all();
        $packages = Package::all();
        $localBanks = BankAccount::where('localorforeign', 'local')->get();
        $foreignBanks = BankAccount::where('localorforeign', 'foreign')->get();

        $packageDetailsBanners = BannerDetail::first();
        $packagesBanners = BannerPackage::all();

        return view('User.postvacancy.postvacancy', compact(
            'packageDetails',
            'contacts',
            'contactsList',
            'packages',
            'localBanks',
            'foreignBanks',
            'packageDetailsBanners',
            'packagesBanners'
        ));
    }
    public function create()
    {
        $post = PackageContact::first();
        return view('Admin.packages.Create', compact('post'));
    }
    // Update a specific post
    public function update(Request $request, $id)
    {
        $post = PackageContact::findOrFail($id);

        $request->validate([
            'email' => 'required|email|unique:package_contacts,email,' . $post->id, // Fixed table name
            'contact' => 'required',
            'description_one' => 'required',
            'description_two' => 'required',
            'description_three' => 'required', // Added validation
        ]);

        $post->update($request->all());

        return response()->json(['message' => 'Post updated successfully!', 'post' => $post]);
    }

    // Delete a specific post
    public function destroy($id)
    {
        $post = PackageContact::findOrFail($id);
        $post->delete();

        return response()->json(['message' => 'Post deleted successfully!']);
    }
}
