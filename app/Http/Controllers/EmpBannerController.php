<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\BannerPackage;
use App\Models\Category;
use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EmpBannerController extends Controller
{
    /**
     * Display a listing of the banners.
     */
    public function index()
    {
        $employerId = auth('employer')->id();

        $banners = Banner::where('employer_id', $employerId)
            ->with(['category', 'package', 'admin'])
            ->paginate(10);

        return view('employer.banner.index', compact('banners'));
    }

    public function store(Request $request)
    {
        
            // Validate the request
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'category_id' => 'nullable|exists:categories,id',
                'package_id' => 'required|exists:banner_packages,id',
                'payment_method' => 'required|in:contact_admin,online',
                'placement' => 'required|in:banner,category_page',
            ]);
            $empId = Auth('employer')->id();
            // Start transaction
            DB::beginTransaction();
            try {
            // Handle image upload
            $imagePath = $request->file('image')->store('banner_images', 'public');

            // Create banner
            $banner = Banner::create([
                'title' => $validated['title'],
                'employer_id' => $empId,
                'image' => $imagePath,
                'category_id' => $validated['category_id'],
                'package_id' => $validated['package_id'],
                'payment_method' => $validated['payment_method'],
                'placement' => $validated['placement'],
                'status' => 'pending',
            ]);

            DB::commit();

            // Handle different payment methods
            if ($validated['payment_method'] === 'online') {
                session(['pending_banner_id' => $banner->id]);
                return redirect()->route('payment.checkout');
            }

            return redirect()->route('empbanners.index')
                ->with('success', 'Banner created successfully! Our admin will contact you soon.');

        } catch (\Exception $e) {
            DB::rollBack();

            // Delete uploaded image if exists
            if (isset($imagePath) && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            return redirect()->back()
                ->withErrors(['error' => 'An error occurred while creating the banner. Please try again.'])
                ->withInput();
        }
    }

    public function storeBannerData(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'category_id' => 'nullable|exists:categories,id',
                'package_id' => 'required|exists:banner_packages,id',
                'placement' => 'required|in:banner,category_page',
            ]);

            // Store form data in session for payment processing
            session(['banner_form_data' => $validated]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    /**
     * Show the form for creating a new banner.
     */
    public function create()
    {
        $categories = Category::all();
        $packages = BannerPackage::all();
        return view('employer.banner.create', compact('categories', 'packages'));
    }

    /**
     * Store a newly created banner in storage.
     */

    /**
     * Show the form for editing the specified banner.
     */
    public function edit(Banner $banner)
    {
        $categories = Category::all();
        $packages = BannerPackage::all();
        return view('employer.banner.edit', compact('banner', 'categories', 'packages'));
    }

    /**
     * Update the specified banner in storage.
     */
    public function update(Request $request, $id)
{
    // Validate the request
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'category_id' => 'nullable|exists:categories,id',
        'package_id' => 'required|exists:banner_packages,id',
        'placement' => 'required|in:banner,category_page',
    ]);

    $banner = Banner::findOrFail($id);

    DB::beginTransaction();
    try {
        // Update image if a new one is uploaded
        if ($request->hasFile('image')) {
            if (Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }
            $validated['image'] = $request->file('image')->store('banner_images', 'public');
        }

        // Update the banner
        $banner->update($validated);

        DB::commit();

        return redirect()->route('empbanners.index')
            ->with('success', 'Banner updated successfully!');
    } catch (\Exception $e) {
        DB::rollBack();

        return redirect()->back()
            ->withErrors(['error' => 'An error occurred while updating the banner. Please try again.'])
            ->withInput();
    }
}

    // Controller function
    public function updateStatus(Request $request, Banner $banner)
    {
        // Log initial state
        // \Log::info("Before update:", [
        //     'banner_id' => $banner->id,
        //     'old_status' => $banner->getOriginal('status'),
        //     'attributes' => $banner->getAttributes(),
        // ]);

        // Validate the request
        $request->validate([
            'status' => 'required|in:pending,published,rejected',
            'rejection_reason' => 'required_if:status,rejected|nullable|string|max:1000',
        ]);

        // Update the banner
        $banner->status = $request->status;
        $banner->admin_id = auth('admin')->id(); // Store the current admin's ID

        // Handle rejection reason
        if ($request->status === 'rejected') {
            $banner->rejection_reason = $request->rejection_reason;
        } else {
            $banner->rejection_reason = null; // Clear rejection reason if status is not rejected
        }

        // Track changes
        $isDirty = $banner->isDirty();
        $changes = $banner->getDirty();

        // Save changes
        $saved = $banner->save();

        // Log the update result
        // \Log::info("After update:", [
        //     'banner_id' => $banner->id,
        //     'new_status' => $banner->status,
        //     'admin_id' => $banner->admin_id,
        //     'rejection_reason' => $banner->rejection_reason,
        //     'was_dirty' => $isDirty,
        //     'changes' => $changes,
        //     'save_result' => $saved,
        // ]);

        // Return with appropriate message
        $message = match ($request->status) {
            'published' => 'Banner has been published successfully.',
            'rejected' => 'Banner has been rejected with reason.',
            'pending' => 'Banner has been set to pending.',
            default => 'Status updated successfully.'
        };

        return redirect()->back()->with('success', $message);
    }
    /**
     * Remove the specified banner from storage.
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();
        return redirect()->route('banners.index')->with('success', 'Banner deleted successfully.');
    }
}