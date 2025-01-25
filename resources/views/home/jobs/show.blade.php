<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $job->title }} - Job Details</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>


     <!-- Slick Slider CSS -->
     <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css" />

    <!-- jQuery (Required for Slick Slider) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Slick Slider JS -->
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js"></script>
<!-- css-->
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/showpage.css') }}">

   

    <style>
        .advertising-section {
            width: 100%;
            margin-bottom: 20px;
        }

        .advertising-card {
            background: #f9f9f9;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }

        .advertising-card img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .advertising-card img {
    width: 100%; /* Make the image fill the container */
    height: auto; /* Maintain the aspect ratio */
    max-height: 200px; /* Set a maximum height for consistency */
    object-fit: cover; /* Ensure the image fits nicely within the container */
    border-radius: 10px; /* Add rounded corners for a clean look */
    border: 2px solid #ddd; /* Optional border for styling */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add shadow for better depth */
}


    /* Add padding around the advertising card */
    .advertising-card {
        margin-bottom: 20px;
        text-align: center;
    }

    .advertising-section {
            padding: 20px;
        }

        .advertising-card {
            text-align: center;
            margin-bottom: 20px;
        }

        .advertising-card h3 {
            margin-bottom: 10px;
        }

        .advertising-slider img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .slick-prev,
        .slick-next {
            background-color: #000;
            color: #fff;
            border-radius: 50%;
            font-size: 20px;
        }
      
    </style>
</head>

<body>
    @include('home.header')

    <main>
        <div class="layout-container">
            <!-- Advertising Section -->
            <aside class="advertising-section">
    <div class="advertising-card">
       
        <div class="advertising-slider">
            <img src="{{ asset('assets/images/ads.jpg') }}" alt="Ad 1">
            <img src="{{ asset('assets/images/ads.jpg') }}" alt="Ad 2">
            <img src="{{ asset('assets/images/ads.jpg') }}" alt="Ad 3">
        </div>
        
    </div>
</aside>


            <!-- Job Details Section -->
            <div class="showcontainer">
                <div class="job-cardn">
                    <button class="back-button" onclick="window.history.back()">
                        <i class="fas fa-arrow-left"></i>
                    </button>

                    <!-- Header Section -->
                    <div class="header">
                        @if (!empty($job->image))
                            <img src="{{ asset('storage/' . $job->image) }}" alt="Company banner">
                            <div class="overlay"></div>
                        @endif
                    </div>

                    <!-- Content Section -->
                    <div class="content">
                        <!-- Job Title and Company -->
                        <div class="job-title">
                            <h1>{{ $job->title }}</h1>
                            <p class="company-name">{{ $job->employer->company_name }}</p>
                        </div>
                        <p>
                            <i class="fas fa-eye"></i> {{ $job->view_count }} Views
                        </p>

                        <!-- Key Details -->
                        <div class="details">
                            @if (!empty($job->location))
                                <div class="detail">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $job->location }}</span>
                                </div>
                            @endif
                            @if (!empty($job->country))
                                <div class="detail">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $job->country }}</span>
                                </div>
                            @endif
                            @if (!empty($job->created_at))
                                <div class="detail">
                                    <i class="fas fa-calendar"></i>
                                    <span>Posted: {{ $job->created_at->format('M d, Y') }}</span>
                                </div>
                            @endif
                            @if (!empty($job->salary_range))
                                <div class="detail">
                                    <i class="fas fa-money-bill-wave"></i>
                                    <span>Salary: {{ number_format($job->salary_range, 2) }}</span>
                                </div>
                            @endif
                            @if (!empty($job->closing_date))
                                <div class="detail">
                                    <i class="fas fa-hourglass-end"></i>
                                    <span>Closes: {{ $job->closing_date }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Description -->
                        @if (!empty($job->description))
                            <div class="description">
                                <h2>Job Description</h2>
                                <p>{{ $job->description }}</p>
                            </div>
                        @endif

                        <!-- Requirements -->
                        @if (!empty($job->requirements))
                            <div class="requirements">
                                <h2>Requirements</h2>
                                <p>{{ $job->requirements }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Buttons -->
                    <div class="btn-group mb-4">
                        <button class="btn btn-apply" id="apply">Apply Now</button>
                        @auth
                            <button class="flag-btn" title="flag button" data-job-id="{{ $job->id }}">
                                <i class="fa-solid {{ auth()->user()->flaggedJobs->contains($job->id) ? 'fa-flag' : 'fa-regular fa-flag' }}"></i>
                            </button>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Apply Options Content -->
    <div id="componentContainer-apply"></div>

    <!-- Script for Dynamic Component Loading -->
    <script>
        $(document).ready(function() {
            $('#apply').on('click', function() {
                const jobId = '{{ $job->id }}';
                $('#componentContainer-apply').load(`/apply/${jobId}`);
            });

            $(document).on('click', '.flag-btn', function() {
                const jobId = $(this).data('job-id');
                const button = $(this);

                $.ajax({
                    url: `/jobs/${jobId}/flag`,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'flagged') {
                            button.find('i').removeClass('fa-flag-o').addClass('fa-flag');
                        } else {
                            button.find('i').removeClass('fa-flag').addClass('fa-flag-o');
                        }
                        alert(response.message);
                    }
                });
            });
        });
    </script>

<script>
    $(document).ready(function () {
        $('.advertising-slider').slick({
            dots: true,           // Add navigation dots
            infinite: true,       // Enable infinite loop
            speed: 500,           // Transition speed
            slidesToShow: 1,      // Number of slides to show
            slidesToScroll: 1,    // Number of slides to scroll
            autoplay: true,       // Enable autoplay
            autoplaySpeed: 3000,  // Autoplay interval in milliseconds
            arrows: true,         // Show next/prev arrows
        });
    });
</script>

</body>

</html>
