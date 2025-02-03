<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminForgotPasswordController;
use App\Http\Controllers\AdminResetPasswordController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BannerDetailsController;
use App\Http\Controllers\BannerPackageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactListController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CVController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\EmpBannerController;
use App\Http\Controllers\EmployerAuthController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FlaggedJobController;
use App\Http\Controllers\JobExperienceController;
use App\Http\Controllers\JobPostingController;
use App\Http\Controllers\PackageContactController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TermsAndConditionController;
use App\Models\Category;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

//Breeze routes
Route::get('/', [JobPostingController::class, 'home'])->name('home');

Route::get('/categories/{id}/subcategories', function ($id) {
    $category = Category::with('subcategories')->findOrFail($id);
    return response()->json(['subcategories' => $category->subcategories]);
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/personal', [ProfileController::class, 'showpersonal'])->name('profile.personal');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //Route::patch('/profile/update', [EducationController::class, 'update'])->name('education.update');
    Route::post('/profile/education', [EducationController::class, 'storeOrUpdate'])->name('education.store-or-update');
    Route::get('/profile/experience', [JobExperienceController::class, 'showExperience'])->name('experience.show');
    Route::post('/profile/experience', [JobExperienceController::class, 'storeOrUpdate'])->name('experience.store-or-update');
    Route::get('/my-applications', [ApplicationController::class, 'myApplications'])->name('user.jobseekerprofile.myjobs.application');
    Route::get('/my-applications/{id}', [ApplicationController::class, 'viewApplicationDetails'])
        ->name('user.jobseekerprofile.myjobs.view');
    Route::post('/jobs/{jobId}/flag', [FlaggedJobController::class, 'toggleFlag'])->name('jobs.flag');
    Route::get('/user/flagged-jobs', [FlaggedJobController::class, 'showFlaggedJobs'])->name('user.flagged_jobs');

});

// Route::get('/', function () {
//     return redirect()->route('index');
// })->name('/');

//Language Change
Route::get('lang/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'de', 'es', 'fr', 'pt', 'cn', 'ae'])) {
        abort(400);
    }
    Session()->put('locale', $locale);
    Session::get('locale');
    return redirect()->back();
})->name('lang');

Route::middleware('guest')->group(function () {
    // Registration Routes
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

//profile testing routes

// Route::get('/mainprofileview/personal', function () {
//     return view('user.jobseekerprofile.personal');
// })->name('user.jobseekerprofile.personal');

Route::get('profile/education', [EducationController::class, 'showEducation'])->middleware('auth')->name('user.jobseekerprofile.education');

// routes/web.php

Route::middleware(['auth'])->group(function () {

    Route::post('profile/education', [EducationController::class, 'store'])
        ->name('education.store');

    Route::put('profile/education/{id}', [EducationController::class, 'update'])
        ->name('education.update');

    Route::get('profile/education/{id}/delete', [EducationController::class, 'destroy'])
        ->name('education.delete');
});

// Add these routes to your web.php file

// Experience Management Routes
Route::middleware(['auth'])->group(function () {
    // Show experience form

    // Store new experience
    Route::post('/experience/store', [JobExperienceController::class, 'store'])
        ->name('experience.store');

    // Update existing experience
    Route::put('/experience/update/{id}', [JobExperienceController::class, 'update'])
        ->name('experience.update');

    // Delete experience
    Route::get('/experience/delete/{id}', [JobExperienceController::class, 'destroy'])
        ->name('experience.delete');

});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('/profile/cv', [CVController::class, 'generateCV'])->name('generate.cv');
    Route::get('/profile/cv', [CVController::class, 'index'])->name('generate.index');
    Route::post('/profile/cv2', [CVController::class, 'generateCV2'])->name('generate.cv2');
    Route::get('/profile/cv2', [CVController::class, 'index2'])->name('generate.index2');
    Route::post('/profile/cv3', [CVController::class, 'generateCV3'])->name('generate.cv3');
    Route::get('/profile/cv3', [CVController::class, 'index3'])->name('generate.index3');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

Route::prefix('dashboard')->group(function () {
    Route::view('index', 'dashboard.index')->name('index');
    Route::view('dashboard-02', 'dashboard.dashboard-02')->name('dashboard-02');

});

Route::prefix('widgets')->group(function () {
    Route::view('general-widget', 'widgets.general-widget')->name('general-widget');
    Route::view('chart-widget', 'widgets.chart-widget')->name('chart-widget');
});

//Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::get('register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.signup');
    Route::post('/admin/register', [AdminAuthController::class, 'register'])->name('admin.register');

    Route::middleware('admin')->group(function () {
        Route::get('dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
    });

});
Route::get('terms-and-conditions', [TermsAndConditionController::class, 'indexhome'])->name('terms.index');
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    // Show the list of terms and conditions
    Route::get('terms-and-conditions', [TermsAndConditionController::class, 'index'])->name('terms.index');

    // Show the form for creating a new terms and condition
    Route::get('terms-and-conditions/create', [TermsAndConditionController::class, 'create'])->name('terms.create');

    // Store a new terms and condition
    Route::post('terms-and-conditions', [TermsAndConditionController::class, 'store'])->name('terms.store');

    // Show the form for editing an existing terms and condition
    Route::get('terms-and-conditions/{termsAndCondition}/edit', [TermsAndConditionController::class, 'edit'])->name('terms.edit');

    // Update an existing terms and condition
    Route::put('terms-and-conditions/{termsAndCondition}', [TermsAndConditionController::class, 'update'])->name('terms.update');

    // Delete an existing terms and condition
    Route::delete('terms-and-conditions/{termsAndCondition}', [TermsAndConditionController::class, 'destroy'])->name('terms.destroy');
});

