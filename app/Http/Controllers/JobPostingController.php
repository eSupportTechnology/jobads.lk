<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Banner;
use App\Models\Category;
use App\Models\ContactUs;
use App\Models\Country;
use App\Models\Employer;
use App\Models\JobPosting;
use App\Models\Package;
use App\Models\Subcategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobPostingController extends Controller
{
    public function index()
    {
        // Fetch all published jobs
        $jobPostings = JobPosting::with(['category', 'subcategory', 'employer'])
            ->where('status', 'approved')
            ->where('is_active', true)
            ->whereDate('closing_date', '>=', now()) // Exclude expired jobs
            ->paginate(10);

        // Fetch all pending jobs
        $pendingJobs = JobPosting::with(['category', 'subcategory', 'employer'])
            ->where('status', 'pending')
            ->where('is_active', true)
            ->whereDate('closing_date', '>=', now()) // Exclude expired jobs
            ->paginate(10);

        // Fetch all rejected jobs
        $rejectedJobs = JobPosting::with(['category', 'subcategory', 'employer'])
            ->where('status', 'reject')
            ->where('is_active', true)
            ->paginate(10); // Rejected jobs are displayed regardless of closing date

        return view('Admin.jobview', compact('jobPostings', 'pendingJobs', 'rejectedJobs'));
    }

    public function topEmployers()
    {
        $contacts = ContactUs::all();
        // Fetch top 28 employers based on job postings count and filter those with a logo
        $topEmployers = Employer::withCount('jobPostings') // Assuming 'jobPostings' is the relationship
           
            ->orderBy('job_postings_count', 'desc') // Sort by the number of job postings
            ->take(28) // Limit to top 28
            ->get();

        // Pass data to the view
        return view('User.topemployees', compact('topEmployers', 'contacts'));
    }
    public function showtopemployerJobs($employerId)
    {
        // Fetch the employer
        $employer = Employer::findOrFail($employerId);
        $contacts = ContactUs::all();

        // Fetch jobs posted by this employer
        $jobs = JobPosting::where('employer_id', $employer->id)
            ->where('status', 'approved') // Optional: only show approved jobs
            ->get();

        // Return a view with the employer and their jobs
        return view('User.topemployerjob', compact('employer', 'jobs', 'contacts'));
    }

    public function generateJobAdsReport()
    {
        // Daily jobs with details and earnings
        $dailyCount = DB::table('job_postings')
            ->join('employers', 'job_postings.employer_id', '=', 'employers.id')
            ->leftJoin('packages', 'job_postings.package_id', '=', 'packages.id')
            ->leftJoin('admins', 'job_postings.admin_id', '=', 'admins.id')
            ->select(
                DB::raw('DATE(job_postings.created_at) as date'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(COALESCE(packages.lkr_price, 0)) as earnings'),
                DB::raw('GROUP_CONCAT(CONCAT(
                job_postings.title,
                " - ",
                employers.company_name,
                " (Approved by: ",
                COALESCE(admins.name, "N/A"),
                ")"
            ) SEPARATOR "||") as jobs')
            )
            ->where('job_postings.status', 'approved')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get()
            ->map(function ($item) {
                $item->jobs = collect(explode('||', $item->jobs));
                return $item;
            });

        // Weekly jobs with details and earnings
        $weeklyCount = DB::table('job_postings')
            ->join('employers', 'job_postings.employer_id', '=', 'employers.id')
            ->leftJoin('packages', 'job_postings.package_id', '=', 'packages.id')
            ->select(
                DB::raw('YEARWEEK(job_postings.created_at, 1) as week'),
                DB::raw('MIN(DATE(job_postings.created_at)) as week_start'),
                DB::raw('MAX(DATE(job_postings.created_at)) as week_end'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(COALESCE(packages.lkr_price, 0)) as earnings'),
                DB::raw('GROUP_CONCAT(CONCAT(job_postings.title, " - ", employers.company_name) SEPARATOR "||") as jobs')
            )
            ->where('job_postings.status', 'approved')
            ->groupBy('week')
            ->orderBy('week', 'desc')
            ->get()
            ->map(function ($item) {
                $item->jobs = collect(explode('||', $item->jobs));
                return $item;
            });

        // Monthly jobs with details and earnings
        $monthlyCount = DB::table('job_postings')
            ->join('employers', 'job_postings.employer_id', '=', 'employers.id')
            ->leftJoin('packages', 'job_postings.package_id', '=', 'packages.id')
            ->select(
                DB::raw('DATE_FORMAT(job_postings.created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(COALESCE(packages.lkr_price, 0)) as earnings'),
                DB::raw('GROUP_CONCAT(CONCAT(job_postings.title, " - ", employers.company_name) SEPARATOR "||") as jobs')
            )
            ->where('job_postings.status', 'approved')
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get()
            ->map(function ($item) {
                $item->jobs = collect(explode('||', $item->jobs));
                return $item;
            });

        // Payment details
        $paymentDetails = DB::table('job_postings')
            ->select('payment_method', DB::raw('COUNT(*) as count'))
            ->where('status', 'approved')
            ->groupBy('payment_method')
            ->get();

        // Posted by details
        $postedBy = DB::table('job_postings')
            ->where('status', 'approved')
            ->selectRaw("
            CASE
                WHEN creator_id IS NOT NULL THEN CONCAT('Admin: ', (SELECT name FROM admins WHERE admins.id = job_postings.creator_id))
                WHEN employer_id IS NOT NULL THEN CONCAT('Employer: ', (SELECT company_name FROM employers WHERE employers.id = job_postings.employer_id))
                ELSE 'Unknown'
            END as posted_by,
            COUNT(*) as count
        ")
            ->groupByRaw("
            CASE
                WHEN creator_id IS NOT NULL THEN CONCAT('Admin: ', (SELECT name FROM admins WHERE admins.id = job_postings.creator_id))
                WHEN employer_id IS NOT NULL THEN CONCAT('Employer: ', (SELECT company_name FROM employers WHERE employers.id = job_postings.employer_id))
                ELSE 'Unknown'
            END
        ")
            ->get();

        // Repeated employers
        $repeatedEmployers = DB::table('job_postings')
            ->join('employers', 'job_postings.employer_id', '=', 'employers.id')
            ->where('job_postings.status', 'approved')
            ->select(
                'job_postings.employer_id',
                'employers.company_name',
                DB::raw('COUNT(job_postings.id) as post_count')
            )
            ->groupBy('job_postings.employer_id', 'employers.company_name')
            ->having('post_count', '>', 1)
            ->get();

        // Calculate today's and this week's totals with earnings
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();

        $dailyTotalData = DB::table('job_postings')
            ->leftJoin('packages', 'job_postings.package_id', '=', 'packages.id')
            ->where('job_postings.status', 'approved')
            ->whereDate('job_postings.created_at', $today)
            ->select(
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(COALESCE(packages.lkr_price, 0)) as earnings')
            )
            ->first();

        $weeklyTotalData = DB::table('job_postings')
            ->leftJoin('packages', 'job_postings.package_id', '=', 'packages.id')
            ->where('job_postings.status', 'approved')
            ->whereBetween('job_postings.created_at', [$startOfWeek, Carbon::now()])
            ->select(
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(COALESCE(packages.lkr_price, 0)) as earnings')
            )
            ->first();

        $dailyTotal = $dailyTotalData->count;
        $dailyEarnings = $dailyTotalData->earnings;
        $weeklyTotal = $weeklyTotalData->count;
        $weeklyEarnings = $weeklyTotalData->earnings;

        return view('Admin.report.jobads', compact(
            'dailyCount',
            'weeklyCount',
            'monthlyCount',
            'paymentDetails',
            'postedBy',
            'repeatedEmployers',
            'dailyTotal',
            'weeklyTotal',
            'dailyEarnings',
            'weeklyEarnings'
        ));
    }

    public function home(Request $request)
    {
        $search = $request->input('search');
        $location = $request->input('location');
        $countryId = $request->input('country');
        $categoryId = $request->input('category_id');

        $jobs = JobPosting::with(['category', 'subcategory', 'country'])
            ->where('status', 'approved')
            ->where('is_active', true)
            ->whereDate('closing_date', '>=', now())
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhereHas('employer', function ($q) use ($search) {
                            $q->where('company_name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($location, function ($query, $location) {
                $query->where('location', 'like', "%{$location}%");
            })
            ->when($countryId, function ($query, $countryId) {
                $query->where('country_id', $countryId);
            })
            ->when($categoryId, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->get();

        $categories = Category::with('subcategories')->get();
        $contacts = ContactUs::all();
        $countries = Country::all();

        $now = Carbon::now();

        // Fetch banners where status is 'published' and duration is valid
        $banners = Banner::join('banner_packages', 'banners.package_id', '=', 'banner_packages.id')
        ->where('banners.status', 'published')
        ->where('placement','banner')
        ->whereRaw('DATE_ADD(banners.updated_at, INTERVAL banner_packages.duration DAY) >= ?', [$now])
        ->select('banners.*', 'banner_packages.duration')
        ->get();

        return view('home.home', compact('categories', 'jobs', 'contacts', 'countries','banners'));
    }
    public function toggleActiveStatus($id)
    {
        // Find the job posting by ID and ensure it belongs to the authenticated employer
        $job = JobPosting::where('id', $id)
            ->where('employer_id', auth('employer')->id()) // Ensure the job belongs to the current employer
            ->firstOrFail();

        // Toggle the is_active status
        $job->is_active = !$job->is_active;
        $job->save();

        $status = $job->is_active ? 'active' : 'inactive';

        return redirect()->back()->with('success', "Job posting has been marked as $status.");
    }

    public function show($id)
    {
        $job = JobPosting::with(['category', 'employer'])->findOrFail($id);
        return view('Admin.showonejob', compact('job'
        ));
    }
    public function showjob($id)
    {
        $contacts = ContactUs::all();

        // JobPosting record එක retrieve කර view_count එක increment කිරීම
        $job = JobPosting::with(['category', 'employer'])->findOrFail($id);
        $job->increment('view_count');

        $now = Carbon::now();

        $banners = Banner::join('banner_packages', 'banners.package_id', '=', 'banner_packages.id')
        ->where('banners.status', 'published')
        ->where('banners.placement', 'category_page')
        ->whereRaw('DATE_ADD(banners.updated_at, INTERVAL banner_packages.duration DAY) >= ?', [$now])
        ->select('banners.*', 'banner_packages.duration')
        ->get();

        return view('home.jobs.show', compact('job', 'contacts','banners'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'status' => 'required|in:pending,approved,reject',
            'rejection_reason' => 'nullable|string|max:255', // Validate rejection reason
        ]);

        // Retrieve the job posting by ID
        $job = JobPosting::findOrFail($id);

        // Update the status
        $job->status = $request->input('status');

        // Save approved date if status is approved
        if ($job->status === 'approved') {
            $job->approved_date = now(); // Save the current timestamp
            $job->rejection_reason = null; // Clear rejection reason if previously set
        }

        // Save rejected date and reason if status is reject
        if ($job->status === 'reject') {
            $job->rejected_date = now(); // Save the current timestamp
            $job->rejection_reason = $request->input('rejection_reason'); // Save rejection reason
        }

        // Save the admin ID who updated the status
        $job->admin_id = auth('admin')->id(); // Assuming admin is logged in

        // Save the changes to the database
        $job->save();

        // Redirect back with a success message
        return redirect()->route('job_postings.index')->with('success', 'Job status updated successfully.');
    }
    public function getJobsByCategory($categoryId)
    {
        // Fetch jobs belonging to the specified category
        $jobs = JobPosting::where('category_id', $categoryId)
            ->where('status', 'approved')
            ->where('is_active', true)
            ->whereDate('closing_date', '>=', now())
            ->with('employer') // Load employer relationship if needed
            ->get();

        return response()->json($jobs);
    }

    public function generateCustomerReport()
    {
        // Get current date and relevant date ranges
        $today = now()->format('Y-m-d');
        $startOfWeek = now()->startOfWeek()->format('Y-m-d');
        $endOfWeek = now()->endOfWeek()->format('Y-m-d');
        $startOfMonth = now()->startOfMonth()->format('Y-m-d');
        $endOfMonth = now()->endOfMonth()->format('Y-m-d');

        // Get base queries
        $users = User::query();
        $applications = Application::with('user', 'job');

        // Daily Statistics
        $dailyApplications = $applications->whereDate('created_at', $today)->count();
        $dailyUsers = $users->whereDate('created_at', $today)->count();

        // Daily Applications Data
        $dailyApplicationsData = Application::with(['user', 'job'])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get()
            ->map(function ($day) {
                $applications = Application::with(['user', 'job'])
                    ->whereDate('created_at', $day->date)
                    ->limit(5)
                    ->get()
                    ->map(function ($app) {
                        return [
                            'user_name' => optional($app->user)->name ?? 'Unknown User',
                            'job_title' => optional($app->job)->title ?? 'Unknown Job',
                        ];
                    });

                return [
                    'date' => $day->date,
                    'count' => $day->count,
                    'applications' => $applications,
                ];
            });

        // Weekly Applications Data
        $weeklyApplicationsData = Application::select(
            DB::raw('YEARWEEK(created_at) as yearweek'),
            DB::raw('MIN(created_at) as start_date'),
            DB::raw('MAX(created_at) as end_date'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('yearweek')
            ->orderBy('yearweek', 'desc')
            ->limit(12)
            ->get()
            ->map(function ($week) {
                $summary = Application::with(['user', 'job'])
                    ->whereBetween('created_at', [$week->start_date, $week->end_date])
                    ->limit(5)
                    ->get()
                    ->map(function ($app) {
                        // Check if user and job exist before accessing properties
                        $userName = optional($app->user)->name ?? 'Unknown User';
                        $jobTitle = optional($app->job)->title ?? 'Unknown Job';
        
                        return "$userName applied for $jobTitle";
                    });

                return [
                    'week' => Carbon::parse($week->start_date)->format('W'),
                    'start_date' => Carbon::parse($week->start_date)->format('Y-m-d'),
                    'end_date' => Carbon::parse($week->end_date)->format('Y-m-d'),
                    'count' => $week->count,
                    'summary' => $summary,
                ];
            });

        // Monthly Applications Data
        $monthlyApplicationsData = Application::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get()
            ->map(function ($month) {
                $summary = Application::with(['user', 'job'])
                    ->whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [$month->month])
                    ->limit(5)
                    ->get()
                    ->map(function ($app) {
                        // Check if user and job exist before accessing properties
                        $userName = optional($app->user)->name ?? 'Unknown User';
                        $jobTitle = optional($app->job)->title ?? 'Unknown Job';
        
                        return "$userName applied for $jobTitle";
                    });

                return [
                    'month' => Carbon::parse($month->month . '-01')->format('F Y'),
                    'count' => $month->count,
                    'summary' => $summary,
                ];
            });

        // Daily Users Data (New Registrations)
        $dailyUsersData = User::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get()
            ->map(function ($day) {
                $users = User::whereDate('created_at', $day->date)
                    ->select('name', 'email', 'created_at')
                    ->limit(5)
                    ->get();

                return [
                    'date' => $day->date,
                    'count' => $day->count,
                    'users' => $users,
                ];
            });

        // Weekly Users Data
        $weeklyUsersData = User::select(
            DB::raw('YEARWEEK(created_at) as yearweek'),
            DB::raw('MIN(created_at) as start_date'),
            DB::raw('MAX(created_at) as end_date'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('yearweek')
            ->orderBy('yearweek', 'desc')
            ->limit(12)
            ->get()
            ->map(function ($week) {
                $users = User::whereBetween('created_at', [$week->start_date, $week->end_date])
                    ->select('name', 'email', 'created_at')
                    ->limit(5)
                    ->get();

                return [
                    'week' => Carbon::parse($week->start_date)->format('W'),
                    'start_date' => Carbon::parse($week->start_date)->format('Y-m-d'),
                    'end_date' => Carbon::parse($week->end_date)->format('Y-m-d'),
                    'count' => $week->count,
                    'users' => $users,
                ];
            });

        // Monthly Users Data
        $monthlyUsersData = User::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get()
            ->map(function ($month) {
                $summary = User::whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [$month->month])
                    ->select('name', 'email', 'created_at')
                    ->limit(5)
                    ->get()
                    ->map(function ($user) {
                        return "{$user->name} ({$user->email})";
                    });

                return [
                    'month' => Carbon::parse($month->month . '-01')->format('F Y'),
                    'count' => $month->count,
                    'summary' => $summary,
                ];
            });

        return view('Admin.report.application', compact(
            'dailyApplications',
            'dailyUsers',
            'dailyApplicationsData',
            'weeklyApplicationsData',
            'monthlyApplicationsData',
            'dailyUsersData',
            'weeklyUsersData',
            'monthlyUsersData'
        ));
    }

    public function create()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $employerId = auth('employer')->user()->id;
        $packages = Package::all();
        $countries = Country::all(); // Add this line

        return view('employer.jobcreate', compact('categories', 'subcategories', 'employerId', 'packages', 'countries'));
    }
    public function employerJobs()
    {
        $employerId = auth('employer')->id();

        $jobPostings = JobPosting::where('employer_id', $employerId)
            ->whereDate('closing_date', '>=', now()) // Exclude expired jobs
            ->with(['category', 'subcategory', 'admin'])
            ->paginate(10);

        return view('employer.jobview', compact('jobPostings'));
    }

    public function store(Request $request)
    {
        try {
            // First validate the package selection and payment method
            $request->validate([
                'package_id' => 'required|exists:packages,id',
                'payment_method' => 'required|in:contact_contributor,online',
            ]);

            $employerId = auth('employer')->id();
            $packageId = $request->input('package_id');
            $jobPostings = $request->input('job_postings', []);
            $paymentMethod = $request->input('payment_method');

            // Check if job postings exist
            if (!is_array($jobPostings) || empty($jobPostings)) {
                return redirect()->back()
                    ->withErrors(['job_postings' => 'No job postings provided.'])
                    ->withInput();
            }

            // Validate all job postings first
            foreach ($request->job_postings as $index => $posting) {
                $request->validate([
                    "job_postings.{$index}.title" => 'required|string|max:255',
                    "job_postings.{$index}.description" => 'nullable|string',
                    "job_postings.{$index}.category_id" => 'required|exists:categories,id',
                    "job_postings.{$index}.subcategory_id" => 'required|exists:subcategories,id',
                    "job_postings.{$index}.location" => 'required|string|max:255',
                    "job_postings.{$index}.country_id" => 'required|exists:countries,id',
                    "job_postings.{$index}.salary_range" => 'nullable|numeric',
                    "job_postings.{$index}.image" => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4048',
                    "job_postings.{$index}.requirements" => 'nullable|string',
                    "job_postings.{$index}.closing_date" => 'required|date',
                    "job_postings.{$index}.status" => 'required|in:pending,reject,approved',
                    "job_postings.{$index}.payment_method" => 'required|in:contact_contributor,online',
                ]);
            }

            // Process each job posting within a transaction
            DB::beginTransaction();
            try {
                foreach ($jobPostings as $index => $jobData) {
                    // Generate unique job ID
                    do {
                        $jobId = 'J' . rand(10000, 99999);
                    } while (JobPosting::where('job_id', $jobId)->exists());

                    // Create job posting data
                    $jobPostingData = [
                        'job_id' => $jobId,
                        'employer_id' => $employerId,
                        'package_id' => $packageId,
                        'title' => $jobData['title'],
                        'description' => $jobData['description'] ?? 'No Description',
                        'category_id' => $jobData['category_id'],
                        'subcategory_id' => $jobData['subcategory_id'],
                        'location' => $jobData['location'],
                        'country_id' => $jobData['country_id'],
                        'salary_range' => $jobData['salary_range'] ?? null,
                        'requirements' => $jobData['requirements'],
                        'closing_date' => $jobData['closing_date'],
                        'status' => $jobData['status'],
                        'payment_method' => $jobData['payment_method'],
                    ];

                    // Create the job posting
                    $posting = JobPosting::create($jobPostingData);

                    // Handle image upload if present
                    if ($request->hasFile("job_postings.{$index}.image")) {
                        $imagePath = $request->file("job_postings.{$index}.image")
                            ->store('job_images', 'public');
                        $posting->image = $imagePath;
                        $posting->save();
                    }
                }

                DB::commit();

                if ($paymentMethod === 'contact_contributor') {
                    return redirect()->route('employer.job_postings.post.create')
                        ->with('success', 'Job postings created successfully!');
                } else {
                    // For online payment, redirect to payment page
                    return redirect()->route('payment.checkout')
                        ->with('success', 'Please complete your payment to publish the job postings.');
                }

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()
                    ->withErrors(['error' => 'Failed to create job postings. Please try again.'])
                    ->withInput();
            }

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'An error occurred. Please try again.'])
                ->withInput();
        }
    }
    public function storeForAdmin(Request $request)
    {
        // Validate package selection, job postings, and payment method
        $validatedData = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'payment_method' => 'required|in:contact_contributor,online',
            'job_postings.*.title' => 'required|string|max:255',
            'job_postings.*.description' => 'nullable|string',
            'job_postings.*.category_id' => 'required|exists:categories,id',
            'job_postings.*.subcategory_id' => 'required|exists:subcategories,id',
            'job_postings.*.location' => 'required|string|max:255',
            'job_postings.*.country_id' => 'required|exists:countries,id',
            'job_postings.*.salary_range' => 'nullable|numeric',
            'job_postings.*.image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:4048',
            'job_postings.*.requirements' => 'nullable|string',
            'job_postings.*.closing_date' => 'required|date',
            'job_postings.*.status' => 'required|in:pending,reject,approved',
            'job_postings.*.employer_id' => 'required|exists:employers,id',
        ]);

        $adminId = auth('admin')->id();
        $packageId = $request->input('package_id');
        $jobPostings = $request->input('job_postings', []);
        $paymentMethod = $request->input('payment_method');

        if (empty($jobPostings)) {
            return redirect()->back()->withErrors(['job_postings' => 'No job postings provided.']);
        }

        // // Check package limitations
        // $package = Package::find($packageId);
        // $existingJobCount = JobPosting::where('creator_id', $adminId)
        //     ->where('package_id', $packageId)
        //     ->count();

        // if ($existingJobCount + count($jobPostings) > $package->package_size) {
        //     return redirect()->back()
        //         ->withErrors(['package_id' => 'Exceeded maximum allowed job postings for this package.'])
        //         ->withInput();
        // }

        // Use transaction to ensure data consistency
        DB::beginTransaction();
        try {
            $storedPostings = [];
            foreach ($jobPostings as $index => $jobData) {
                // Generate unique job ID
                do {
                    $jobId = 'J' . rand(10000, 99999);
                } while (JobPosting::where('job_id', $jobId)->exists());

                // Prepare job posting data
                $jobPostingData = [
                    'job_id' => $jobId,
                    'creator_id' => $adminId,
                    'admin_id' => $adminId,
                    'package_id' => $packageId,
                    'employer_id' => $jobData['employer_id'],
                    'title' => $jobData['title'],
                    'description' => $jobData['description'] ?? 'No Description',
                    'category_id' => $jobData['category_id'],
                    'subcategory_id' => $jobData['subcategory_id'],
                    'location' => $jobData['location'],
                    'country_id' => $jobData['country_id'],
                    'salary_range' => $jobData['salary_range'] ?? null,
                    'requirements' => $jobData['requirements'],
                    'closing_date' => $jobData['closing_date'],
                    'status' => $jobData['status'],
                    'payment_method' => $paymentMethod,
                    'is_active' => true,
                ];

                // Handle image upload
                if ($request->hasFile("job_postings.$index.image")) {
                    $jobPostingData['image'] = $request->file("job_postings.$index.image")
                        ->store('job_images', 'public');
                }

                // Create job posting
                $storedPostings[] = JobPosting::create($jobPostingData);
            }

            DB::commit();

            if ($paymentMethod === 'online') {
                // Store necessary data in session for payment processing
                session(['pending_job_postings' => collect($storedPostings)->pluck('id')]);
                return redirect()->route('admin.payment.checkout');
            }

            return redirect()->route('job_postings.index')
                ->with('success', 'Job postings created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'An error occurred while creating job postings: ' . $e->getMessage()])
                ->withInput();
        }
    }
    public function getSubcategories($categoryId)
    {
        $subcategories = Subcategory::where('category_id', $categoryId)->get();
        return response()->json($subcategories);
    }

    public function edit(JobPosting $jobPosting)
    {
        $categories = Category::all(); // Assuming you have a Category model
        $subcategories = Subcategory::where('category_id', $jobPosting->category_id)->get(); // Assuming you have a Subcategory model
        return view('employer.jobupdate', compact('jobPosting', 'categories', 'subcategories'));
    }
    public function createForAdmin()
    {
        $categories = Category::all(); // Fetch all categories
        $subcategories = Subcategory::all(); // Fetch all subcategories
        $employers = Employer::all(); // Fetch all employers
        $packages = Package::all(); // Fetch all packages
        $countries = Country::all();

        return view('Admin.jobcreate', compact('categories', 'subcategories', 'employers', 'packages', 'countries'));
    }

    public function update(Request $request, JobPosting $jobPosting)
    {
        try {
            // Remove employer_id and job_id from validation since they shouldn't change
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required',
                'category_id' => 'required|exists:categories,id',
                'subcategory_id' => 'required|exists:subcategories,id',
                'location' => 'required|string|max:255',
                'country_id' => 'required|exists:countries,id',
                'salary_range' => 'nullable|numeric',
                'image' => 'nullable|image|max:2048',
                'requirements' => 'required',
                'closing_date' => 'required|date',
                'status' => 'nullable|in:pending,reject,approved',
            ]);

            // Handle image upload if a new image is provided
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('job_images', 'public');
            }

            // Update the job posting
            $jobPosting->update($validated);

            // Redirect to employer jobs view
            return redirect()->route('employer.job_postings.employer.jobs')
                ->with('success', 'Job Posting updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'An error occurred while updating the job posting: ' . $e->getMessage());
        }
    }
    public function generateJobAdsReportByDateRange(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // Get jobs within date range
        $jobsInRange = DB::table('job_postings')
            ->join('employers', 'job_postings.employer_id', '=', 'employers.id')
            ->leftJoin('packages', 'job_postings.package_id', '=', 'packages.id')
            ->leftJoin('admins', 'job_postings.admin_id', '=', 'admins.id')
            ->whereBetween('job_postings.created_at', [$startDate, $endDate])
            ->where('job_postings.status', 'approved')
            ->select(
                'job_postings.*',
                'employers.company_name',
                'packages.lkr_price',
                'admins.name as admin_name'
            )
            ->get();

        // Calculate statistics
        $totalJobs = $jobsInRange->count();
        $totalEarnings = $jobsInRange->sum('lkr_price');

        // Payment method distribution
        $paymentDetails = $jobsInRange->groupBy('payment_method')
            ->map(function ($group) {
                return $group->count();
            });

        // Posted by distribution
        $postedBy = $jobsInRange->groupBy(function ($job) {
            return $job->creator_id ? 'Admin: ' . $job->admin_name : 'Employer: ' . $job->company_name;
        })->map(function ($group) {
            return $group->count();
        });

        // Repeated employers
        $repeatedEmployers = $jobsInRange->groupBy('employer_id')
            ->map(function ($group) {
                return [
                    'company_name' => $group->first()->company_name,
                    'post_count' => $group->count(),
                ];
            })
            ->filter(function ($employer) {
                return $employer['post_count'] > 1;
            });

        return view('Admin.report.jobads-daterange', compact(
            'jobsInRange',
            'totalJobs',
            'totalEarnings',
            'paymentDetails',
            'postedBy',
            'repeatedEmployers',
            'startDate',
            'endDate'
        ));
    }

    public function destroy(JobPosting $jobPosting)
    {
        $jobPosting->delete();
        return redirect()->route('employer.job_postings.employer.jobs')->with('success', 'Job Posting deleted successfully.');
    }
}