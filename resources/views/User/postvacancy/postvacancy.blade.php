<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Posting Platform</title>

    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .container {
            display: grid;
            gap: 20px;
            padding: 20px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .postcontainer {
            border: 1px solid #409cf1;
            border-radius: 5px;
            background-color: #ffffff;
            padding: 15px;
        }

        .postheader {
            background-color: #e0f0ff;
            color: #000;
            font-weight: bold;
            padding: 10px 15px;
            font-size: 1.1em;
            border-radius: 5px 5px 0 0;
        }

        .postcontent {
            padding: 15px;
        }

        .grid-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .contact-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f9f9f9;
        }

        .contact-table th,
        .contact-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .contact-table th {
            font-weight: bold;
        }

        .contact-table .emailth,
        .email,
        .tfooter {
            background-color: #ffe599;
        }

        .contact-table .tfooter {
            color: blue;
        }

        .email {
            font-style: italic;
            color: red;
            font-weight: bold;
        }

        .rate-table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        .rate-table th,
        .rate-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .rate-table th {
            background-color: #ffe599;
            font-weight: bold;
        }

        .rate-table .package {
            background-color: #C00000;
            color: white;
            font-weight: bold;
        }

        .rate-table .lkrprice {
            background-color: rgb(162, 185, 226);
        }

        .rate-table .usdprice {
            background-color: rgb(150, 148, 148);
        }

        .rate-table .pricetitle {
            color: white;
        }

        .payment-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .payment-table th,
        .payment-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .payment-header {
            background-color: #C00000;
            color: white;
            text-align: center;
            font-weight: bold;
            padding: 10px;
        }

        .payment-table .title1 {
            background-color: #C00000;
            color: white;
        }

        .payment-table .bgcolor {
            background-color: rgb(150, 198, 238);
        }

        .section-button {
            padding: 10px 20px;
            margin-right: 10px;
            background-color: #409cf1;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;

        }

        .section-button:hover {
            background-color: #357ab7;
        }

        .btn-section {
            display: flex;
            justify-content: center;
            margin-top: 20px;


        }

        .active-button {
            background-color: darkblue !important;
            color: white;
        }
    </style>
</head>