Route::get('/about-us', [AboutUsController::class, 'indexhome'])->name('about-us.index');
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    // Show the About Us section
    Route::get('/about-us', [AboutUsController::class, 'index'])->name('about-us.index');

    // Show the form to create a new About Us section
    Route::get('about-us/create', [AboutUsController::class, 'create'])->name('about-us.create');

    // Store the new About Us section
    Route::post('about-us', [AboutUsController::class, 'store'])->name('about-us.store');

    // Show the form to edit an existing About Us section
    Route::get('about-us/{aboutUs}/edit', [AboutUsController::class, 'edit'])->name('about-us.edit');

    // Update the existing About Us section
    Route::put('about-us/{aboutUs}', [AboutUsController::class, 'update'])->name('about-us.update');

    // Delete the About Us section
    Route::delete('about-us/{aboutUs}', [AboutUsController::class, 'destroy'])->name('about-us.destroy');
});
Route::get('faqs', [FaqController::class, 'faqshow'])->name('faqs.home');
Route::middleware('admin')->group(function () {
    // Display all FAQs
    Route::get('admin/faqs', [FaqController::class, 'index'])->name('faqs.index');

    // Show the form to create a new FAQ
    Route::get('/faqs/create', [FaqController::class, 'create'])->name('faqs.create');

    // Store a new FAQ
    Route::post('/faqs', [FaqController::class, 'store'])->name('faqs.store');

    // Display a specific FAQ
    Route::get('/faqs/{faq}', [FaqController::class, 'show'])->name('faqs.show');

    // Show the form to edit a specific FAQ
    Route::get('/faqs/{faq}/edit', [FaqController::class, 'edit'])->name('faqs.edit');

    // Update a specific FAQ
    Route::put('/faqs/{faq}', [FaqController::class, 'update'])->name('faqs.update');

    // Delete a specific FAQ
    Route::delete('/faqs/{faq}', [FaqController::class, 'destroy'])->name('faqs.destroy');
});

Route::get('/jobs/{id}', [JobPostingController::class, 'showjob'])->name('job.details');
Route::get('/jobs/category/{categoryId}', [JobPostingController::class, 'getJobsByCategory']);
Route::middleware('admin')->group(function () {
    Route::get('/admin/profile', [AdminAuthController::class, 'showProfileForm'])
        ->name('admin.profile');
    Route::get('/job_postings/{id}', [JobPostingController::class, 'show'])->name('job_postings.show');

    Route::put('/admin/profile', [AdminAuthController::class, 'updateProfile'])
        ->name('admin.profile.update');
    Route::get('/admin/list', [AdminAuthController::class, 'adminList'])->name('admin.list');

    Route::get('/admin/employer-list', [EmployerAuthController::class, 'list'])->name('employer.list');

    Route::delete('/employer/delete/{id}', function ($id) {
        $employer = \App\Models\Employer::findOrFail($id);
        $employer->delete();
        return redirect()->route('employer.list')->with('success', 'Employer deleted successfully.');
    })->name('employer.delete');
    Route::get('/admin/user-list', [RegisteredUserController::class, 'userList'])->name('user.list');
    Route::patch('/user/{id}/toggle-status', [RegisteredUserController::class, 'toggleStatus'])->name('user.toggleStatus');

    Route::patch('/employer/{id}/toggle-status', [EmployerAuthController::class, 'toggleStatus'])->name('employer.toggleStatus');

});

Route::get('/contactus', [ContactUsController::class, 'index'])->name('contactus.index');

Route::middleware('admin')->prefix('admin')->group(function () {
    // List all categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories.index');

    // Show form to create a new category
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');

    // Store a new category
    Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');

    // Show form to edit an existing category
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');

    // Update an existing category
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');

    // Delete a category
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

    // Job Posting admin side route
    Route::get('job_postings', [JobPostingController::class, 'index'])->name('job_postings.index');

    Route::patch('job_postings/{id}/status', [JobPostingController::class, 'updateStatus'])->name('job_postings.updateStatus');

    //

    // Show form to create new contact details
    Route::get('/contactus/create', [ContactUsController::class, 'create'])->name('contactus.create');

    // Store new contact details
    Route::post('/contactus', [ContactUsController::class, 'store'])->name('contactus.store');

    // Show form to edit specific contact details
    Route::get('/contactus/{contactus}/edit', [ContactUsController::class, 'edit'])->name('contactus.edit');

    // Update specific contact details
    Route::put('/contactus/{contactus}', [ContactUsController::class, 'update'])->name('contactus.update');

    // Delete specific contact details
    Route::delete('/contactus/{contactus}', [ContactUsController::class, 'destroy'])->name('contactus.destroy');
});

