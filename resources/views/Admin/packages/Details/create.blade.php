@extends('layouts.admin.master')

@section('title', 'Create Package')

@section('css')
<!-- Add any CSS files related to the page here -->
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
@endsection

@section('breadcrumb-title')
<h3>Create Package</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Dashboard</li>
<li class="breadcrumb-item active">Create Package</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Create New Package</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.packages.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                <label for="package_size">Package Size (Number of Posts):</label>
                                <input type="number" name="package_size" id="package_size" class="form-control" required>
                            </div>

                            <div class="form-group mb-3 col-md-6">
                                <label for="duration_days">Duration (Days):</label>
                                <select name="duration_days" id="duration_days" class="form-control" required>
                                    <option value="">Select Duration</option>
                                    <option value="20">20 Days</option>
                                    <option value="30">30 Days</option>
                                </select>
                            </div>

                            <div class="form-group mb-3 col-md-6">
                                <label for="lkr_price">LKR Price:</label>
                                <input type="text" name="lkr_price" id="lkr_price" class="form-control" required>
                            </div>

                            <div class="form-group mb-3 col-md-6">
                                <label for="usd_price">USD Price:</label>
                                <input type="text" name="usd_price" id="usd_price" class="form-control" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Package</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/clock.js') }}"></script>
<script src="{{ asset('assets/js/chart/apex-chart/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('assets/js/dashboard/default.js') }}"></script>
<script src="{{ asset('assets/js/notify/index.js') }}"></script>
<script src="{{ asset('assets/js/typeahead/handlebars.js') }}"></script>
<script src="{{ asset('assets/js/typeahead/typeahead.bundle.js') }}"></script>
<script src="{{ asset('assets/js/typeahead/typeahead.custom.js') }}"></script>
<script src="{{ asset('assets/js/typeahead-search/handlebars.js') }}"></script>
<script src="{{ asset('assets/js/typeahead-search/typeahead-custom.js') }}"></script>
<script src="{{ asset('assets/js/height-equal.js') }}"></script>
<script src="{{ asset('assets/js/animation/wow/wow.min.js') }}"></script>
@endsection