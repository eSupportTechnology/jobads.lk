<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Application;
use App\Models\Banner;
use App\Models\Employer;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class AdminAuthController extends Controller
{

    public function adminList()
    {
        $admins = Admin::all(); // Fetch all admins
        return view('Admin.adminlist', compact('admins')); // Pass admins to the view
    }

// Method to toggle active/inactive status
    public function toggleStatus($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->is_active = !$admin->is_active; // Toggle status
        $admin->save();

        return redirect()->back()->with('success', 'Admin status updated successfully');
    }
    // Show the login form
    public function showLoginForm()
    {
        return view('Admin.login'); // Ensure you have a view at resources/views/admin/login.blade.php
    }

    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $admin = Admin::where('email', $credentials['email'])->first();

        if (!$admin || !Auth::guard('admin')->validate($credentials)) {
            return back()->withErrors(['email' => 'Invalid credentials']);
        }

        // Check if the account is active or the role is 'super_admin'
        if (!$admin->is_active && $admin->role !== 'super_admin') {
            return back()->withErrors(['email' => 'Your account is inactive. Please contact the super admin.']);
        }

        // Log in the admin
        Auth::guard('admin')->login($admin);

        return redirect()->route('admin.dashboard');
    }

    // Handle logout
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    // Show the registration form
    public function showRegisterForm()
    {
        return view('admin.register'); // Ensure you have a view at resources/views/admin/register.blade.php
    }

    // Handle admin registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8|confirmed',
            'contact' => 'nullable|string|max:20',
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'contact' => $request->contact,
            'is_active' => false, // Default inactive
            'role' => 'admin', // Default role
        ]);

        return redirect()->route('admin.login')->with('success', 'Admin registered successfully. Please wait for activation by the super admin.');
    }

    // Dashboard (example)
    // public function dashboard()
    // {
    //     return view('Admin.dashboard'); // Ensure you have a view at resources/views/admin/dashboard.blade.php
    // }
    public function getDashboardStatistics()
    {
        try {
            // Get current date for calculations
            $currentDate = now();

            // Check if required tables and columns exist
            if (!Schema::hasTable('job_postings')) {
                throw new \Exception("Job postings table does not exist");
            }

            if (!Schema::hasColumn('job_postings', 'view_count')) {
                throw new \Exception("view_count column missing in job_postings table");
            }

            // Initialize variables with default values
            $totalApplications = 0;
            $totalJobsPosted = 0;
            $totalJobseekers = 0;
            $totalCompanies = 0;
            $totalEarnings = 0;
            $recentApplications = 0;
            $totalViews = 0;
            $totalAdmins = 0;
            $totalSuperAdmins = 0;
            $totalJobs = 0;
            $totalPendingJobs = 0;
            $totalApprovedJobs = 0;
            $totalBanners = 0;
            $totalPendingBanners = 0;
            $totalApprovedBanners = 0;
            $totalCurrentBanners = 0;
            $totalBannerEarnings = 0;

            // Get total applications count if table exists
            if (Schema::hasTable('applications')) {
                $totalApplications = Application::count();
            }

            // Get total active job postings
            if (Schema::hasTable('job_postings')) {
                $totalJobsPosted = JobPosting::where('status', 'approved')
                    ->where('is_active', true)
                    ->whereDate('closing_date', '>=', $currentDate)
                    ->count();

                // Calculate total views
                $totalViews = JobPosting::sum('view_count');
            }

            if (Schema::hasTable('job_postings')) {
                $totalJobs = JobPosting::count();
            }

            if (Schema::hasTable('job_postings')) {
                $totalPendingJobs = JobPosting::where('status', 'pending')
                    ->whereDate('closing_date', '>=', $currentDate)
                    ->count();
            }

            if (Schema::hasTable('job_postings')) {
                $totalApprovedJobs = JobPosting::where('status', 'approved')
                    ->count();
            }

            if (Schema::hasTable('banners')) {
                $totalBanners = Banner::count();
            }

            if (Schema::hasTable('banners')) {
                $totalApprovedBanners = Banner::where('status', 'published')
                    ->count();
            }

            if (Schema::hasTable('banners')) {
                $totalPendingBanners = Banner::where('status', 'pending')
                    ->count();
            }
            $now = Carbon::now();
            if (Schema::hasTable('banners')) {
                $totalCurrentBanners = Banner::join('banner_packages', 'banners.package_id', '=', 'banner_packages.id')
                ->where('banners.status', 'published')
                ->whereRaw('DATE_ADD(banners.updated_at, INTERVAL banner_packages.duration DAY) >= ?', [$now])
                ->select('banners.*', 'banner_packages.duration')
                ->count();
            }
            if (Schema::hasTable('banners')) {
                $totalBannerEarnings = Banner::join('banner_packages', 'banners.package_id', '=', 'banner_packages.id')
                ->where('banners.status', 'published')
                ->sum('banner_packages.price_lkr');
            }

            // Get total active jobseekers
            if (Schema::hasTable('users')) {
                $totalJobseekers = User::count();
            }

            // Get total active companies
            if (Schema::hasTable('employers')) {
                $totalCompanies = Employer::count();
            }

            // Get total active jobseekers
            if (Schema::hasTable('admins')) {
                $totalAdmins = Admin::count();
            }

            // Get total active jobseekers
            if (Schema::hasTable('admins')) {
                $totalSuperAdmins = Admin::where('role', 'super_admin')->count();
            }

            // Get total earnings
            try {
                $totalEarnings = DB::table('job_postings')
                    ->join('packages', 'job_postings.package_id', '=', 'packages.id')
                    ->where('job_postings.status', 'approved')
                    ->sum('packages.lkr_price');
            } catch (\Exception $e) {
                // \Log::error('Error calculating total earnings: ' . $e->getMessage());
                $totalEarnings = 0;
            }

            // Get recent applications (last 7 days)
            if (Schema::hasTable('applications')) {
                $recentApplications = Application::whereDate('created_at', '>=', $currentDate->copy()->subDays(7))
                    ->count();

                $previousWeekApplications = Application::whereDate('created_at', '>=', $currentDate->copy()->subDays(14))
                    ->whereDate('created_at', '<', $currentDate->copy()->subDays(7))
                    ->count();

                $applicationGrowth = $previousWeekApplications > 0
                ? (($recentApplications - $previousWeekApplications) / $previousWeekApplications) * 100
                : 0;
            } else {
                $recentApplications = 0;
                $applicationGrowth = 0;
            }

            return [
                'total_applications' => $totalApplications,
                'total_jobs_posted' => $totalJobsPosted,
                'total_jobseekers' => $totalJobseekers,
                'total_companies' => $totalCompanies,
                'total_earnings' => $totalEarnings,
                'recent_applications' => $recentApplications,
                'application_growth' => round($applicationGrowth, 2),
                'total_views' => $totalViews, // Include total views
                'total_admins' => $totalAdmins,
                'total_super_admins' => $totalSuperAdmins,
                'total_jobs'=> $totalJobs, 
                'total_pending_jobs'=> $totalPendingJobs,
                'total_approved_jobs'=> $totalApprovedJobs, 
                'total_banners' => $totalBanners,
                'total_pending_banners' => $totalPendingBanners,
                'total_approved_banners' => $totalApprovedBanners,
                'total_current_banners' => $totalCurrentBanners,
                'total_banner_earnings' => $totalBannerEarnings,
            ];

        } catch (\Exception $e) {
            // \Log::error('Error in getDashboardStatistics: ' . $e->getMessage());

            // Return default values to avoid blade template issues
            return [
                'total_applications' => 0,
                'total_jobs_posted' => 0,
                'total_jobseekers' => 0,
                'total_companies' => 0,
                'total_earnings' => 0,
                'recent_applications' => 0,
                'application_growth' => 0,
                'total_views' => 0,
                'total_admins' => 0,
                'total_super_admins' => 0,
                'total_jobs'=> 0, 
                'total_pending_jobs'=> 0,
                'total_approved_jobs'=> 0,
                'total_banners'=> 0, 
                'total_pending_banners' => 0, 
                'total_approved_banners' => 0, 
                'total_current_banners' => 0, 
                'total_banner_earnings' => 0,
            ];
        }
    }

    /**
     * Display admin dashboard
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $currentDate = now();
        $statistics = $this->getDashboardStatistics();

        // Get recent applications submitted by registered users
        $recentApplications = Application::whereDate('created_at', '>=', $currentDate->copy()->subDays(7))
            ->latest()
            ->take(5)
            ->get()
            ->filter(function ($application) {
                // Check if the application is linked to a valid user (registered user)
                return User::where('id', $application->user_id)->exists();
            })
            ->map(function ($application) {
                // Retrieve related data for user and job.company
                $user = User::find($application->user_id);
                $job = JobPosting::find($application->job_id);
                $companyName = $job && $job->company ? $job->company->name : 'N/A';

                return [
                    'id' => $application->id,
                    'applicant_name' => $user ? $user->name : 'N/A',
                    'applicant_email' => $user ? $user->email : 'N/A',
                    'job_title' => $job ? $job->title : 'N/A',
                    'company_name' => $companyName,
                    'status' => $application->status,
                    'created_at' => $application->created_at,
                ];
            });

        return view('Admin.dashboard', compact('statistics', 'recentApplications'));
    }

    public function showProfileForm()
    {
        $admin = Auth::guard('admin')->user();
        return view('Admin.profile', compact('admin'));
    }

    // Handle profile update
    public function updateProfile(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('admins', 'email')->ignore($admin->id),
            ],
            'contact' => 'nullable|string|max:20',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        // Update name and contact
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->contact = $request->contact;

        // Handle password change if new password is provided
        if ($request->filled('new_password')) {
            // Verify current password
            if (!Hash::check($request->current_password, $admin->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }

            // Update to new password
            $admin->password = Hash::make($request->new_password);
        }

        // Save the updates
        $admin->save();

        // Redirect back with success message
        return redirect()->route('admin.profile')
            ->with('success', 'Profile updated successfully');
    }

}