//Employee Routes
Route::prefix('employer')->name('employer.')->group(function () {
    Route::get('/login', [EmployerAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [EmployerAuthController::class, 'login']);
    Route::post('/logout', [EmployerAuthController::class, 'logout'])->name('logout');

    Route::get('/register', [EmployerAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [EmployerAuthController::class, 'register']);

    Route::middleware('auth:employer')->group(function () {
        Route::get('/dashboard', [EmployerAuthController::class, 'dashboard'])->name('dashboard');
        // Job Posting routes
        Route::prefix('job-postings')->name('job_postings.')->group(function () {
            Route::get('/jobs', [JobPostingController::class, 'employerJobs'])->name('employer.jobs');
            Route::get('/create', [JobPostingController::class, 'create'])->name('post.create');
            Route::post('/create', [JobPostingController::class, 'store'])->name('job.store');
            Route::get('/{jobPosting}/edit', [JobPostingController::class, 'edit'])->name('post.edit');
            Route::patch('/{jobPosting}', [JobPostingController::class, 'update'])->name('post.update');
            Route::delete('/{jobPosting}', [JobPostingController::class, 'destroy'])->name('post.destroy');
        });

    });
});
Route::get('/subcategories/{category}', [JobPostingController::class, 'getSubcategories'])->name('subcategories.get');
Route::get('/topemployees', [JobPostingController::class, 'topEmployers'])->name('top.employers');
Route::get('/topemployees/{employer}/jobs', [JobPostingController::class, 'showtopemployerJobs'])->name('top.employers.jobs');

Route::middleware('auth:employer')->group(function () {
    Route::get('/employer/profile', [EmployerAuthController::class, 'showProfileForm'])->name('employer.profile');
    Route::put('/employer/profile', [EmployerAuthController::class, 'updateProfile'])->name('employer.updateProfile');
    Route::post('/employer/logo/update', [EmployerAuthController::class, 'updateLogo'])->name('employer.update.logo');
    Route::get('/employer/jobs/{job}/applications', [ApplicationController::class, 'viewApplicationsForJob'])
        ->name('employer.jobs.applications');
});

Route::prefix('ecommerce')->group(function () {
    Route::view('product', 'apps.product')->name('product');
    Route::view('page-product', 'apps.product-page')->name('product-page');
    Route::view('list-products', 'apps.list-products')->name('list-products');
    Route::view('payment-details', 'apps.payment-details')->name('payment-details');
    Route::view('order-history', 'apps.order-history')->name('order-history');
    Route::view('invoice-template', 'apps.invoice-template')->name('invoice-template');
    Route::view('cart', 'apps.cart')->name('cart');
    Route::view('list-wish', 'apps.list-wish')->name('list-wish');
    Route::view('checkout', 'apps.checkout')->name('checkout');
    Route::view('pricing', 'apps.pricing')->name('pricing');
});

Route::prefix('email')->group(function () {
    Route::view('email-application', 'apps.email-application')->name('email-application');
    Route::view('email-compose', 'apps.email-compose')->name('email-compose');
});

Route::prefix('chat')->group(function () {
    Route::view('chat', 'apps.chat')->name('chat');
    Route::view('video-chat', 'apps.video-chat')->name('chat-video');
});

Route::prefix('users')->group(function () {
    Route::view('user-profile', 'apps.user-profile')->name('user-profile');
    Route::view('edit-profile', 'apps.edit-profile')->name('edit-profile');
    Route::view('user-cards', 'apps.user-cards')->name('user-cards');
});

Route::view('bookmark', 'apps.bookmark')->name('bookmark');
Route::view('contacts', 'apps.contacts')->name('contacts');
Route::view('task', 'apps.task')->name('task');
Route::view('calendar-basic', 'apps.calendar-basic')->name('calendar-basic');
Route::view('social-app', 'apps.social-app')->name('social-app');
Route::view('to-do', 'apps.to-do')->name('to-do');
Route::view('search', 'apps.search')->name('search');

Route::prefix('ui-kits')->group(function () {
    Route::view('state-color', 'ui-kits.state-color')->name('state-color');
    Route::view('typography', 'ui-kits.typography')->name('typography');
    Route::view('avatars', 'ui-kits.avatars')->name('avatars');
    Route::view('helper-classes', 'ui-kits.helper-classes')->name('helper-classes');
    Route::view('grid', 'ui-kits.grid')->name('grid');
    Route::view('tag-pills', 'ui-kits.tag-pills')->name('tag-pills');
    Route::view('progress-bar', 'ui-kits.progress-bar')->name('progress-bar');
    Route::view('modal', 'ui-kits.modal')->name('modal');
    Route::view('alert', 'ui-kits.alert')->name('alert');
    Route::view('popover', 'ui-kits.popover')->name('popover');
    Route::view('tooltip', 'ui-kits.tooltip')->name('tooltip');
    Route::view('loader', 'ui-kits.loader')->name('loader');
    Route::view('dropdown', 'ui-kits.dropdown')->name('dropdown');
    Route::view('accordion', 'ui-kits.accordion')->name('accordion');
    Route::view('tab-bootstrap', 'ui-kits.tab-bootstrap')->name('tab-bootstrap');
    Route::view('tab-material', 'ui-kits.tab-material')->name('tab-material');
    Route::view('box-shadow', 'ui-kits.box-shadow')->name('box-shadow');
    Route::view('list', 'ui-kits.list')->name('list');
});

Route::prefix('bonus-ui')->group(function () {
    Route::view('scrollable', 'bonus-ui.scrollable')->name('scrollable');
    Route::view('tree', 'bonus-ui.tree')->name('tree');
    Route::view('bootstrap-notify', 'bonus-ui.bootstrap-notify')->name('bootstrap-notify');
    Route::view('rating', 'bonus-ui.rating')->name('rating');
    Route::view('dropzone', 'bonus-ui.dropzone')->name('dropzone');
    Route::view('tour', 'bonus-ui.tour')->name('tour');
    Route::view('sweet-alert2', 'bonus-ui.sweet-alert2')->name('sweet-alert2');
    Route::view('modal-animated', 'bonus-ui.modal-animated')->name('modal-animated');
    Route::view('owl-carousel', 'bonus-ui.owl-carousel')->name('owl-carousel');
    Route::view('ribbons', 'bonus-ui.ribbons')->name('ribbons');
    Route::view('pagination', 'bonus-ui.pagination')->name('pagination');
    Route::view('breadcrumb', 'bonus-ui.breadcrumb')->name('breadcrumb');
    Route::view('range-slider', 'bonus-ui.range-slider')->name('range-slider');
    Route::view('image-cropper', 'bonus-ui.image-cropper')->name('image-cropper');
    Route::view('sticky', 'bonus-ui.sticky')->name('sticky');
    Route::view('basic-card', 'bonus-ui.basic-card')->name('basic-card');
    Route::view('creative-card', 'bonus-ui.creative-card')->name('creative-card');
    Route::view('tabbed-card', 'bonus-ui.tabbed-card')->name('tabbed-card');
    Route::view('dragable-card', 'bonus-ui.dragable-card')->name('dragable-card');
    Route::view('timeline-v-1', 'bonus-ui.timeline-v-1')->name('timeline-v-1');
    Route::view('timeline-v-2', 'bonus-ui.timeline-v-2')->name('timeline-v-2');
    Route::view('timeline-small', 'bonus-ui.timeline-small')->name('timeline-small');
});

Route::prefix('builders')->group(function () {
    Route::view('form-builder-1', 'builders.form-builder-1')->name('form-builder-1');
    Route::view('form-builder-2', 'builders.form-builder-2')->name('form-builder-2');
    Route::view('pagebuild', 'builders.pagebuild')->name('pagebuild');
    Route::view('button-builder', 'builders.button-builder')->name('button-builder');
});

Route::prefix('animation')->group(function () {
    Route::view('animate', 'animation.animate')->name('animate');
    Route::view('scroll-reval', 'animation.scroll-reval')->name('scroll-reval');
    Route::view('aos', 'animation.aos')->name('aos');
    Route::view('tilt', 'animation.tilt')->name('tilt');
    Route::view('wow', 'animation.wow')->name('wow');
});

Route::prefix('icons')->group(function () {
    Route::view('flag-icon', 'icons.flag-icon')->name('flag-icon');
    Route::view('font-awesome', 'icons.font-awesome')->name('font-awesome');
    Route::view('ico-icon', 'icons.ico-icon')->name('ico-icon');
    Route::view('themify-icon', 'icons.themify-icon')->name('themify-icon');
    Route::view('feather-icon', 'icons.feather-icon')->name('feather-icon');
    Route::view('whether-icon', 'icons.whether-icon')->name('whether-icon');
    Route::view('simple-line-icon', 'icons.simple-line-icon')->name('simple-line-icon');
    Route::view('material-design-icon', 'icons.material-design-icon')->name('material-design-icon');
    Route::view('pe7-icon', 'icons.pe7-icon')->name('pe7-icon');
    Route::view('typicons-icon', 'icons.typicons-icon')->name('typicons-icon');
    Route::view('ionic-icon', 'icons.ionic-icon')->name('ionic-icon');
});

Route::prefix('buttons')->group(function () {
    Route::view('buttons', 'buttons.buttons')->name('buttons');
    Route::view('flat-buttons', 'buttons.flat-buttons')->name('flat-buttons');
    Route::view('edge-buttons', 'buttons.buttons-edge')->name('buttons-edge');
    Route::view('raised-button', 'buttons.raised-button')->name('raised-button');
    Route::view('button-group', 'buttons.button-group')->name('button-group');
});

Route::prefix('forms')->group(function () {
    Route::view('form-validation', 'forms.form-validation')->name('form-validation');
    Route::view('base-input', 'forms.base-input')->name('base-input');
    Route::view('radio-checkbox-control', 'forms.radio-checkbox-control')->name('radio-checkbox-control');
    Route::view('input-group', 'forms.input-group')->name('input-group');
    Route::view('megaoptions', 'forms.megaoptions')->name('megaoptions');
    Route::view('datepicker', 'forms.datepicker')->name('datepicker');
    Route::view('time-picker', 'forms.time-picker')->name('time-picker');
    Route::view('datetimepicker', 'forms.datetimepicker')->name('datetimepicker');
    Route::view('daterangepicker', 'forms.daterangepicker')->name('daterangepicker');
    Route::view('touchspin', 'forms.touchspin')->name('touchspin');
    Route::view('select2', 'forms.select2')->name('select2');
    Route::view('switch', 'forms.switch')->name('switch');
    Route::view('typeahead', 'forms.typeahead')->name('typeahead');
    Route::view('clipboard', 'forms.clipboard')->name('clipboard');
    Route::view('default-form', 'forms.default-form')->name('default-form');
    Route::view('form-wizard', 'forms.form-wizard')->name('form-wizard');
    Route::view('form-two-wizard', 'forms.form-wizard-two')->name('form-wizard-two');
    Route::view('wizard-form-three', 'forms.form-wizard-three')->name('form-wizard-three');
    Route::post('form-wizard-three', function () {
        return redirect()->route('form-wizard-three');
    })->name('form-wizard-three-post');
});

Route::prefix('tables')->group(function () {
    Route::view('bootstrap-basic-table', 'tables.bootstrap-basic-table')->name('bootstrap-basic-table');
    Route::view('bootstrap-sizing-table', 'tables.bootstrap-sizing-table')->name('bootstrap-sizing-table');
    Route::view('bootstrap-border-table', 'tables.bootstrap-border-table')->name('bootstrap-border-table');
    Route::view('bootstrap-styling-table', 'tables.bootstrap-styling-table')->name('bootstrap-styling-table');
    Route::view('table-components', 'tables.table-components')->name('table-components');
    Route::view('datatable-basic-init', 'tables.datatable-basic-init')->name('datatable-basic-init');
    Route::view('datatable-advance', 'tables.datatable-advance')->name('datatable-advance');
    Route::view('datatable-styling', 'tables.datatable-styling')->name('datatable-styling');
    Route::view('datatable-ajax', 'tables.datatable-ajax')->name('datatable-ajax');
    Route::view('datatable-server-side', 'tables.datatable-server-side')->name('datatable-server-side');
    Route::view('datatable-plugin', 'tables.datatable-plugin')->name('datatable-plugin');
    Route::view('datatable-api', 'tables.datatable-api')->name('datatable-api');
    Route::view('datatable-data-source', 'tables.datatable-data-source')->name('datatable-data-source');
    Route::view('datatable-ext-autofill', 'tables.datatable-ext-autofill')->name('datatable-ext-autofill');
    Route::view('datatable-ext-basic-button', 'tables.datatable-ext-basic-button')->name('datatable-ext-basic-button');
    Route::view('datatable-ext-col-reorder', 'tables.datatable-ext-col-reorder')->name('datatable-ext-col-reorder');
    Route::view('datatable-ext-fixed-header', 'tables.datatable-ext-fixed-header')->name('datatable-ext-fixed-header');
    Route::view('datatable-ext-html-5-data-export', 'tables.datatable-ext-html-5-data-export')->name('datatable-ext-html-5-data-export');
    Route::view('datatable-ext-key-table', 'tables.datatable-ext-key-table')->name('datatable-ext-key-table');
    Route::view('datatable-ext-responsive', 'tables.datatable-ext-responsive')->name('datatable-ext-responsive');
    Route::view('datatable-ext-row-reorder', 'tables.datatable-ext-row-reorder')->name('datatable-ext-row-reorder');
    Route::view('datatable-ext-scroller', 'tables.datatable-ext-scroller')->name('datatable-ext-scroller');
    Route::view('jsgrid-table', 'tables.jsgrid-table')->name('jsgrid-table');
});

Route::prefix('charts')->group(function () {
    Route::view('echarts', 'charts.echarts')->name('echarts');
    Route::view('chart-apex', 'charts.chart-apex')->name('chart-apex');
    Route::view('chart-google', 'charts.chart-google')->name('chart-google');
    Route::view('chart-sparkline', 'charts.chart-sparkline')->name('chart-sparkline');
    Route::view('chart-flot', 'charts.chart-flot')->name('chart-flot');
    Route::view('chart-knob', 'charts.chart-knob')->name('chart-knob');
    Route::view('chart-morris', 'charts.chart-morris')->name('chart-morris');
    Route::view('chartjs', 'charts.chartjs')->name('chartjs');
    Route::view('chartist', 'charts.chartist')->name('chartist');
    Route::view('chart-peity', 'charts.chart-peity')->name('chart-peity');
});

Route::view('sample-page', 'pages.sample-page')->name('sample-page');
Route::view('internationalization', 'pages.internationalization')->name('internationalization');

// Route::prefix('starter-kit')->group(function () {
// });

Route::prefix('others')->group(function () {
    Route::view('400', 'errors.400')->name('error-400');
    Route::view('401', 'errors.401')->name('error-401');
    Route::view('403', 'errors.403')->name('error-403');
    Route::view('404', 'errors.404')->name('error-404');
    Route::view('500', 'errors.500')->name('error-500');
    Route::view('503', 'errors.503')->name('error-503');
});

Route::prefix('authentication')->group(function () {
    // Route::view('login', 'authentication.login')->name('login');
    // Route::view('login-one', 'authentication.login-one')->name('login-one');
    // Route::view('login-two', 'authentication.login-two')->name('login-two');
    // Route::view('login-bs-validation', 'authentication.login-bs-validation')->name('login-bs-validation');
    // Route::view('login-bs-tt-validation', 'authentication.login-bs-tt-validation')->name('login-bs-tt-validation');
    // Route::view('login-sa-validation', 'authentication.login-sa-validation')->name('login-sa-validation');
    Route::view('sign-up', 'authentication.sign-up')->name('sign-up');
    // Route::view('sign-up-one', 'authentication.sign-up-one')->name('sign-up-one');
    // Route::view('sign-up-two', 'authentication.sign-up-two')->name('sign-up-two');
    // Route::view('sign-up-wizard', 'authentication.sign-up-wizard')->name('sign-up-wizard');
    // Route::view('unlock', 'authentication.unlock')->name('unlock');
    Route::view('forget-password', 'authentication.forget-password')->name('forget-password');
    Route::view('reset-password', 'authentication.reset-password')->name('reset-password');
    Route::view('maintenance', 'authentication.maintenance')->name('maintenance');
});

Route::view('comingsoon', 'comingsoon.comingsoon')->name('comingsoon');
Route::view('comingsoon-bg-video', 'comingsoon.comingsoon-bg-video')->name('comingsoon-bg-video');
Route::view('comingsoon-bg-img', 'comingsoon.comingsoon-bg-img')->name('comingsoon-bg-img');

Route::view('basic-template', 'email-templates.basic-template')->name('basic-template');
Route::view('email-header', 'email-templates.email-header')->name('email-header');
Route::view('template-email', 'email-templates.template-email')->name('template-email');
Route::view('template-email-2', 'email-templates.template-email-2')->name('template-email-2');
Route::view('ecommerce-templates', 'email-templates.ecommerce-templates')->name('ecommerce-templates');
Route::view('email-order-success', 'email-templates.email-order-success')->name('email-order-success');

Route::prefix('gallery')->group(function () {
    Route::view('index', 'apps.gallery')->name('gallery');
    Route::view('with-gallery-description', 'apps.gallery-with-description')->name('gallery-with-description');
    Route::view('gallery-masonry', 'apps.gallery-masonry')->name('gallery-masonry');
    Route::view('masonry-gallery-with-disc', 'apps.masonry-gallery-with-disc')->name('masonry-gallery-with-disc');
    Route::view('gallery-hover', 'apps.gallery-hover')->name('gallery-hover');
});

Route::prefix('blog')->group(function () {
    Route::view('index', 'apps.blog')->name('blog');
    Route::view('blog-single', 'apps.blog-single')->name('blog-single');
    Route::view('add-post', 'apps.add-post')->name('add-post');
});

Route::view('faq', 'apps.faq')->name('faq');

Route::prefix('job-search')->group(function () {
    Route::view('job-cards-view', 'apps.job-cards-view')->name('job-cards-view');
    Route::view('job-list-view', 'apps.job-list-view')->name('job-list-view');
    Route::view('job-details', 'apps.job-details')->name('job-details');
    Route::view('job-apply', 'apps.job-apply')->name('job-apply');
});

Route::prefix('learning')->group(function () {
    Route::view('learning-list-view', 'apps.learning-list-view')->name('learning-list-view');
    Route::view('learning-detailed', 'apps.learning-detailed')->name('learning-detailed');
});

Route::prefix('maps')->group(function () {
    Route::view('map-js', 'apps.map-js')->name('map-js');
    Route::view('vector-map', 'apps.vector-map')->name('vector-map');
});

Route::prefix('editors')->group(function () {
    Route::view('summernote', 'apps.summernote')->name('summernote');
    Route::view('ckeditor', 'apps.ckeditor')->name('ckeditor');
    Route::view('simple-mde', 'apps.simple-mde')->name('simple-mde');
    Route::view('ace-code-editor', 'apps.ace-code-editor')->name('ace-code-editor');
});

Route::view('knowledgebase', 'apps.knowledgebase')->name('knowledgebase');
Route::view('support-ticket', 'apps.support-ticket')->name('support-ticket');
Route::view('landing-page', 'pages.landing-page')->name('landing-page');

Route::prefix('layouts')->group(function () {
    Route::view('compact-sidebar', 'admin_unique_layouts.compact-sidebar'); //default //Dubai
    Route::view('box-layout', 'admin_unique_layouts.box-layout'); //default //New York //
    Route::view('dark-sidebar', 'admin_unique_layouts.dark-sidebar');

    Route::view('default-body', 'admin_unique_layouts.default-body');
    Route::view('compact-wrap', 'admin_unique_layouts.compact-wrap');
    Route::view('enterprice-type', 'admin_unique_layouts.enterprice-type');

    Route::view('compact-small', 'admin_unique_layouts.compact-small');
    Route::view('advance-type', 'admin_unique_layouts.advance-type');
    Route::view('material-layout', 'admin_unique_layouts.material-layout');

    Route::view('color-sidebar', 'admin_unique_layouts.color-sidebar');
    Route::view('material-icon', 'admin_unique_layouts.material-icon');
    Route::view('modern-layout', 'admin_unique_layouts.modern-layout');
});

Route::get('layout-{light}', function ($light) {
    session()->put('layout', $light);
    session()->get('layout');
    if ($light == 'vertical-layout') {
        return redirect()->route('pages-vertical-layout');
    }
    return redirect()->route('index');
    return 1;
});
Route::get('/clear-cache', function () {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Cache is cleared";
})->name('clear.cache');

//////////////////////////////////////////////////////////////////////////

Route::get('/terms', function () {
    return view('user/SideComponent/terms');

});

Route::get('/faq', function () {
    return view('user/SideComponent/faq');

});
Route::get('/privacy', function () {
    return view('user/SideComponent/privacy');

});

//job post

Route::get('/postjob', function () {
    return view('user.postvacancy.postvacancy');
})->name('user.postvacancy');

Route::get('/postjob/new', [PackageContactController::class, 'index'])->name('user.postvacancy');

Route::get('/postjob/topads', function () {
    return view('user.postvacancy.topads');
})->name('user.postvacancy.topads');

Route::get('/postjob/bannerposting', function () {
    return view('user.postvacancy.bannerposting');
})->name('user.postvacancy.bannerposting');

// payment methods

Route::get('/user/postvacancy/paymentmethod/onlinefundtransfer', [BankAccountController::class, 'index'])
    ->name('user.postvacancy.paymentmethod.onlinefundtransfer');
Route::get('/postjob/ipg', [ContactListController::class, 'home'])
    ->name('user.postvacancy.paymentmethod.ipg');
Route::get('/postjob/overthecounter', function () {
    return view('user.postvacancy.paymentmethod.overthecounter');
})->name('user.postvacancy.paymentmethod.overthecounter');

Route::get('/postjob/qrcodeforjobads', function () {
    return view('user.postvacancy.paymentmethod.qrcodeforjobads');
})->name('user.postvacancy.paymentmethod.qrcodeforjobads');

//profileviewmain

//my jobs

// job alerts

Route::get('/mainprofileview/alerts', function () {
    return view('user.jobseekerprofile.jobalerts.jobalerts');
})->name('user.jobseekerprofile.jobalerts.jobalerts');

// apply route

// Route::get('/apply', function () {
//     return view('home.jobs.apply');
// })->name('home.jobs.apply');
Route::get('/apply/{job}', [ApplicationController::class, 'showApplyForm'])->name('apply.form');
Route::post('/apply', [ApplicationController::class, 'submitForm'])->name('apply.submit');

// feedback
Route::get('/reviews', [FeedbackController::class, 'index'])->name('feedback.home');
Route::middleware(['auth'])->group(function () {
    Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
});
Route::middleware(['employer'])->group(function () {
    Route::get('/employer/feedback', [FeedbackController::class, 'employercreate'])->name('employer.feedback.create');
    Route::post('/employer/feedback', [FeedbackController::class, 'employerstore'])->name('employer.feedback.store');
});
Route::middleware('admin')->group(function () {
    Route::get('/admin/feedback', [FeedbackController::class, 'manageFeedback'])->name('admin.feedback.manage');
    Route::post('/admin/feedback/{feedback}/update', [FeedbackController::class, 'update'])->name('admin.feedback.update');
    Route::delete('/admin/feedback/{feedback}', [FeedbackController::class, 'destroy'])->name('admin.feedback.destroy');
});

Route::get('/alerts', function () {
    return view('user/jobseekerprofile/jobalerts/jobalerts');

});

Route::middleware(['admin', 'superadmin'])->group(function () {
    Route::get('/admin/list', [AdminAuthController::class, 'adminList'])->name('admin.list');
    Route::post('/admin/toggle-status/{id}', [AdminAuthController::class, 'toggleStatus'])->name('admin.toggleStatus');
});

Route::patch('/job-postings/{id}/toggle-active', [JobPostingController::class, 'toggleActiveStatus'])
    ->name('job_postings.toggle_active')
    ->middleware('employer'); // Ensure only authenticated employers can access this route

Route::get('/employer-register', function () {
    return view('Admin.employerregister');
})->middleware('admin')->name('register.adminemployer');
Route::post('/register-employer', [EmployerAuthController::class, 'extraregister'])->name('register.extraemployer')->middleware('admin');

//admin reset password
Route::get('/admin/password/reset', [AdminForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');
Route::post('/admin/password/email', [AdminForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');
Route::get('/admin/password/reset/{token}', [AdminResetPasswordController::class, 'showResetForm'])->name('admin.password.reset');
Route::post('/admin/password/reset', [AdminResetPasswordController::class, 'reset'])->name('admin.password.update');
// admin
Route::get('/admin/job-postings/create', [JobPostingController::class, 'createForAdmin'])
    ->name('admin.job_postings.create')
    ->middleware('auth:admin'); // Ensure only admins can access
Route::post('/admin/job-postings/create', [JobPostingController::class, 'storeForAdmin'])
    ->name('admin.job_postings.store')
    ->middleware('auth:admin');
Route::get('/employers/search', [EmployerAuthController::class, 'search']);

Route::get('/package-contacts', [PackageContactController::class, 'index'])->name('package-contacts.index'); // Fetch all
Route::get('/package-contacts/create', [PackageContactController::class, 'create'])->name('package-contacts.create')->middleware('auth:admin');
Route::post('/package-contacts', [PackageContactController::class, 'store'])->name('package-contacts.store')->middleware('auth:admin'); // Create
Route::put('/package-contacts/{id}', [PackageContactController::class, 'update'])->name('package-contacts.update')->middleware('auth:admin'); // Update
Route::delete('/package-contacts/{id}', [PackageContactController::class, 'destroy'])->name('package-contacts.destroy')->middleware('auth:admin'); // Delete

Route::get('admin/packages', [PackageController::class, 'index'])->name('admin.packages.index')->middleware('auth:admin');
Route::get('admin/packages/create', [PackageController::class, 'create'])->name('admin.packages.create')->middleware('auth:admin');
Route::post('admin/packages', [PackageController::class, 'store'])->name('admin.packages.store')->middleware('auth:admin');
Route::get('admin/packages/{package}', [PackageController::class, 'show'])->name('admin.packages.show')->middleware('auth:admin');
Route::get('admin/packages/{package}/edit', [PackageController::class, 'edit'])->name('admin.packages.edit')->middleware('auth:admin');
Route::put('admin/packages/{package}', [PackageController::class, 'update'])->name('admin.packages.update')->middleware('auth:admin');
Route::delete('admin/packages/{package}', [PackageController::class, 'destroy'])->name('admin.packages.destroy')->middleware('auth:admin');

Route::get('/contacts/list', [ContactListController::class, 'index'])->name('contacts.index')->middleware('auth:admin');
Route::get('/contacts/create', [ContactListController::class, 'create'])->name('contacts.create')->middleware('auth:admin');
Route::get('/contacts', [ContactListController::class, 'show'])->name('contacts.show');
Route::post('/contacts', [ContactListController::class, 'store'])->name('contacts.store')->middleware('auth:admin');
Route::get('/contacts/{contact}/edit', [ContactListController::class, 'edit'])->name('contactslist.edit')->middleware('auth:admin');

Route::put('/contacts/{id}', [ContactListController::class, 'update'])->name('contactslist.update')->middleware('auth:admin');
Route::delete('/contacts/{id}', [ContactListController::class, 'destroy'])->name('contacts.destroy')->middleware('auth:admin');
Route::post('contacts/store-multiple', [ContactListController::class, 'storeMultiple'])->name('contacts.store-multiple')->middleware('auth:admin');

Route::get('/reports/job-ads', [JobPostingController::class, 'generateJobAdsReport'])->name('reports.job-ads')->middleware(['superadmin']);

// Route for generating the customer report
Route::get('/reports/customers', [JobPostingController::class, 'generateCustomerReport'])->name('reports.customers')->middleware(['superadmin']);
Route::get('/admin/employer-stats', [EmployerAuthController::class, 'employerStats'])->name('admin.employer.stats')->middleware(['superadmin']);

Route::prefix('admin')->group(function () {
    Route::get('/bank-accounts', [BankAccountController::class, 'indexadmin'])->name('admin.bank-accounts.index')->middleware('auth:admin');
    Route::get('/bank-accounts/create', [BankAccountController::class, 'create'])->name('admin.bank-accounts.create')->middleware('auth:admin');
    Route::post('/bank-accounts', [BankAccountController::class, 'store'])->name('admin.bank-accounts.store')->middleware('auth:admin');
    Route::get('/bank-accounts/{bankAccount}/edit', [BankAccountController::class, 'edit'])->name('admin.bank-accounts.edit')->middleware('auth:admin');
    Route::put('/bank-accounts/{bankAccount}', [BankAccountController::class, 'update'])->name('admin.bank-accounts.update')->middleware('auth:admin');
    Route::delete('/bank-accounts/{bankAccount}', [BankAccountController::class, 'destroy'])->name('admin.bank-accounts.destroy')->middleware('auth:admin');
});

// Regular bank account routes
Route::get('/bank-accounts', [BankAccountController::class, 'index'])->name('bank-accounts.index');

Route::prefix('admin')->middleware(['admin'])->group(function () {

    Route::get('/banner-packages', [BannerPackageController::class, 'index'])->name('banner_packages.index');
    Route::get('/banner-packages/create', [BannerPackageController::class, 'create'])->name('banner_packages.create');
    Route::post('/banner-packages', [BannerPackageController::class, 'store'])->name('banner_packages.store');
    Route::get('/banner-packages/{bannerPackage}/edit', [BannerPackageController::class, 'edit'])->name('banner_packages.edit');
    Route::put('/banner-packages/{bannerPackage}', [BannerPackageController::class, 'update'])->name('banner_packages.update');
    Route::delete('/banner-packages/{bannerPackage}', [BannerPackageController::class, 'destroy'])->name('banner_packages.destroy');

    Route::get('/banner-details/create', [BannerDetailsController::class, 'create'])->name('bannerdetails.create');
    Route::post('/banner-details/store', [BannerDetailsController::class, 'store'])->name('bannerdetails.store');
});

Route::prefix('admin')->middleware(['admin'])->group(function () {
    // Display a listing of the banners
    Route::get('/banners', [BannerController::class, 'index'])->name('banners.index');

    // Show the form for creating a new banner
    Route::get('/banners/create', [BannerController::class, 'create'])->name('banners.create');

    // Store a newly created banner in storage
    Route::post('/banners', [BannerController::class, 'store'])->name('banners.store');

    // Show the form for editing the specified banner
    Route::get('/banners/{banner}/edit', [BannerController::class, 'edit'])->name('banners.edit');

    // Update the specified banner in storage
    Route::put('/banners/{banner}', [BannerController::class, 'update'])->name('banners.update');

    // Update the status of a banner
    Route::patch('/banners/{banner}/status', [BannerController::class, 'updateStatus'])->name('banners.updateStatus');

    Route::put('/admin/banners/{banner}/update-status', [BannerController::class, 'updateStatus'])
        ->name('admin.banners.update-status');

    // Remove the specified banner from storage
    Route::delete('/banners/{id}', [BannerController::class, 'destroy'])->name('banners.destroy');
});

Route::middleware('auth:employer')->group(function () {
    Route::get('emp/banners', [EmpBannerController::class, 'index'])->name('empbanners.index');

    // Show the form for creating a new banner
    Route::get('emp/banners/create', [EmpBannerController::class, 'create'])->name('empbanners.create');

    // Store a newly created banner in storage
    Route::post('emp/banners', [EmpBannerController::class, 'store'])->name('empbanners.store');

    // Show the form for editing the specified banner
    Route::get('emp/banners/{banner}/edit', [EmpBannerController::class, 'edit'])->name('empbanners.edit');

    // Update the specified banner in storage
    Route::put('emp/banners/{banner}', [EmpBannerController::class, 'update'])->name('empbanners.update');
    // Remove the specified banner from storage
    Route::delete('emp/banners/{banner}', [EmpBannerController::class, 'destroy'])->name('empbanners.destroy');
});

Route::middleware(['admin'])->group(function () {
    Route::get('/countries', [CountryController::class, 'index'])->name('countries.index');
    Route::get('/countries/create', [CountryController::class, 'create'])->name('countries.create');
    Route::post('/countries', [CountryController::class, 'store'])->name('countries.store');
    Route::get('/countries/{country}/edit', [CountryController::class, 'edit'])->name('countries.edit');
    Route::put('/countries/{country}', [CountryController::class, 'update'])->name('countries.update');
    Route::delete('/countries/{country}', [CountryController::class, 'destroy'])->name('countries.destroy');
    Route::get('/admin/job-report/date-range', [JobPostingController::class, 'generateJobAdsReportByDateRange'])
        ->name('admin.job.report.daterange');
});
// routes/web.php
