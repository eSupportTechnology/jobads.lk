<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profileview.css') }}">
    <link rel="stylesheet" href="{{ asset('css/education.css') }}">
    <link rel="stylesheet" href="{{ asset('css/myapplication.css') }}">
    
</head>

<body>
    @include('home.header')
    <h1 class="maintopic"></h1><br />
    <div class=profileview-container>
        <div class ="profileview-header">
            Profile View
        </div>
        <br />
        <p>Manage your CV, photograph, certificates, online profile. featured employers, View/Edit your login details.
        </p>,<br />
        <div class="btn-group mb-4">
            <a href="{{ route('profile.edit') }}" class="btn btn-common" id="commonprofile">Common Profile</a>
            <a href="{{ route('profile.personal') }}" class="btn btn-common" id="personalprofile">Update Profile</a>
            <a href="{{ route('user.jobseekerprofile.education') }}" class="btn btn-common" id="education">Education</a>
            <a href="{{ route('experience.show') }}" class="btn btn-common" id="expirience">Experience</a>
        </div>

    </div>
    <br />

    <div class=profileview-container>
        <div class ="profileview-header">
            My Jobs
        </div>
        <br />
        <p>Manage your CV, photograph, certificates, online profile. featured employers, View/Edit your login details.
        </p>,<br />
        <div class="btn-group mb-4">
            <a href="{{ route('user.jobseekerprofile.myjobs.application') }}" class="btn btn-common"
                id="myapplication">My Applications</a>
            <a href="{{ route('user.flagged_jobs') }}" class="btn btn-common" id="flagged">Flagged Jobs</a>
            <a href="{{ route('generate.index') }}" class="btn btn-common" id="preferred">Create Cv</a>
            {{-- <a href="/mainprofileview/recentjob" class="btn btn-common" id="recent">Recent Jobs</a> --}}
        </div>
    </div>

    {{-- <div class=profileview-container>
        <div class ="profileview-header">
            My Preferences
        </div>
        <br />
        <p>Choose how job information is delivered; configure your account</p>,<br />
        <div class="btn-group mb-4">
            <a href="/alerts" class="btn btn-common" id="jobalerts">Job
                Alerts</a>

        </div>
    </div> --}}



</body>

</html>
