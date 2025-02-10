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

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/showpage.css') }}">




    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7fafc;

        }

        main {
            max-width: 900px;
            margin: 0 auto;
            padding-top: 20px;
            margin-left: 500px;
        }



        .job-cardn {
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .job-cardn .header {
            position: relative;
        }

        .job-cardn .header img {
            width: 100%;
            height: auto;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .job-cardn .header img:hover {
            transform: scale(1.05);
        }

        .job-cardn .header .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.5));
        }

        .job-cardn .content {
            padding: 30px;
        }

        .job-cardn .content h1 {
            font-size: 30px;
            font-weight: bold;
            color: #1a202c;
            margin-bottom: 10px;
        }

        .job-cardn .content p.company-name {
            font-size: 18px;
            color: #718096;
        }

        .job-cardn .details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 40px;
        }

        .job-cardn .details .detail {
            display: flex;
            align-items: center;
            color: #4a5568;
        }

        .job-cardn .details .detail i {
            margin-right: 8px;
            color: #3182ce;
        }

        .job-cardn .description,
        .job-cardn .requirements {
            margin-bottom: 40px;
        }

        .job-cardn .description h2,
        .job-cardn .requirements h2 {
            font-size: 22px;
            font-weight: bold;
            color: #1a202c;
            margin-bottom: 15px;
        }

        .job-cardn .description p,
        .job-cardn .requirements p {
            color: #4a5568;
            line-height: 1.8;
        }

        .job-cardn .apply-button {
            text-align: center;
        }

        .job-cardn .apply-button a {
            display: inline-block;
            padding: 15px 30px;
            background-color: #3182ce;
            color: white;
            font-weight: bold;
            border-radius: 10px;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .job-cardn .apply-button a:hover {
            background-color: #2b6cb0;
            transform: translateY(-4px);
        }

        .job-cardn .apply-button a i {
            margin-right: 10px;
        }

        /* Button Styling */

        .back-button {
            position: relative;
            background-color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            z-index: 999;
            color: white;
            background-color: blue;
        }

        .back-button i {
            color: #4a5568;
            font-size: 1.2rem;
        }

        .back-button:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            background-color: white;
            color: blue;
        }

        .back-button:active {
            transform: scale(0.95);

        }

        .btn-apply {
            background-color: #007bff;
            color: white;
            font-size: 1.2rem;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            margin-left: 40px;
        }

        /* Hover Effect */
        .btn-apply:hover {
            background-color: #0056b3;
            transform: scale(1.05);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        /* Active/Pressed Effect */
        .btn-apply:active {
            transform: scale(0.95);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Animation */
        @keyframes button-bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        #apply {
            animation: button-bounce 1s infinite alternate;
        }


        .btn-flag {
            background-color: #e53e3e;
            color: white;
            font-size: 1.2rem;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-left: 10px;
            margin-top: -150px;
            /* Add space above */
        }

        .btn-back {
            background-color: #4a5568;
            /* Gray color */
            color: white;
            font-size: 1rem;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: -150px;
            /* Add space above */
        }

        .btn-back:hover {
            background-color: #2d3748;
            /* Darker gray */
            transform: scale(1.05);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        .btn-back:active {
            transform: scale(0.95);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .backbutton {
            text-align: center;
            /* Center the button */
            margin-left: 650px;
            margin-bottom: -70px;

        }

        .btn-flag {
            background-color: #e53e3e;
            color: white;
            font-size: 1.2rem;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-left: 10px;
            margin-top: -150px;
            /* Add space above */
        }

        .btn-back {
            background-color: #4a5568;
            /* Gray color */
            color: white;
            font-size: 1rem;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: -150px;
            /* Add space above */
        }

        .btn-back:hover {
            background-color: #2d3748;
            /* Darker gray */
            transform: scale(1.05);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        .btn-back:active {
            transform: scale(0.95);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .backbutton {
            text-align: center;
            /* Center the button */
            margin-left: 700px;
            margin-bottom: 20px;

        }

        /* Flag Button Styles */
        .flag-btn {
            background-color: #007bff;
            /* Transparent background */
            border: none;
            /* Removes default button border */
            cursor: pointer;
            /* Changes cursor to pointer for interactivity */
            padding: 5px;
            /* Adds slight padding for clickability */
            transition: transform 0.2s ease-in-out, color 0.3s ease;
            /* Smooth hover and click effects */
            width: 60px;
            height: 35px;
            border-radius: 5px;
            margin-left: 600px;
        }

        /* Flag Button Hover Effect */
        .flag-btn:hover {
            transform: scale(1.1);
            /* Slight scaling on hover */
            color: white;
        }

        /* Icon Styles */
        .flag-btn i {
            font-size: 100px;
            /* Adjusts the icon size */
            color: rgb(255, 0, 0);
            /* Default icon color */
            transition: color 0.3s ease;
            /* Smooth color change */

        }

        /* Active Flag Icon Color */
        .flag-btn i.fa-flag {
            color: #ff4747;
            /* Red for flagged items */
        }

        /* Hover Effect for Unflagged Icons */
        .flag-btn i.fa-regular.fa-flag:hover {
            color: #007bff;
            /* Blue on hover for unflagged items */
        }

        .fas.fa-eye {
            margin-right: 5px;
            color: #555;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            main {
                max-width: 100%;
                margin: 0 10px;
                padding-top: 15px;
            }

            .job-cardn .content {
                padding: 20px;
            }

            .job-cardn .details {
                grid-template-columns: 1fr;
                /* Single-column layout for small screens */
                gap: 15px;
            }

            .btn-apply,
            .btn-back,
            .btn-flag {
                font-size: 1rem;
                /* Adjust font size */
                padding: 8px 16px;
                /* Adjust padding */
                margin-left: 0;
                /* Reset margins */
                width: 100%;
                /* Full width buttons */
                box-sizing: border-box;
            }

            .backbutton {
                margin-left: auto;
                margin-right: auto;
            }

            .flag-btn {
                margin-left: auto;
                margin-right: auto;
                display: block;
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .job-cardn .content h1 {
                font-size: 24px;
                /* Smaller headings */
            }

            .job-cardn .details {
                gap: 10px;
            }

            .back-button {
                width: 35px;
                height: 35px;
            }

            .btn-apply {
                font-size: 0.9rem;
                padding: 8px 12px;
            }
        }

        /* Additional styles for very small screens (e.g., phones) */
        @media (max-width: 360px) {
            .job-cardn .content {
                padding: 15px;
            }

            .btn-apply,
            .btn-back,
            .btn-flag {
                font-size: 0.8rem;
                padding: 6px 10px;
            }

            .flag-btn {
                padding: 5px;
            }
        }

        /* .advertising-section {
            flex: 1;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-left: 00px;



        } */

        .advertising-card {
            margin-bottom: 20px;
            text-align: center;
            width: 300px;
        }

        .advertising-card img {

            border-radius: 8px;
            margin-bottom: 10px;
        }

        .advertising-card h3 {
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
        }

        .advertising-card p {
            color: #555;
            font-size: 14px;
        }


        .layout-container {
            display: flex;
            gap: 20px;
            max-width: 1500px;
            margin: 0 auto;
            padding: 20px;
            margin-left: -400px;
        }

        .layout-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .advertising-section {
            width: 20%;
            height: 500px;
            padding: 20px;
            order: 2;
            /* Ensures it moves to the right */
        }

        .showcontainer {
            width: 90%;
        }

        .advertising-card img {
            width: 260px;
            height: 480px;
            border-radius: 5px;
            margin-bottom: 10px;
            margin-left: -50px;
            margin-top: 10px;
        }



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

        /* Mobile Responsive Styles */
        @media screen and (max-width: 1024px) {
            .layout-container {
                flex-direction: column;
                /* Stack elements vertically */
                align-items: center;
                gap: 15px;
            }

            .showcontainer {
                width: 100%;
            }

            .advertising-section {
                width: 100%;
                height: auto;
                order: 1;
                /* Move above the main content */
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .advertising-card {
                width: 90%;
                max-width: 300px;
                /* Limit max width for better appearance */
                height: auto;
            }

            .advertising-card img {
                max-height: 300px;
                /* Adjust for smaller screens */
            }
        }

        @media screen and (max-width: 600px) {
            .layout-container {
                padding: 10px;
            }

            .advertising-section {
                padding: 10px;
            }

            .advertising-card {
                width: 100%;
                max-width: 250px;
            }

            .advertising-card img {
                max-height: 250px;
            }
        }
    </style>
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    <style>
        .advertising-section {
            position: fixed;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1000;
            /* Ensure it's above other content */
            width: 210px;
            /* You can adjust this based on the size of the banner */
        }

        /* Style the container of the ads */
        .ads-container {
            overflow: hidden;
            width: 100%;
            position: fixed;
        }

        /* Style the swiper container to ensure proper layout */
        .swiper-container.ads-banner {
            width: 100%;
            height: auto;
            /* Ensures the height adjusts based on content */
        }

        /* Adjust the image to fit without distortion */
        .swiper-slide.banner-item img {
            width: 100%;
            /* Make sure it fits the container width */
            height: auto;
            /* Maintain aspect ratio (height will adjust automatically) */
            max-height: 100%;
            /* Ensure the image doesn't exceed container height */
            object-fit: contain;
            /* Preserve the image's aspect ratio without cropping */
        }

        /* Adjust the text if no banners are available */
        .swiper-slide p {
            text-align: center;
            font-size: 16px;
            color: #777;
            padding: 20px;
        }
    </style>
</head>

<body>
    @include('home.header')

    <main>
        <div class="layout-container">
            <!-- Advertising Section -->
            <aside class="advertising-section">


                <div class="ads-container">
                    <div class="swiper-container ads-banner">
                        <div class="swiper-wrapper">
                            @forelse ($banners as $banner)
                            <div class="swiper-slide banner-item">
                                <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}">
                            </div>
                            @empty
                            <div class="swiper-slide">
                                <p>No banners available.</p>
                            </div>
                            @endforelse
                        </div>
                        <!-- Add navigation buttons if needed -->
                        <!-- <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div> -->
                        <!-- Add pagination if needed -->
                        <!-- <div class="swiper-pagination"></div> -->
                    </div>
                </div>
            </aside>


            <!-- Job Details Section -->
            <div class="showcontainer">
                <div class="job-cardn">

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
                                <i class="fas fa-map-marker-alt"></i>&nbsp;&nbsp;
                                <span>{{ $job->location }}</span>
                            </div>
                            @endif
                            @if (!empty($job->country))
                            <div class="detail">
                                <i class="fas fa-map-marker-alt"></i>&nbsp;&nbsp;
                                <span>{{ $job->country->name }}</span>
                            </div>
                            @endif
                            @if (!empty($job->created_at))
                            <div class="detail">
                                <i class="fas fa-calendar"></i>&nbsp;&nbsp;
                                <span>Posted: {{ $job->created_at->format('M d, Y') }}</span>
                            </div>
                            @endif
                            @if (!empty($job->salary_range))
                            <div class="detail">
                                <i class="fas fa-money-bill-wave"></i>&nbsp;&nbsp;
                                <span>Salary: {{ number_format($job->salary_range, 2) }}</span>
                            </div>
                            @endif
                            @if (!empty($job->closing_date))
                            <div class="detail">
                                <i class="fas fa-hourglass-end"></i>&nbsp;&nbsp;
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
        $(document).ready(function() {
            $('.advertising-slider').slick({
                dots: true, // Add navigation dots
                infinite: true, // Enable infinite loop
                speed: 500, // Transition speed
                slidesToShow: 1, // Number of slides to show
                slidesToScroll: 1, // Number of slides to scroll
                autoplay: true, // Enable autoplay
                autoplaySpeed: 3000, // Autoplay interval in milliseconds
                arrows: true, // Show next/prev arrows
            });
        });
    </script>
    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new Swiper('.swiper-container', {
                loop: true, // Enable infinite looping
                autoplay: {
                    delay: 5000, // 3 seconds delay
                    disableOnInteraction: false, // Continue autoplay after user interaction
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        });
    </script>
</body>

</html>