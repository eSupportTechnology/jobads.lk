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
    <style>
        .cvbutton {
            width: 260px;
            text-align: center;
            position: relative;
            cursor: pointer;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            width: 260px;
            background: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            border: 1px solid #ddd;
            border-radius: 4px;
            z-index: 1000;
            margin-top: 2px;
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-item {
            display: block;
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            text-align: center;
        }

        .dropdown-item:hover {
            background-color: #f5f5f5;
        }

        .dropdown-toggle::after {
            content: '';
            display: inline-block;
            width: 0;
            height: 0;
            margin-left: 8px;
            vertical-align: middle;
            border-top: 5px solid;
            border-right: 5px solid transparent;
            border-left: 5px solid transparent;
        }
    </style>
</head>

<body>
    @include('home.header')
    <h1 class="maintopic"></h1><br />

    <div class="profileview-container">
        <div class="profileview-header">
            Profile View
        </div>
        <br />
        <p>Manage your CV, photograph, certificates, online profile. featured employers, View/Edit your login details.
        </p><br />
        <div class="btn-group mb-4">
            <a href="{{ route('profile.edit') }}" class="btn btn-common" id="commonprofile">Common Profile</a>
            <a href="{{ route('profile.personal') }}" class="btn btn-common" id="personalprofile">Update Profile</a>
            <a href="{{ route('user.jobseekerprofile.education') }}" class="btn btn-common" id="education">Education</a>
            <a href="{{ route('experience.show') }}" class="btn btn-common" id="expirience">Experience</a>
        </div>
    </div>
    <br />

    <div class="profileview-container">
        <div class="profileview-header">
            My Jobs
        </div>
        <br />
        <p>Manage your CV, photograph, certificates, online profile. featured employers, View/Edit your login details.
        </p><br />
        <div class="btn-group mb-4 ">
            <a href="{{ route('user.jobseekerprofile.myjobs.application') }}" class="btn btn-common"
                id="myapplication">My Applications</a>
            <a href="{{ route('user.flagged_jobs') }}" class="btn btn-common" id="flagged">Flagged Jobs</a>
            <div class="dropdown" style="margin-top: 5px">
                <a class="btn btn-common dropdown-toggle cvbutton" id="preferred">
                    Create CV
                </a>
                <ul class="dropdown-menu" aria-labelledby="preferred">
                    <li><a class="dropdown-item" href="{{ route('generate.index') }}">Template 1</a></li>
                    <li><a class="dropdown-item" href="{{ route('generate.index2') }}">Template 2</a></li>
                    <li><a class="dropdown-item" href="{{ route('generate.index3') }}">Template 3</a></li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        // Custom dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownToggle = document.querySelector('.dropdown-toggle');
            const dropdownMenu = document.querySelector('.dropdown-menu');

            // Toggle dropdown on click
            dropdownToggle.addEventListener('click', function(e) {
                e.preventDefault();
                dropdownMenu.classList.toggle('show');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.matches('.dropdown-toggle') && !e.target.closest('.dropdown-menu')) {
                    dropdownMenu.classList.remove('show');
                }
            });
        });
    </script>
</body>

</html>
