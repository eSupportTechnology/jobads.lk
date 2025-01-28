<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Profile</title>

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/employeeprofile.css') }}">


</head>

<body>
    @include('User.jobseekerprofile.mainview.profilelayout')
    <!--update profile-->
    <div class = "profile-body">
        <div class="profile-container">
            @include('User.jobseekerprofile.updateprofile')

        </div>

    </div>
    <!--update password-->
    @include('User.jobseekerprofile.updatepassword')
    <!--delete account-->
    @include('User.jobseekerprofile.deleteaccount')
</body>

</html>