<body>
    @include('home.header')

    <!-- Section buttons -->
    <div class="btn-section">
        <button class="section-button active-button" id="job-button">Job Ads</button>
        <button class="section-button" id="banner-button">Banners</button>
    </div>

    <!-- job section -->

    <div id="job-section" class="container">
        <!-- First Row -->
        @if(!empty($packageDetails->description_one))
        <div class="grid-row">
            <div class="postcontainer">
                <div class="postheader">
                    jobads.lk is the most trusted and effective way to advertise your vacancy and recruit talent from Sri Lanka.
                    Select any of the following options.
                </div>
                <div class="postcontent">
                    {!! $packageDetails->description_one !!}
                </div>
            </div>
        </div>
        @endif

        <!-- Second Row -->
        <div class="grid-row">
            @if(!empty($contactsList) && count($contactsList) > 0)
            <div class="postcontainer">
                <div class="postheader">
                    Send your Job vacancy to - E-Mail/Call/WhatsApp
                </div>
                <div class="postcontent">
                    <table class="contact-table">
                        <tr>
                            <th class="emailth">Email:</th>
                            <td class="email">{{$packageDetails->email}}</td>
                        </tr>
                        <tr>
                            <th rowspan="{{ count($contactsList) + 1 }}">Call or WhatsApp</th>
                        </tr>
                        @foreach($contactsList as $contact)
                        <tr>
                            <td>{{ $contact->name }} : {{ $contact->phone }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="2" class="tfooter">
                                <strong>For International:</strong> Prefix the number with '+94' e.g., +94 77 99 540 63
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="postcontent">
                    {!!$packageDetails->description_two!!}
                </div>
            </div>
            @endif
            @if($packages->isNotEmpty())
            <div class="postcontainer">
                <div class="postheader">
                    Rate Card for Vacancy Advertising : effective from {{$packageDetails->effective_date}}
                </div>
                <div class="postcontent">
                    <table class="rate-table">
                        <tr>
                            <th class="package">Package size (No of Job Vacancy Posts)</th>
                            @php
                                $duration1 = $durations->firstWhere('id', 1); // Get duration where id = 1
                                $duration2 = $durations->firstWhere('id', 2); // Get duration where id = 2
                            @endphp

                            <th class="package" colspan="2">
                                {{ $duration1 ? $duration1->duration : '0' }} Days
                            </th>
                            <th class="package" colspan="2">
                                {{ $duration2 ? $duration2->duration : '0' }} Days
                            </th>
                        </tr>
                        <tr>
                            <th class="package"></th>
                            <th class="lkrprice pricetitle">Per ads LKR Price</th>
                            <th class="usdprice pricetitle">Per ads USD Price</th>
                            <th class="lkrprice pricetitle">Per ads LKR Price</th>
                            <th class="usdprice pricetitle">Per ads USD Price</th>
                        </tr>

                        @php
                        $groupedPackages = $packages->groupBy('package_size');
                        @endphp

                        @foreach($groupedPackages as $packageSize => $packageGroup)
                        <tr>
                            <td class="package">{{ $packageSize }}</td>
                            @php
                            $twentyDays = $packageGroup->firstWhere('duration_id', 1);
                            $thirtyDays = $packageGroup->firstWhere('duration_id', 2);
                            @endphp
                            <td class="lkrprice">{{ isset($twentyDays->lkr_price) ? intval($twentyDays->lkr_price) : 'N/A' }}</td>
                            <td class="usdprice">{{ isset($twentyDays->usd_price) ? intval($twentyDays->usd_price) : 'N/A' }}</td>
                            <td class="lkrprice">{{ isset($thirtyDays->lkr_price) ? intval($thirtyDays->lkr_price) : 'N/A' }}</td>
                            <td class="usdprice">{{ isset($thirtyDays->usd_price) ? intval($thirtyDays->usd_price) : 'N/A' }}</td>

                        </tr>
                        @endforeach

                        <tr>
                            <td class="package">11 or above per month:</td>
                            <td class="lkrprice" colspan="4">
                                1. Email OR<br />
                                2. Request a special quotation
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
            @endif
        </div>

        <!-- Third Row -->
        @if(!empty($packageDetails->description_three))
        <div class="grid-row">
            <div class="postcontainer">
                <div class="postheader">
                    Method of Advertising Your Job Vacancy:
                </div>
                <div class="postcontent">
                    {!!$packageDetails->description_three!!}
                </div>
            </div>
        </div>
        @endif

        <!-- fourth Row -->
        <div class="grid-row">
            @if($localBanks->isNotEmpty())
            <div class="postcontainer">
                <div class="postheader">
                    Local Payments:
                </div>
                <div class="postcontent">
                    <div class="payment-header">
                        Online Fund Transfers or Direct Deposits
                    </div>
                    <table class="payment-table">
                        <tr>
                            <th class="title1">LOCAL LKR Payments</th>
                            @foreach ($localBanks as $lb)
                            <th colspan="2" style="text-align:center;">
                                @if ($lb->logo)
                                <img src="{{ asset('storage/' . $lb->logo) }}" style="height:50px; width:100px;"
                                    alt="{{ $lb->bank_name }} Logo" class="logo-thumbnail">
                                @else
                                <span class="text-muted"><strong>{{$lb->bank_name}}</strong></span>
                                @endif
                            </th>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>Bank Name</strong></td>
                            @foreach ($localBanks as $lb)
                            <td class="bgcolor" colspan="2"><strong>{{$lb->bank_name}}</strong></td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>Account Name</strong></td>
                            @foreach ($localBanks as $lb)
                            <td class="bgcolor" colspan="2">{{$lb->account_name}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>Account No</strong></td>
                            @foreach ($localBanks as $lb)
                            <td class="bgcolor" colspan="2">{{$lb->account_no}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>Bank Code</strong></td>
                            @foreach ($localBanks as $lb)
                            <td class="bgcolor" colspan="2">{{$lb->bank_code}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>Branch</strong></td>
                            @foreach ($localBanks as $lb)
                            <td class="bgcolor" colspan="2">{{$lb->branch_name}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>Branch Code</strong></td>
                            @foreach ($localBanks as $lb)
                            <td class="bgcolor" colspan="2">{{$lb->branch_name}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>SWIFT Code</strong></td>
                            @foreach ($localBanks as $lb)
                            <td class="bgcolor" colspan="2">{{$lb->swift_code}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>Currency</strong></td>
                            @foreach ($localBanks as $lb)
                            <td class="bgcolor" colspan="2">{{$lb->currency}}</td>
                            @endforeach
                        </tr>
                    </table>
                </div>
            </div>
            @endif

            @if($foreignBanks->isNotEmpty())
            <div class="postcontainer">
                <div class="postheader">
                    Foreign Payments:
                </div>
                <div class="postcontent">
                    <div class="payment-header">
                        Online Fund Transfers or Direct Deposits
                    </div>
                    <table class="payment-table">
                        <tr>
                            <th class="title1">FOREIGN USD Payments</th>
                            @foreach ($foreignBanks as $fb)
                            <th colspan="2" style="text-align:center;">
                                @if ($fb->logo)
                                <img src="{{ asset('storage/' . $fb->logo) }}" style="height:50px; width:100px;"
                                    alt="{{ $fb->bank_name }} Logo" class="logo-thumbnail">
                                @else
                                <span class="text-muted"><strong>{{$fb->bank_name}}</strong></span>
                                @endif
                            </th>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>Bank Name</strong></td>
                            @foreach ($foreignBanks as $fb)
                            <td class="bgcolor" colspan="2"><strong>{{$fb->bank_name}}</strong></td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>Account Name</strong></td>
                            @foreach ($foreignBanks as $fb)
                            <td class="bgcolor" colspan="2">{{$fb->account_name}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>Account No</strong></td>
                            @foreach ($foreignBanks as $fb)
                            <td class="bgcolor" colspan="2">{{$fb->account_no}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>Bank Code</strong></td>
                            @foreach ($foreignBanks as $fb)
                            <td class="bgcolor" colspan="2">{{$fb->bank_code}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>Branch</strong></td>
                            @foreach ($foreignBanks as $fb)
                            <td class="bgcolor" colspan="2">{{$fb->branch_name}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>Branch Code</strong></td>
                            @foreach ($foreignBanks as $fb)
                            <td class="bgcolor" colspan="2">{{$fb->branch_name}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>SWIFT Code</strong></td>
                            @foreach ($foreignBanks as $fb)
                            <td class="bgcolor" colspan="2">{{$fb->swift_code}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>Currency</strong></td>
                            @foreach ($foreignBanks as $fb)
                            <td class="bgcolor" colspan="2">{{$fb->currency}}</td>
                            @endforeach
                        </tr>
                    </table>
                </div>
            </div>
            @endif
        </div>

        <!-- fifth Row -->
        <div class="grid-row">
            <div class="postcontainer">
                <div class="postcontent" style="background-color:orange;">
                    <span style="color:red; font-weight:bold">Note:</span>
                    <p>Once the payment is made, Please send the scanned copy/photo of the deposited slip via email or to WhatsApp number above.</p>
                    <p>For payments using fund transfer, You can send the screenshot of the receipt.</p>
                </div>
            </div>
        </div>

    </div>





    <!-- banner section -->

    <div id="banner-section" class="container">
        <!-- First Row -->
        @if(!empty($packageDetailsBanners->description_one))
        <div class="grid-row">
            <div class="postcontainer">
                <div class="postheader">
                    www.jobads.lk Web Site Banner Advertising
                </div>
                <div class="postcontent">
                    {!! $packageDetailsBanners->description_one !!}
                    {!! $packageDetailsBanners->description_two !!}
                </div>
            </div>
        </div>
        @endif

        <!-- Second Row -->
        <div class="grid-row">
            @if(!empty($contactsList) && count($contactsList) > 0)
            <div class="postcontainer">
                <div class="postheader">
                    Send your Job vacancy to - E-Mail/Call/WhatsApp
                </div>
                <div class="postcontent">
                    <table class="contact-table">
                        <tr>
                            <th class="emailth">Email:</th>
                            <td class="email">{{$packageDetailsBanners->email}}</td>
                        </tr>
                        <tr>
                            <th rowspan="{{ count($contactsList) + 1 }}">Call or WhatsApp</th>
                        </tr>
                        @foreach($contactsList as $contact)
                        <tr>
                            <td>{{ $contact->name }} : {{ $contact->phone }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="2" class="tfooter">
                                <strong>For International:</strong> Prefix the number with '+94' e.g., +94 77 99 540 63
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
            @endif
            @if($packagesBanners->isNotEmpty())
            <div class="postcontainer">
                <div class="postheader">
                    Rate Card for Banner Posts Advertising : effective from {{$packageDetailsBanners->effective_date}}
                </div>
                <div class="postcontent">
                    <table class="rate-table">
                        <tr>
                            <th class="package">Package size (Banner Posts)</th>
                            @php
                                $duration1 = $durations->firstWhere('id', 3); // Get duration where id = 1
                                $duration2 = $durations->firstWhere('id', 4); // Get duration where id = 2
                            @endphp

                            <th class="package" colspan="2">
                                {{ $duration1 ? $duration1->duration : '0' }} Days
                            </th>
                            <th class="package" colspan="2">
                                {{ $duration2 ? $duration2->duration : '0' }} Days
                            </th>
                        </tr>
                        <tr>
                            <th class="package"></th>
                            <th class="lkrprice pricetitle">Per ads LKR Price</th>
                            <th class="usdprice pricetitle">Per ads USD Price</th>
                            <th class="lkrprice pricetitle">Per ads LKR Price</th>
                            <th class="usdprice pricetitle">Per ads USD Price</th>
                        </tr>

                        @php
                        // Map prices based on duration
                        $du_id = $packagesBanners->keyBy('duration_id');
                        @endphp

                        <tr>
                            <td class="package">HOME PAGE (Landing Page)</td>
                            <td class="lkrprice">{{ $du_id[3]->price_lkr ?? 'N/A' }}</td>
                            <td class="usdprice">{{ $du_id[3]->price_usd ?? 'N/A' }}</td>
                            <td class="lkrprice">{{ $du_id[4]->price_lkr ?? 'N/A' }}</td>
                            <td class="usdprice">{{ $du_id[4]->price_usd ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <td class="package">CATEGORY PAGE (When a user visits a specific job category)</td>
                            <td class="lkrprice">{{ $du_id[3]->price_lkr ?? 'N/A' }}</td>
                            <td class="usdprice">{{ $du_id[3]->price_usd ?? 'N/A' }}</td>
                            <td class="lkrprice">{{ $du_id[4]->price_lkr ?? 'N/A' }}</td>
                            <td class="usdprice">{{ $du_id[4]->price_usd ?? 'N/A' }}</td>
                        </tr>

                    </table>
                </div>
            </div>
            @endif

        </div>

        <!-- Third Row -->
        @if(!empty($packageDetailsBanners->description_three))
        <div class="grid-row">
            <div class="postcontainer">
                <div class="postheader">
                    Method of Advertising Your Banner Posts: Via Email / WhatsApp
                </div>
                <div class="postcontent">
                    {!!$packageDetailsBanners->description_three!!}
                </div>
            </div>
        </div>
        @endif

        <!-- fourth Row -->
        <div class="grid-row">
            @if($localBanks->isNotEmpty())
            <div class="postcontainer">
                <div class="postheader">
                    Local Payments:
                </div>
                <div class="postcontent">
                    <div class="payment-header">
                        Online Fund Transfers or Direct Deposits
                    </div>
                    <table class="payment-table">
                        <tr>
                            <th class="title1">LOCAL LKR Payments</th>
                            @foreach ($localBanks as $lb)
                            <th colspan="2" style="text-align:center;">
                                @if ($lb->logo)
                                <img src="{{ asset('storage/' . $lb->logo) }}" style="height:50px; width:100px;"
                                    alt="{{ $lb->bank_name }} Logo" class="logo-thumbnail">
                                @else
                                <span class="text-muted"><strong>{{$lb->bank_name}}</strong></span>
                                @endif
                            </th>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>Bank Name</strong></td>
                            @foreach ($localBanks as $lb)
                            <td class="bgcolor" colspan="2"><strong>{{$lb->bank_name}}</strong></td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>Account Name</strong></td>
                            @foreach ($localBanks as $lb)
                            <td class="bgcolor" colspan="2">{{$lb->account_name}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>Account No</strong></td>
                            @foreach ($localBanks as $lb)
                            <td class="bgcolor" colspan="2">{{$lb->account_no}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>Bank Code</strong></td>
                            @foreach ($localBanks as $lb)
                            <td class="bgcolor" colspan="2">{{$lb->bank_code}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>Branch</strong></td>
                            @foreach ($localBanks as $lb)
                            <td class="bgcolor" colspan="2">{{$lb->branch_name}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>Branch Code</strong></td>
                            @foreach ($localBanks as $lb)
                            <td class="bgcolor" colspan="2">{{$lb->branch_name}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>SWIFT Code</strong></td>
                            @foreach ($localBanks as $lb)
                            <td class="bgcolor" colspan="2">{{$lb->swift_code}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>Currency</strong></td>
                            @foreach ($localBanks as $lb)
                            <td class="bgcolor" colspan="2">{{$lb->currency}}</td>
                            @endforeach
                        </tr>
                    </table>
                </div>
            </div>
            @endif

            @if($foreignBanks->isNotEmpty())
            <div class="postcontainer">
                <div class="postheader">
                    Foreign Payments:
                </div>
                <div class="postcontent">
                    <div class="payment-header">
                        Online Fund Transfers or Direct Deposits
                    </div>
                    <table class="payment-table">
                        <tr>
                            <th class="title1">FOREIGN USD Payments</th>
                            @foreach ($foreignBanks as $fb)
                            <th colspan="2" style="text-align:center;">
                                @if ($fb->logo)
                                <img src="{{ asset('storage/' . $fb->logo) }}" style="height:50px; width:100px;"
                                    alt="{{ $fb->bank_name }} Logo" class="logo-thumbnail">
                                @else
                                <span class="text-muted"><strong>{{$fb->bank_name}}</strong></span>
                                @endif
                            </th>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>Bank Name</strong></td>
                            @foreach ($foreignBanks as $fb)
                            <td class="bgcolor" colspan="2"><strong>{{$fb->bank_name}}</strong></td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>Account Name</strong></td>
                            @foreach ($foreignBanks as $fb)
                            <td class="bgcolor" colspan="2">{{$fb->account_name}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>Account No</strong></td>
                            @foreach ($foreignBanks as $fb)
                            <td class="bgcolor" colspan="2">{{$fb->account_no}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>Bank Code</strong></td>
                            @foreach ($foreignBanks as $fb)
                            <td class="bgcolor" colspan="2">{{$fb->bank_code}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>Branch</strong></td>
                            @foreach ($foreignBanks as $fb)
                            <td class="bgcolor" colspan="2">{{$fb->branch_name}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>Branch Code</strong></td>
                            @foreach ($foreignBanks as $fb)
                            <td class="bgcolor" colspan="2">{{$fb->branch_name}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>SWIFT Code</strong></td>
                            @foreach ($foreignBanks as $fb)
                            <td class="bgcolor" colspan="2">{{$fb->swift_code}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="title1"><strong>Currency</strong></td>
                            @foreach ($foreignBanks as $fb)
                            <td class="bgcolor" colspan="2">{{$fb->currency}}</td>
                            @endforeach
                        </tr>
                    </table>
                </div>
            </div>
            @endif
        </div>

        <!-- fifth Row -->
        <div class="grid-row">
            <div class="postcontainer">
                <div class="postcontent" style="background-color:orange;">
                    <span style="color:red; font-weight:bold">Note:</span>
                    <p>Once the payment is made, Please send the scanned copy/photo of the deposited slip via email or to WhatsApp number above.</p>
                    <p>For payments using fund transfer, You can send the screenshot of the receipt.</p>
                </div>
            </div>
        </div>
        
    </div>

    @include('home.footer')

    <script>
        $(document).ready(function() {
            // Initially show the Job section and hide the Banner section
            $('#job-section').show();
            $('#banner-section').hide();
            $('#job-button').addClass('active-button');

            // When clicking the 'Jobs' button
            $('#job-button').click(function() {
                $('#job-section').show();
                $('#banner-section').hide();

                // Change button colors
                $('#job-button').addClass('active-button');
                $('#banner-button').removeClass('active-button');
            });

            // When clicking the 'Banners' button
            $('#banner-button').click(function() {
                $('#job-section').hide();
                $('#banner-section').show();

                // Change button colors
                $('#banner-button').addClass('active-button');
                $('#job-button').removeClass('active-button');
            });
        });
    </script>
</body>

</html>