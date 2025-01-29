@extends('layouts.authentication.master')
@section('title', 'Employer Register')

@section('css')
    <!-- Add custom CSS links if needed -->
@endsection

@section('style')
    <style>
        /* Add any custom styles if needed */
    </style>
@endsection

@section('content')
    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-12 p-0">
                <div class="login-card">
                    <div>
                        <div class="text-center">
                            <a class="logo" href="{{ route('index') }}">
                                <x-application-logo />
                            </a>
                        </div>
                        <div class="login-main">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <h4>Create Your Job Seeker Account</h4>
                                <p>Enter your details to register</p>

                                <!-- Name -->
                                <div class="form-group">
                                    <label class="col-form-label pt-0">Name</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                        placeholder="Name" required>
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label class="col-form-label">Email Address</label>
                                    <input type="email" id="email" name="email" class="form-control"
                                        placeholder="example@company.com" required>
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                               <!-- Phone Number -->
                                <div class="form-group">
                                    <label class="col-form-label">Phone Number</label>
                                    <input type="text" name="phone_number"  id="phone_number" class="form-control"
                                        placeholder="Phone Number">
                                    <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                                </div>

                                <!-- Password -->
                                <div class="form-group">
                                    <label class="col-form-label">Password</label>
                                    <input type="password" id="password" name="password" class="form-control" placeholder="*********"
                                        required>
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-group">
                                    <label class="col-form-label">Confirm Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                                        placeholder="*********" required>
                                </div>
                             
                                <!-- Sign-in Link -->
                                <p class="mt-4 mb-0">
                                    Already have an account? <a href="{{ route('login') }}" class="ms-2">Sign
                                        in</a>
                                </p>

                                <button type="submit" class="btn btn-primary btn-block">Register</button>
                               
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

