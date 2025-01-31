<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Posting Platform</title>

    <link rel="stylesheet" href="{{ asset('css/postjob.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bannerposting.css') }}">
    <link rel="stylesheet" href="{{ asset('css/topads.css') }}">
<style>

</style>
</head>
    <body>
    @include('home.header')
    <div class="postcontainer">
        <div class="postheader">
            jobads is the best way to post jobs and recruit talent from Sri Lanka. Choose from any of the following
            options.
        </div>
        @foreach ($posts as $post)
            <div class="postcontent">
                <ul>

                    {!! $post->description_one !!}

                </ul>
            </div>
        @endforeach
    </div><br />

    <!-- Buttons to Load Components -->
    <div class="btn-group mb-4">
        <button class="btn btn-top-ads" id="topAdsButton">Top Ads</button>
        <button class="btn btn-banner-posting" id="bannerPostingButton">Banner Posting</button>
    </div>

    <!-- Component Content Section -->
    <div id="componentContainer" style="padding: 0px 0px 0px 20px">

    <div class="unique-container">
        <!-- Top Ads Content -->
        <div class="topads-container">
            <div class="topads-header">
                Top Ads Pricing Details
            </div>
            @foreach ($posts as $post)
                <div class="topads-content">
                    <ul>

                        {!! $post->description_two !!}

                    </ul>
                </div>
            @endforeach
        </div>

        <!-- Contact Information Section -->
        <div class ="contact-container" style="margin-top:70px;">
            @foreach ($posts as $post)
                <div class="contact-info">
                    <div class="contact-header">
                        Send the vacancy to: Email / Call
                    </div>
                    <p>Email: <a href="{{ $post->email }}">{{ $post->email }}</a></p>
                    <p>Phone: {{ $post->contact }}</p>
                    @foreach ($contactsLists as $contactList)
                        <ul>
                            <li><strong>{{ $contactList->name }}:</strong> {{ $contactList->phone }}</li>
                        </ul>
                    @endforeach



                    <p><strong>International:</strong> Prefix the number with '+94' e.g. <strong>+94 76 910
                            8691</strong>
                    </p>

                </div>
            @endforeach
        </div>

        <!--how to post your vacancy-->
        <div class ="post-container">
            <div class="post-info">
                <div class="post-header">
                    How To Post Your Vacancy
                </div>
                <p>Email confirmations will be sent on job opening and prior to job closing with statistics on how many
                    jobseekers have seen your vacancy.</p>

            </div>
        </div>
        <!--Payment method-->
        <div class ="post-container">
            <div class="payment-info">
                <div class="payment-header">
                    Payment Methods
                </div>
                <p>We accept cash/cheque deposits, bank transfer, credit card payment (visa/mastercard) and other
                    convenient methods</p>

            </div>
        </div>

        <div class="table-container">
    <table style="width: 80%;">
        <thead>
            <tr style="background-color: #f4f4f4; color: #333;">
                <th style="">Package Size (Nos Vacancy Posts)</th>
                <th style="">Days</th>
                <th style="">LKR Price (VAT Inclusive)</th>
                <th style="">USD Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($packages as $package)
                <tr style="border: 1px solid #ddd;">
                    <td style="">{{ $package->package_size }}</td>
                    <td style="">{{ $package->duration_days }}</td>
                    <td style="">{{ number_format($package->lkr_price, 2) }}</td>
                    <td style="">{{ number_format($package->usd_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<br />

    </div>
    <br />

    <!-- Payment method buttons (ALWAYS VISIBLE) -->
    <div class="payment-methods">
        <div class="btn-group mb-4">
            <button class="btn btn-ipg" id="IPG">IPG</button>
            <button class="btn btn-onlinefund" id="onlinefundtransfer">Online Fund Transfer</button>
            <button class="btn btn-overthecounter" id="Overthecounter">Over-the-Counter</button>
            <button class="btn btn-QRCodeforjobads" id="QRCodeforjobads">QR Code for Job Ads</button>
        </div>
    </div>

    <br />
    <!-- Payment Options Content -->
    <div id="componentContainer-payment">
        @include('User.postvacancy.paymentmethod.ipg')
    </div>

    <!-- Script for Dynamic Component Loading -->
    <script>
        $(document).ready(function() {
            // Load Top Ads Component
            $('#topAdsButton').on('click', function() {
                $('#componentContainer').load('{{ route('user.postvacancy.topads') }}');
                location.reload();
            });

            // Load Banner Posting Component
            $('#bannerPostingButton').on('click', function() {
                $('#componentContainer').load('{{ route('user.postvacancy.bannerposting') }}');

            });

            // Payment Methods
            $('#IPG').on('click', function() {
                $('#componentContainer-payment').load('{{ route('user.postvacancy.paymentmethod.ipg') }}');
            });

            $('#onlinefundtransfer').on('click', function() {
                $('#componentContainer-payment').load(
                    '{{ route('user.postvacancy.paymentmethod.onlinefundtransfer') }}');
            });

            $('#Overthecounter').on('click', function() {
                $('#componentContainer-payment').load(
                    '{{ route('user.postvacancy.paymentmethod.overthecounter') }}');
            });

            $('#QRCodeforjobads').on('click', function() {
                $('#componentContainer-payment').load(
                    '{{ route('user.postvacancy.paymentmethod.qrcodeforjobads') }}');
            });
        });
    </script>


</body>

</html>
