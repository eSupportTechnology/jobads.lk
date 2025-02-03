<?php
// Get query parameters with proper fallbacks
$name = request()->query('name', auth()->user()->name);
$email = request()->query('email', auth()->user()->email);
$contact_number = request()->query('contact_number', $user->phone_number);
$message = request()->query('message', '');
$employer_id = request()->query('employer_id');
$job_posting_id = request()->query('job_posting_id');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV - {{ $user->name }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --text-color: #333;
            --sidebar-color: #f5f6fa;
            --light-gray: #f8f9fa;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            color: var(--text-color);
            line-height: 1.6;
            background: #fff;
        }

        .cv-container {
            max-width: 1200px;
            margin: 20px auto;
            display: grid;
            grid-template-columns: 300px 1fr;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .sidebar {
            background: var(--sidebar-color);
            padding: 30px;
        }

        .main-content {
            padding: 30px;
            background: white;
        }

        .profile-image-container {
            width: 200px;
            height: 200px;
            margin: 0 auto 20px;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid var(--secondary-color);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .profile-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .contact-section {
            margin-bottom: 30px;
        }

        .section-title {
            color: var(--primary-color);
            font-size: 1.4em;
            font-weight: bold;
            margin-bottom: 15px;
            border-bottom: 2px solid var(--secondary-color);
            padding-bottom: 5px;
        }

        .contact-info {
            margin-bottom: 20px;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 10px;
        }

        .contact-item i {
            color: var(--secondary-color);
            width: 20px;
            margin-top: 5px;
        }

        .expertise-list {
            list-style: none;
        }

        .expertise-item {
            background: white;
            margin-bottom: 8px;
            padding: 8px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .name-title {
            font-size: 2.5em;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .profile-text {
            margin-bottom: 30px;
            text-align: justify;
            padding: 20px;
            background: var(--light-gray);
            border-radius: 8px;
        }

        .experience-item {
            margin-bottom: 25px;
        }

        .job-title {
            font-size: 1.2em;
            color: var(--primary-color);
            font-weight: bold;
            margin-bottom: 5px;
        }

        .company-name {
            color: var(--secondary-color);
            font-weight: 600;
            margin-bottom: 5px;
        }

        .date-range {
            color: #666;
            font-style: italic;
            margin-bottom: 10px;
        }

        .job-description {
            padding-left: 20px;
        }

        .job-description ul {
            list-style-type: disc;
            margin-left: 20px;
        }

        .education-item {
            margin-bottom: 20px;
        }

        .degree {
            font-weight: bold;
            color: var(--primary-color);
        }

        .download-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--secondary-color);
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 0.9em;
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border: none;
            cursor: pointer;
        }

        .download-btn:hover {
            background: #2980b9;
        }

        @media print {
            .download-btn {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .cv-container {
                grid-template-columns: 1fr;
            }

            .profile-image-container {
                width: 150px;
                height: 150px;
            }
        }
    </style>
</head>

<body>
    <div style="text-align: center; margin-bottom: 20px;">
        {{-- <a href="{{ route('generate.cv') }}" class="download-btn"
            style="{{ isset($hideButton) && $hideButton ? 'display: none;' : '' }}">
            <i class="fas fa-download"></i> Download as PDF
        </a> --}}
        <form action="{{ route('generate.cv3') }}" method="POST">
            @csrf
            <!-- Hidden fields with proper value handling -->
            <input type="hidden" name="name" value="{{ old('name', $name) }}">
            <input type="hidden" name="email" value="{{ old('email', $email) }}">
            <input type="hidden" name="contact_number" value="{{ old('contact_number', $contact_number) }}">
            <input type="hidden" name="employer_id" value="{{ old('employer_id', $employer_id) }}">
            <input type="hidden" name="job_posting_id" value="{{ old('job_posting_id', $job_posting_id) }}">
            <input type="hidden" name="message" value="{{ old('message', $message) }}">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <button type="submit" class="download-btn"
                style="{{ isset($hideButton) && $hideButton ? 'display: none;' : '' }}">
                Submit
            </button>
        </form>
    </div>

    <div class="cv-container">
        <div class="sidebar">
            <div class="profile-image-container">
                @if ($user->profile_image)
                    <img src="{{ Storage::url('profile_images/' . $user->profile_image) }}" alt="Profile Image"
                        class="profile-image">
                @else
                    <img src="{{ asset('images/default-profile.jpg') }}" alt="Default Profile" class="profile-image">
                @endif
            </div>

            <div class="contact-section">
                <h2 class="section-title">CONTACT</h2>
                <div class="contact-info">
                    @if ($user->address)
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>{{ $user->address }}</div>
                        </div>
                    @endif

                    @if ($user->phone_number)
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <div>{{ $user->phone_number }}</div>
                        </div>
                    @endif

                    @if ($user->email)
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <div>{{ $user->email }}</div>
                        </div>
                    @endif

                    @if ($user->linkedin)
                        <div class="contact-item">
                            <i class="fab fa-linkedin"></i>
                            <div>{{ $user->linkedin }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="expertise-section">
                <h2 class="section-title">EXPERTISE</h2>
                <ul class="expertise-list">
                    @if ($user->skills)
                        @foreach (explode(',', $user->skills) as $skill)
                            <li class="expertise-item">{{ trim($skill) }}</li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>

        <div class="main-content">
            <h1 class="name-title">{{ $user->name }}</h1>

            @if ($user->summary)
                <div class="profile-section">
                    <h2 class="section-title">PROFILE</h2>
                    <div class="profile-text">
                        {{ $user->summary }}
                    </div>
                </div>
            @endif

            @if (isset($experiences) && $experiences->count() > 0)
                <div class="experience-section">
                    <h2 class="section-title">WORK EXPERIENCE</h2>
                    @foreach ($experiences as $experience)
                        <div class="experience-item">
                            <div class="job-title">{{ $experience->job_title }}</div>
                            <div class="company-name">{{ $experience->company_name }}</div>
                            <div class="date-range">
                                {{ \Carbon\Carbon::parse($experience->start_date)->format('Y') }} -
                                {{ $experience->end_date ? \Carbon\Carbon::parse($experience->end_date)->format('Y') : 'Present' }}
                            </div>
                            <div class="job-description">
                                {{ $experience->job_description }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @if (isset($educations) && $educations->count() > 0)
                <div class="education-section">
                    <h2 class="section-title">EDUCATION</h2>
                    @foreach ($educations as $education)
                        <div class="education-item">
                            <div class="degree">{{ $education->degree }}</div>
                            @if ($education->field_of_study)
                                <div>{{ $education->field_of_study }}</div>
                            @endif
                            <div class="institution">{{ $education->institution_name }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</body>

</html>
