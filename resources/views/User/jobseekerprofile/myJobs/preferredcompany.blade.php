<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preferred Companies</title>

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profileview.css') }}">
    <link rel="stylesheet" href="{{ asset('css/myapplication.css') }}">
   
</head>
<body>
@include('user.jobseekerprofile.mainview.profilelayout')
<div class="jobcontainer">
<div class="jobsection">
            <h2>Preferred Companies</h2>
            <p><a href="#">Add companies to my list...</a></p>
            <p>You do not have any preferred companies.</p>
        </div>
        </div>
</body>
</html>