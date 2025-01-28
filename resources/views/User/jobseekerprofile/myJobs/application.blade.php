<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>myApplication</title>

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profileview.css') }}">
    <link rel="stylesheet" href="{{ asset('css/myapplication.css') }}">

</head>

<body>

    @include('User.jobseekerprofile.mainview.profilelayout')
    <div class="jobcontainer">
        <div class="jobsection">
            <h2>Recent Vacancies</h2>
            <div class="jobfilter">

            </div>

            @if ($applications->isEmpty())
                <p>No applications found.</p>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Job Ref No.</th>
                            <th>Position and Employer</th>
                            <th>Closing Date</th>
                            <th>Apply Date</th>

                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($applications as $index => $application)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $application->job->job_id }}</td>
                                <td>{{ $application->job->title }} <br> {{ $application->job->employer->company_name }}
                                </td>
                                <td>{{ $application->job->closing_date }}</td>
                                <td>{{ $application->created_at->format('Y-m-d') }}</td>

                                <td><a href="{{ route('user.jobseekerprofile.myjobs.view', $application->id) }}">Full
                                        View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

</body>

</html>
