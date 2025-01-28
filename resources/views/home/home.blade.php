<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">



    <style>
        .dropdown {
            padding: 8px;
            margin: 10px 0;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .ads-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .swiper-container {
            width: 100%;
            height: 150px;
            overflow: hidden;
            /* Ensure no overflow for large images */
        }

        .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            /* Ensure the slide takes full height */
        }

        .banner-item img {
            max-width: 100%;
            max-height: 100%;
            border-radius: 10px;
            object-fit: contain;
            /* Adjusts how the image fits within the container */
        }
    </style>
</head>

<body>
    @include('home.header')

    <!-- Categories Section -->
    <section class="categories-container">
        <div class="categories-header">
            <a href="/login" class="jobseeker-btn">JOBSEEKER LOGIN</a>
            {{-- <a href="{{ route('feedback.home') }}" class=" feedback-btn2">Feedback</a> --}}
            <a href="{{ route('employer.login') }}" class=" employer-btn">EMPLOYER LOGIN</a>

        </div>
        <div class="scroll-wrapper">
            <button class="scroll-btn left-scroll" id="scrollLeft">
                < </button>
                    <div class="categories-list" id="categoriesList">
                        @foreach ($categories as $category)
                            <a href="javascript:void(0);" data-category-id="{{ $category->id }}" class="category-link">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                    <button class="scroll-btn right-scroll" id="scrollRight">></button>
        </div>
    </section>
    <!-- <div class="ads-banner">
        <img src="{{ asset('assets/images/ads.jpg') }}" alt="">
    </div> -->
    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

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



    <!-- Filters Section -->
    <section class="filters">
        <p class="jobtitle">
            Available Jobs: {{ $jobs->count() }} new hot jobs
        </p>
        <form method="GET" action="{{ route('home') }}">
            <input class="text-input" type="text" name="search"
                placeholder="Enter Vacancy Name/Company/Job Reference" value="{{ request('search') }}">
            <input class="text-input" type="text" name="location" placeholder="Enter your Location"
                value="{{ request('location') }}">

            <select name="country" class="dropdown">
                <option value="">Select Country</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->country }}"
                        {{ request('country') == $country->country ? 'selected' : '' }}>
                        {{ $country->country }}
                    </option>
                @endforeach
            </select>


            <button class="view-btn" type="submit">
                <i class="fa fa-search"></i> <!-- This is the search icon -->

            </button>
        </form>
        <hr>
    </section>



    <!-- Job Listings Section -->
    <section id="job-listings" class="job-listings-container">
        <h3 class="job-listings-title">Available Jobs</h3>
        <div class="job-grid">
            @if ($jobs->isEmpty())
                <p>No jobs found matching your criteria.</p>
            @else
                @foreach ($jobs as $job)
                    <div class="job-card">

                        <a href="{{ route('job.details', $job->id) }}" class="job-title">
                            {{ $job->title }}
                        </a>
                        <p><strong class="company-name">{{ $job->employer->company_name }}</strong></p>
                        <p class="location">{{ $job->location }}</p>
                        <p class="closing-date">{{ $job->closing_date }}</p>
                    </div>
                @endforeach
            @endif
        </div>

    </section>




    </main><br /><br /><br /><br />

    @include('home.footer')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categoryLinks = document.querySelectorAll('.category-link');
            const categoryIdInput = document.getElementById('selected-category-id');

            categoryLinks.forEach(link => {
                link.addEventListener('click', function() {
                    const categoryId = this.getAttribute('data-category-id');
                    categoryIdInput.value = categoryId;
                    document.querySelector('form').submit();
                });
            });
        });
    </script>
    <script>
        $(document).on('click', '.flag-btn', function() {
            let jobId = $(this).data('job-id');
            let button = $(this);

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
    </script>
    <script>
        document.getElementById('scrollLeft').addEventListener('click', function() {
            document.getElementById('categoriesList').scrollBy({
                left: -100,
                behavior: 'smooth'
            });
        });

        document.getElementById('scrollRight').addEventListener('click', function() {
            document.getElementById('categoriesList').scrollBy({
                left: 100,
                behavior: 'smooth'
            });
        });
    </script>



    <!-- <script>
        let currentAd = 0;
        const ads = document.querySelectorAll('.ads-banner img'); // Select all ad images
        const totalAds = ads.length;

        // Function to change the displayed ad
        function showNextAd() {
            // Hide the current ad
            ads[currentAd].style.opacity = 0;

            // Move to the next ad
            currentAd = (currentAd + 1) % totalAds; // Loop back to the first ad

            // Show the new ad
            ads[currentAd].style.opacity = 1;
        }

        // Change the ad every 10 seconds
        setInterval(showNextAd, 10000); // 10000 ms = 10 seconds
    </script> -->

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
