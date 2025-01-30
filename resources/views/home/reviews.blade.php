<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reviews.css') }}">

    <style>
        .star-rating {
            font-size: 24px;
            /* Adjust the size of the stars */
            color: #d3d3d3;
            /* Default color for empty stars (grey) */
        }

        .star-rating .filled {
            color: #ffcc00;
            /* Yellow color for filled stars */
        }
    </style>

</head>

<body>
    @include('home.header')

    <div class="feedback-container">
        @foreach ($feedback as $feedbackItem)
            <!-- Loop through each feedback -->
            <div class="feedback-card">
                <div class="quote-date">
                    
                    <p>{{ $feedbackItem->created_at->format('Y-m-d') }}</p> <!-- Display the date -->
                </div>
                <p class="feedback-message"><span class="quote-icon">❝</span>{{ $feedbackItem->message }}<span class="quote-icon">❞</span></p> <!-- Display feedback message -->

                <div class="star-rating">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $feedbackItem->rating)
                            <span class="filled">★</span> <!-- Filled star -->
                        @else
                            <span>☆</span> <!-- Empty star -->
                        @endif
                    @endfor
                </div>

                <div class="profile">
                    <img src="{{ asset('assets/images/dashboard/profile.jpg') }}" alt="User Avatar">
                    <p class="user-info">
                        <span class="name">
                            @if ($feedbackItem->user)
                                {{ $feedbackItem->user->name }}
                            @elseif ($feedbackItem->employer)
                                {{ $feedbackItem->employer->company_name }}
                            @else
                                Anonymous
                            @endif
                        </span><br>

                        <!-- <span class="position">
                            @if ($feedbackItem->user && isset($feedbackItem->user->position))
                                {{ $feedbackItem->user->position }}
                            @endif
                        </span><br>

                        <span class="company">
                            @if ($feedbackItem->user && isset($feedbackItem->user->company))
                                {{ $feedbackItem->user->company }}
                            @elseif ($feedbackItem->employer)
                                {{ $feedbackItem->employer->company_name }}
                            @endif
                        </span> -->
                    </p>
                </div>
            </div>
        @endforeach
    </div>

</body>

</html>
