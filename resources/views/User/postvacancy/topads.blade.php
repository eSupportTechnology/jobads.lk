<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Ads Pricing</title>
    <style>


    </style>
</head>

<body>
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
    <table>
        <thead>
            <tr>
                <th>Package Size (Nos Vacancy Posts)</th>
                <th>Days</th>
                <th>LKR Price (VAT Inclusive)</th>
                <th>USD Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($packages as $package)
                <tr>
                    <td>{{ $package->package_size }}</td>
                    <td>{{ $package->duration_days }}</td>
                    <td>{{ number_format($package->lkr_price, 2) }}</td>
                    <td>{{ number_format($package->usd_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>



</body>

</html>
