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
            height: 220px;
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
            max-width: 75%;
            max-height: 100%;
            border-radius: 10px;

            /* Adjusts how the image fits within the container */
        }

        .filters-form {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            align-items: center;
        }

        .text-input,
        .dropdown {
            flex: 1;
            min-width: 220px;
        }

        @media (max-width: 1200px) {
            .filters-form {
                flex-direction: column;
                align-items: stretch;
            }

            .text-input,
            .dropdown,
            .view-btn {
                width: 100%;
                max-width: 400px;
            }
        }

        .scroll-wrapper {
            background-color: #d9d9d9;
            ;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin: 0 10px;
        }

        .categories-container {
            overflow-x: auto;
            scrollbar-width: none;
        }


        .job-grid {
            min-height: 50px;
            height: auto;
        }

        .job-listings-container {
            flex: 3;
            background: #fff;
            padding: 0px 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .job-card {
            padding: 3px 10px;
            font-size: 14px;
            border-bottom: 1px dotted #000;
            cursor: pointer;
            /* Show pointer cursor on hover */
        }

        .main-footer {
            background-color: #18799c;
            color: #fff;
            padding: 4px 20px;
            text-align: center;
            font-size: 14px;
            border-radius: 50px 0 0 0;
        }

        .categories-list {
            display: flex;
            flex-direction: column;
            /* Keep list items vertical */
            overflow-y: auto;
            /* Allow vertical scrolling */
            max-height: calc(40px * 4.5);
            /* Adjust as needed */
            padding: 10px 20px;
            width: 1500px;
            /* Adjust width as needed */
            scroll-behavior: smooth;
            /* Smooth scrolling */

        }
    </style>
</head>

<body>
    @include('home.header')

    <!-- Categories Section -->
    <section class="categories-container">
        <div class="categories-header"
            style="background: linear-gradient(to bottom, #28adce, #18799c);justify-content: flex-end; gap: 15px; min-height:40px; height:auto">

            <a href="{{ route('login') }}" class="category-btn"
                style="text-decoration: none; padding: 6px 6px; border-radius: 5px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); transition: all 0.3s ease;
             background-color: #6bbed4; color: black; font-weight:600"
                onmouseover=" this.style.transform='translateY(-3px)'; this.style.boxShadow='0 12px 24px rgba(0, 0, 0, 0.3)'; this.style.backgroundColor='#6c9dbd';"
                onmouseout=" this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 16px rgba(0, 0, 0, 0.2)'; this.style.backgroundColor='#6bbed4';">
                JOBSEEKER LOGIN
            </a>

            <a href="{{ route('employer.login') }}" class="category-btn"
                style="text-decoration: none; padding: 6px 6px; border-radius: 5px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
             transition: all 0.3s ease;  background-color:  #6bbed4; color: black; font-weight:600"
                onmouseover=" this.style.transform='translateY(-3px)'; this.style.boxShadow='0 12px 24px rgba(0, 0, 0, 0.3)'; this.style.backgroundColor='#6c9dbd';"
                onmouseout=" this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 16px rgba(0, 0, 0, 0.2)'; this.style.backgroundColor=' #6bbed4';">
                EMPLOYER LOGIN
            </a>

            <a href="{{ route('feedback.home') }}" class="category-btn"
                style="text-decoration: none; padding: 6px 6px; border-radius: 5px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); transition: all 0.3s ease;
             background-color:  #6bbed4; color: black; font-weight:600"
                onmouseover=" this.style.transform='translateY(-3px)'; this.style.boxShadow='0 12px 24px rgba(0, 0, 0, 0.3)'; this.style.backgroundColor='#6c9dbd';"
                onmouseout=" this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 16px rgba(0, 0, 0, 0.2)'; this.style.backgroundColor=' #6bbed4';">
                FEEDBACK
            </a>
        </div>
    </section>




    <div class="scroll-wrapper">

        <button class="scroll-btn left-scroll" id="scrollLeft">
            <i class="fa fa-chevron-left"></i>
        </button>


        <div class="categories-list" id="categoriesList"
            style="padding: 10px; border-radius: 15px; display: flex; flex-wrap: wrap; gap: 4px; justify-content: center;">
            @foreach ($categories as $category)
                <a href="javascript:void(0);" data-category-id="{{ $category->id }}"
                    class="category-link {{ session('selected_category_id') == $category->id ? 'active' : '' }}"
                    style="text-decoration: none; background-color: {{ session('selected_category_id') == $category->id ? '#1267e7' : '#f8f9fa' }};
                          color: {{ session('selected_category_id') == $category->id ? 'white' : 'black' }};
                          padding: 4px 15px; border-radius: 5px; min-width:222px; width: auto;
                          font-size: 14px; transition: all 0.3s ease; white-space: nowrap; display: inline-block;">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        <button class="scroll-btn right-scroll" id="scrollRight">
            <i class="fa fa-chevron-right"></i>
        </button>

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
                    <div class="swiper-slide banner-item">
                        {{-- <p>No banners available.</p> --}}
                        <img src="/banner-new.jpg" alt="">

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
    <section class="filters" style="background-color: rgba(0, 0, 0, 0.1); padding:2px 25px">
        <p class="jobtitle">
            Available Jobs: {{ $jobs->count() }} new hot jobs
            @if (session('selected_category_id'))
                @php
                    $selectedCategory = \App\Models\Category::find(session('selected_category_id'));
                @endphp
                in {{ $selectedCategory->name }}
            @endif
        </p>
        <form method="GET" action="{{ route('home') }}" class="filters-form" id="searchForm">
            <!-- Category Filter -->
            <input type="hidden" name="category_id" id="categoryInput"
                value="{{ request('category_id') ?? session('selected_category_id') }}">

            <input class="text-input" style="height:17px" type="text" name="search"
                placeholder="Enter Vacancy Name/Company/Job Reference" value="{{ request('search') }}">

            <input class="text-input" style="height:17px;" type="text" name="location"
                placeholder="Enter your Location" value="{{ request('location') }}">

            <select name="country" class="dropdown" style="height: 43px; color: #777777">
                <option value="">Select Country</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}" {{ request('country') == $country->id ? 'selected' : '' }}>
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>

            <button class="view-btn" type="submit">
                <i class="fa fa-search"></i>
            </button>
        </form>


        <hr>
    </section>





    <!-- Job Listings Section -->
    <!-- Job Listings Section -->
    <section id="job-listings" class="job-listings-container">
        <h3 class="job-listings-title">Available Jobs</h3>

        @if ($jobs->isEmpty())
            <p>No jobs found matching your criteria.</p>
        @else
            @if (request()->has('category_id') && request()->category_id != null)
                <!-- Display as Table if Category is Selected -->
                <div class="table-container">
                    <table class="job-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Reference Number</th>
                                <th>Job Title</th>
                                <th>Description</th>
                                <th>Location</th>
                                <th>Posted Date</th>
                                <th>Closing Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobs as $index => $job)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $job->job_id ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('job.details', $job->id) }}" class="job-title">
                                            {{ $job->title }}
                                        </a>
                                        <br>
                                        <a href="{{ route('job.details', $job->id) }}" class="company-name">
                                            {{ $job->employer->company_name }}
                                        </a>
                                    </td>
                                    <td>{{ $job->description ?? 'No description provided' }}</td>
                                    <td>{{ $job->location ?? 'Not specified' }}</td>
                                    <td>{{ $job->created_at ? $job->created_at->format('Y-m-d') : 'N/A' }}</td>
                                    <td>{{ $job->closing_date ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <!-- Display as Cards if No Category is Selected -->
                <div class="job-grid">
                    @foreach ($jobs as $job)
                        <div class="job-card" style="min-height:50px;height:auto; cursor: pointer;"
                            onclick="window.location='{{ route('job.details', $job->id) }}'">
                            <a href="{{ route('job.details', $job->id) }}" class="job-title"
                                style="font-size:15px; margin-bottom: 0px;">
                                {{ $job->title }}
                            </a>
                            <p class="company-name"
                                style="font-size: 14px; margin-top: 2px; margin-bottom: 0px; font-weight:600; line-height:1;">
                                {{ $job->employer->company_name }}
                            </p>
                            <p class="location"
                                style="font-size: 12px; margin-top: 1px; margin-bottom: 0px; line-height:1;">
                                {{ $job->location }}
                            </p>
                            <p
                                style="font-size: 14px; color:red; margin-top: 3px; margin-bottom: 0px; line-height: 1.2;">
                                {{ $job->closing_date }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif
    </section>






    </main><br /><br /><br /><br />

    @include('home.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categoryLinks = document.querySelectorAll('.category-link');
            const categoryInput = document.getElementById('categoryInput');
            const searchForm = document.getElementById('searchForm');

            // Handle category selection
            categoryLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const categoryId = this.dataset.categoryId;

                    // Update the category input and submit the form
                    categoryInput.value = categoryId;
                    searchForm.submit();
                });
            });

            // Handle clear filter
            document.querySelector('.clear-filter')?.addEventListener('click', function(e) {
                e.preventDefault();
                categoryInput.value = '';
                searchForm.submit();
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const scrollContainer = document.getElementById("categoriesList");
            const scrollLeftBtn = document.getElementById("scrollLeft");
            const scrollRightBtn = document.getElementById("scrollRight");

            function scrollCategories(direction) {
                const categoryCards = document.querySelectorAll(".category-link");
                if (categoryCards.length === 0) return;

                // Get width of a single category card
                const cardWidth = categoryCards[0].offsetWidth + 10; // Including gap

                // Scroll by 6 category cards at a time
                const scrollAmount = cardWidth * 6;

                scrollContainer.scrollBy({
                    left: direction === "right" ? scrollAmount : -scrollAmount,
                    behavior: "smooth"
                });
            }

            scrollLeftBtn.addEventListener("click", function() {
                scrollCategories("left");
            });

            scrollRightBtn.addEventListener("click", function() {
                scrollCategories("right");
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // If the page is reloaded (e.g. via the browser's refresh button)
            if (performance.navigation.type === performance.navigation.TYPE_RELOAD) {
                // Redirect to the home route without query parameters.
                window.location.href = "{{ route('home') }}";
            }

            // Clear filters when clicking a home link (if you have any that should clear the filters)
            document.querySelectorAll('a[href="{{ route('home') }}"]').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    clearFilters();
                });
            });

            function clearFilters() {
                // Clear form inputs (assuming these IDs exist)
                document.getElementById('searchInput').value = '';
                document.getElementById('locationInput').value = '';
                document.getElementById('countrySelect').value = '';
                document.getElementById('categoryInput').value = '';
                // Redirect to the home route without any query parameters.
                window.location.href = "{{ route('home') }}";
            }

            // Handle category selection if you're using clickable category links
            const categoryLinks = document.querySelectorAll('.category-link');
            categoryLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Update the hidden input with the selected category ID
                    document.getElementById('categoryInput').value = this.dataset.categoryId;
                    // Submit the form so that the URL updates accordingly
                    document.getElementById('searchForm').submit();
                });
            });
        });
    </script>



</body>

</html>
