<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services</title> <!-- Updated Title -->

    <link rel="stylesheet" href="{{ asset('css/topemployees.css') }}">
</head>

<body>
    @include('home.header')

    <div class="container">
        <!-- Title & Buttons in the Same Row -->
        <div class="title-buttons-container">
            <h1 class="tit" style="color: #333 !important;">Our Services</h1>
            <div class="button-container">
                <a href="{{ route('press-releases.frontend') }}" class="custom-button">Career Resources</a>
                <a href="{{ route('press-releases.frontend') }}" class="custom-button">Press Release</a>
            </div>
        </div>

        <!-- Our Services Section -->
        <div class="content-box">
            <div class="box">
                <h3 class="highlight">Advertising in <span class="email">jobads.lk</span></h3>
                <ul class="styled-list">
                    <li>Job Vacancy advertising in <strong class="highlight">www.jobads.lk</strong></li>
                    <li>Facilitates with free Job Vacancy advertisement formats</li>
                    <li>Advertisement design and publishing in the print media (optional)</li>
                    <li>Facilitates Candidates to Prepare Individual CVs</li>
                </ul>
            </div>
            <div class="box">
                <h3 class="highlight">Full Recruitment Services</h3>
                <ul class="styled-list">
                    <li>Job Vacancy advertising in <strong class="highlight">www.jobads.lk</strong></li>
                    <li>Facilitates with free Job Vacancy advertisement formats</li>
                    <li>Advertisement design and publishing in the print media (optional)</li>
                    <li>Headhunting services and anonymized digital media advertising</li>
                    <li>Collection and screening of all profiles/CVs</li>
                    <li>Compile and submit a detailed candidate summary report</li>
                    <li>Timeline is 2 to 4 weeks from the date of signing of Engagement Acceptance</li>
                    <li>Facilitates Candidates to Prepare Individual CVs</li>
                </ul>
            </div>
        </div>

        <!-- Contact Section -->
        <div class="contact-section">
            <div class="contact-container">
                <div class="contact-logo">
                    <a href="/">
                        <img src="{{ asset('Jobads.png') }}" alt="Logo" class="unique-logo">
                    </a>
                </div>
                <div>
                    <h3 class="highlight">Contact Us for more Details (Call or WhatsApp)</h3>
                    <p><strong>Email: <span class="email">jobads@jobads.lk</span></strong></p>
                    <div class="yellow-box">
                        <table>
                            <tr>
                                <th>Name</th>
                                <th>Phone</th>
                            </tr>
                            @foreach ($contacts as $contact)
                                <tr>
                                    <td><span class="contact-names">{{ $contact->name }}</span></td>
                                    <td>{{ $contact->phone }}</td>
                                </tr>
                            @endforeach
                        </table>
                        <p class="working-hours">For International: Prefix the number with '+94' e.g. +94 77 99 540 63
                        </p>
                    </div>

                    <p class="working-hours">Working Hours Monday to Friday from 8:30am to 5:30pm</p>
                </div>
            </div>
        </div>
    </div>
</body>

<style>
    /* General Styles */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f8f8;
    }

    /* Container */
    .container {
        max-width: 1100px;
        margin: 10px auto;
        padding: 0px 20px;
        background-color: white;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
    }

    /* Title & Button Alignment */
    .title-buttons-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }



    /* Buttons Section */
    .button-container {
        display: flex;
        gap: 15px;
    }

    .custom-button {
        background-color: #e47520;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        transition: background 0.3s ease;
    }

    .custom-button:hover {
        background-color: #d0631e;
    }

    /* Services Section */
    .content-box {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        margin-top: 20px;
    }

    .box {
        flex: 1;
        background-color: white;
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    }

    .box h3 {
        color: green;
        font-size: 18px;
        font-weight: bold;
    }

    /* Bullet Point List */
    .styled-list {
        padding-left: 20px;
        font-size: 14px;
    }

    .styled-list li {
        margin-bottom: 8px;
    }

    /* Contact Section */
    .contact-section {
        display: flex;
        justify-content: center;
        margin-top: 30px;
        border-top: 2px solid #ddd;
        padding-top: 20px;
    }

    .contact-container {
        text-align: center;
    }

    .contact-logo {
        text-align: center;
        margin-bottom: 10px;
    }

    .contact-logo img {
        max-height: 60px;
    }

    .yellow-box {
        background-color: #fdf3c5;
        padding: 15px;
        border-radius: 5px;
        border: 1px solid #e2c53d;
        display: inline-block;
        text-align: center;
    }

    .yellow-box table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .yellow-box th,
    .yellow-box td {
        text-align: left;
        padding: 5px;
    }

    .yellow-box th {
        font-weight: bold;
    }

    .yellow-box tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .yellow-box tr td span {
        font-weight: bold;
        color: green;
    }

    .email {
        color: red;
        font-weight: bold;
    }

    .working-hours {
        font-size: 12px;
        color: gray;
        margin-top: 5px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .title-buttons-container {
            flex-direction: column;
            text-align: center;
        }

        .button-container {
            margin-top: 10px;
            justify-content: center;
        }
    }
</style>

</html>
