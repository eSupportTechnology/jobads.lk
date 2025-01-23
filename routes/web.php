<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('folder.dashboard');
});


// Dashboard
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

// Users
Route::get('/admin/list', [AdminController::class, 'index'])->name('admin.list');
Route::get('/employer/list', [EmployerController::class, 'index'])->name('employer.list');
Route::get('/user/list', [UserController::class, 'index'])->name('user.list');

// Categories
Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories.index');

// Jobs
Route::get('/jobs', [JobPostingController::class, 'index'])->name('job_postings.index');
Route::get('/jobs/create', [JobPostingController::class, 'create'])->name('admin.job_postings.create');

// Employer Create
Route::get('/register/admin-employer', [EmployerController::class, 'create'])->name('register.adminemployer');

// Feedback
Route::get('/feedback/manage', [FeedbackController::class, 'index'])->name('admin.feedback.manage');

// Package Contact
Route::get('/package-contacts/create', [PackageContactController::class, 'create'])->name('package-contacts.create');

// Package Details
Route::get('/admin/packages', [PackageController::class, 'index'])->name('admin.packages.index');

// Banner Packages
Route::get('/banner-packages/create', [BannerPackageController::class, 'create'])->name('package-contacts.create');

// Bank Accounts
Route::get('/admin/bank-accounts', [BankAccountController::class, 'index'])->name('admin.bank-accounts.index');

// Coordinator Contact
Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');

// Reports
Route::get('/reports/job-ads', [ReportController::class, 'jobAds'])->name('reports.job-ads');
Route::get('/reports/employer-stats', [ReportController::class, 'employerStats'])->name('admin.employer.stats');
Route::get('/reports/customers', [ReportController::class, 'customers'])->name('reports.customers');

// Site Settings
Route::get('/contact-us/create', [ContactUsController::class, 'create'])->name('contactus.create');
Route::get('/admin/about-us', [AboutUsController::class, 'index'])->name('admin.about-us.index');
Route::get('/admin/terms', [TermsAndConditionController::class, 'index'])->name('admin.terms.index');
Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
