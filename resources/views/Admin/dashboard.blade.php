@extends('layouts.admin.master')

@section('title', 'Dashboard')

@section('css')
<style>
    .card {
        border-radius: 1rem;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        background: white;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    /* Applications Icon */
    .stat-icon.applications-icon {
        background: linear-gradient(135deg, #3B82F6 0%, #60A5FA 100%);
        box-shadow: 0 8px 16px -4px rgba(59, 130, 246, 0.3);
    }

    /* Jobs Icon */
    .stat-icon.jobs-icon {
        background: linear-gradient(135deg, #10B981 0%, #34D399 100%);
        box-shadow: 0 8px 16px -4px rgba(16, 185, 129, 0.3);
    }

    /* Jobseekers Icon */
    .stat-icon.jobseekers-icon {
        background: linear-gradient(135deg, #F59E0B 0%, #FBBF24 100%);
        box-shadow: 0 8px 16px -4px rgba(245, 158, 11, 0.3);
    }

    /* Views Icon */
    .stat-icon.views-icon {
        background: linear-gradient(135deg, #6366F1 0%, #818CF8 100%);
        box-shadow: 0 8px 16px -4px rgba(99, 102, 241, 0.3);
    }

    /* Earnings Icon */
    .stat-icon.earnings-icon {
        background: linear-gradient(135deg, #0EA5E9 0%, #38BDF8 100%);
        box-shadow: 0 8px 16px -4px rgba(14, 165, 233, 0.3);
    }

    .stat-icon i {
        color: white !important;
        font-size: 1.5rem;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
    }

    .stat-icon:hover {
        transform: translateY(-2px);
        filter: brightness(1.1);
    }

    .welcome-section {
        background: linear-gradient(135deg, #4158D0 0%, #C850C0 46%, #FFCC70 100%);
        border-radius: 1rem;
        color: white;
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .animated-number {
        font-size: 2rem;
        font-weight: 700;
        color: #1F2937;
    }

    .stat-label {
        color: #6B7280;
        font-size: 0.875rem;
        font-weight: 500;
        margin-top: 0.5rem;
    }

    .card-body {
        padding: 1.5rem;
    }
</style>
@endsection

@section('breadcrumb-title')
<h3>Welcome Back, {{ auth('admin')->name }}</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Dashboard</li>
@endsection

@section('content')
<div class="container-fluid p-4">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-section p-4 shadow-sm rounded-lg">
                <div class="row align-items-center">

                    <div class="col-md-4 d-none d-md-block">
                        <img src="{{ asset('assets/images/dashboard/welcome-illustration.svg') }}"
                            class="w-50 img-fluid" alt="Welcome">
                    </div>
                    <div class="col-md-8">
                        <h2 class="mb-3 fw-bold text-primary">Welcome to JoBads.lk</h2>
                        <p class="mb-4 opacity-75">Here’s your dashboard overview for today.</p>
                        <!-- <button class="btn btn-gradient px-4 py-2 rounded-pill">What's New?</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="row g-4">

        <!-- User Section -->
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">User Overview</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6 col-lg-3">
                            <div class="card text-white bg-info shadow-sm">
                                <div class="card-body">
                                    <i class="fas fa-users fa-2x"></i>
                                    <h6>Total Job Seekers</h6>
                                    <h5>{{ number_format($statistics['total_jobseekers'] ?? 0) }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="card text-white bg-info shadow-sm">
                                <div class="card-body">
                                    <i class="fas fa-user-tie fa-2x"></i>
                                    <h6>Total Employers</h6>
                                    <h5>{{ number_format($statistics['total_companies'] ?? 0) }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="card text-white bg-info shadow-sm">
                                <div class="card-body">
                                    <i class="fas fa-user-shield fa-2x"></i>
                                    <h6>Total Admins</h6>
                                    <h5>{{ number_format($statistics['total_admins'] ?? 0) }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="card text-white bg-info shadow-sm">
                                <div class="card-body">
                                    <i class="fas fa-user-shield fa-2x"></i>
                                    <h6>Total Super Admins</h6>
                                    <h5>{{ number_format($statistics['total_super_admins'] ?? 0) }}</h5>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- Job Section -->
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Job Overview</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6 col-lg-3">
                            <div class="card text-white bg-success shadow-sm">
                                <div class="card-body">
                                    <i class="fas fa-briefcase fa-2x"></i>
                                    <h6>Total Jobs</h6>
                                    <h5>{{ number_format($statistics['total_jobs'] ?? 0) }}</h5>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-lg-3">
                            <a href="{{ route('job_postings.index') }}" class="text-decoration-none">
                                <div class="card text-white bg-success shadow-sm">
                                    <div class="card-body">
                                        <i class="fas fa-clock fa-2x"></i>
                                        <h6>Pending Jobs</h6>
                                        <h5>{{ number_format($statistics['total_pending_jobs'] ?? 0) }}</h5>
                                    </div>
                                </div>
                            </a>
                        </div>


                        <div class="col-md-6 col-lg-3">
                            <div class="card text-white bg-success shadow-sm">
                                <div class="card-body">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                    <h6>Approved Jobs</h6>
                                    <h5>{{ number_format($statistics['total_approved_jobs'] ?? 0) }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="card text-white bg-success shadow-sm">
                                <div class="card-body">
                                    <i class="fas fa-briefcase fa-2x"></i>
                                    <h6>Current Jobs</h6>
                                    <h5>{{ number_format($statistics['total_jobs_posted'] ?? 0) }}</h5>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Banner Section -->
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Banner Overview</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6 col-lg-3">
                            <div class="card text-white bg-warning shadow-sm">
                                <div class="card-body">
                                    <i class="fas fa-image fa-2x"></i>
                                    <h6>Total Banners</h6>
                                    <h5>{{ number_format($statistics['total_banners'] ?? 0) }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <a href="{{ route('banners.index') }}" class="text-decoration-none">
                                <div class="card text-white bg-warning shadow-sm">
                                    <div class="card-body">
                                        <i class="fas fa-clock fa-2x"></i>
                                        <h6>Pending Banners</h6>
                                        <h5>{{ number_format($statistics['total_pending_banners'] ?? 0) }}</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="card text-white bg-warning shadow-sm">
                                <div class="card-body">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                    <h6>Approved Banners</h6>
                                    <h5>{{ number_format($statistics['total_approved_banners'] ?? 0) }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="card text-white bg-warning shadow-sm">
                                <div class="card-body">
                                    <i class="fas fa-image fa-2x"></i>
                                    <h6>Current Banners</h6>
                                    <h5>{{ number_format($statistics['total_current_banners'] ?? 0) }}</h5>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Section -->
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Summary Overview</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6 col-lg-3">
                            <div class="card text-white bg-dark shadow-sm">
                                <div class="card-body">
                                    <i class="fas fa-dollar-sign fa-2x"></i>
                                    <h6>Job Earnings</h6>
                                    <h5>Rs. {{ number_format($statistics['total_earnings'] ?? 0) }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="card text-white bg-dark shadow-sm">
                                <div class="card-body">
                                    <i class="fas fa-dollar-sign fa-2x"></i>
                                    <h6>Banner Earnings</h6>
                                    <h5>Rs. {{ number_format($statistics['total_banner_earnings'] ?? 0) }}</h>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="card text-white bg-dark shadow-sm">
                                <div class="card-body">
                                    <i class="fas fa-file-alt fa-2x"></i>
                                    <h6>Total Applications</h6>
                                    <h5>{{ number_format($statistics['total_applications'] ?? 0) }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="card text-white bg-dark shadow-sm">
                                <div class="card-body">
                                    <i class="fas fa-eye fa-2x"></i>
                                    <h6>Total Views</h6>
                                    <h5>{{ number_format($statistics['total_views'] ?? 0) }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>







    <!-- Stats Cards -->
    <!-- <div class="row g-4">
      
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="stat-icon applications-icon">
                            <i class="fas fa-file-alt fa-lg"></i>
                        </div>

                    </div>
                    <h3 class="animated-number mb-1">
                        {{ number_format($statistics['total_applications'] ?? 0) }}
                    </h3>
                    <p class="stat-label mb-0">Total Applications</p>
                </div>
            </div>
        </div>

     
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="stat-icon jobs-icon">
                            <i class="fas fa-briefcase fa-lg"></i>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-link p-0" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v text-muted"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">View Jobs</a></li>
                                <li><a class="dropdown-item" href="#">Post New Job</a></li>
                            </ul>
                        </div>
                    </div>
                    <h3 class="animated-number mb-1">
                        {{ number_format($statistics['total_jobs_posted'] ?? 0) }}
                    </h3>
                    <p class="stat-label mb-0">Jobs Posted</p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="stat-icon jobseekers-icon">
                            <i class="fas fa-users fa-lg"></i>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-link p-0" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v text-muted"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">View Jobseekers</a></li>
                                <li><a class="dropdown-item" href="#">Export List</a></li>
                            </ul>
                        </div>
                    </div>
                    <h3 class="animated-number mb-1">
                        {{ number_format($statistics['total_jobseekers'] ?? 0) }}
                    </h3>
                    <p class="stat-label mb-0">Total Jobseekers</p>
                </div>
            </div>
        </div>

   
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="stat-icon views-icon">
                            <i class="fas fa-eye fa-lg"></i>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-link p-0" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v text-muted"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Views</a></li>
                                <li><a class="dropdown-item" href="#">Export List</a></li>
                            </ul>
                        </div>
                    </div>
                    <h3 class="animated-number mb-1">
                        {{ number_format($statistics['total_views'] ?? 0) }}
                    </h3>
                    <p class="stat-label mb-0">Total Views</p>
                </div>
            </div>
        </div>


        <div class="col-sm-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="stat-icon earnings-icon">
                            <i class="fas fa-dollar-sign fa-lg"></i>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-link p-0" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v text-muted"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">View Earnings</a></li>
                                <li><a class="dropdown-item" href="#">Download Report</a></li>
                            </ul>
                        </div>
                    </div>
                    <h3 class=" mb-1">
                        Rs. {{ number_format($statistics['total_earnings'] ?? 0) }}
                    </h3>
                    <p class="stat-label mb-0">Total Earnings</p>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Recent Applications Section -->
    <!-- <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="card-title mb-0">Recent Applications</h5>
                            <p class="text-muted small mb-0">Last 7 days: {{ $statistics['recent_applications'] ?? 0 }}
                                applications
                                @if (isset($statistics['application_growth']))
                                <span
                                    class="ms-2 {{ $statistics['application_growth'] > 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $statistics['application_growth'] > 0 ? '+' : '' }}{{ $statistics['application_growth'] }}%
                                </span>
                                @endif
                            </p>
                        </div>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-sm">View All</a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/dashboard/modern.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const animateValue = (element, start, end, duration) => {
            let current = start;
            const range = end - start;
            const increment = end > start ? 1 : -1;
            const stepTime = Math.abs(Math.floor(duration / range));

            const timer = setInterval(() => {
                current += increment;
                element.textContent = current.toLocaleString();
                if (current === end) {
                    clearInterval(timer);
                }
            }, stepTime);
        };

        document.querySelectorAll('.animated-number').forEach(element => {
            const finalValue = parseInt(element.textContent.replace(/,/g, ''));
            animateValue(element, 0, finalValue, 1000);
        });
    });
</script>
@endsection