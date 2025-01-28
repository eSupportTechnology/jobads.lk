<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Contact;
use App\Models\ContactUs;
use App\Models\Package;
use App\Models\PackageContact;
use Illuminate\Http\Request;

class PackageContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:package_contacts,email',
            'contact' => 'required',
            'description_one' => 'required',
            'description_two' => 'required',
        ]);

        $post = PackageContact::create($request->all());

        return response()->json(['message' => 'Post created successfully!', 'post' => $post], 201);
    }

    // Fetch all posts
    public function index()
    {
        $posts = PackageContact::all();
        $contacts = ContactUs::all();
        $contactsLists = Contact::all();
        $packages = Package::all();
        $banks = BankAccount::all();
        return view('User.postvacancy.postvacancy', compact('posts', 'contacts', 'contactsLists', 'packages', 'banks'));
    }
    public function create()
    {

        return view('Admin.packages.create');
    }
    // Update a specific post
    public function update(Request $request, $id)
    {
        $post = PackageContact::findOrFail($id);

        $request->validate([
            'email' => 'required|email|unique:package_contacts,email,' . $post->id,
            'contact' => 'required',
            'description_one' => 'required',
            'description_two' => 'required',
        ]);

        $post->update($request->all());

        return redirect()->back()->with('success', 'updated successfully.');
    }

    // Delete a specific post
    public function destroy($id)
    {
        $post = PackageContact::findOrFail($id);
        $post->delete();

        return redirect()->back()->with('success', 'Deleted successfully.');
    }
}