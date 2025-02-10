<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IPG</title>
    <link rel="stylesheet" href="styles.css"> <!-- Linking external CSS file -->
</head>

<body>


    <!-- Contact Information -->
    <div class="paymentmethod-header">For Credit/Debit Card Payments</div>
    <div class="paymentmethod-info">
        @foreach ($contacts as $contact)
            <tr>
                <td><span class="contact-names">{{ $contact->name }}</span></td>
                <td>{{ $contact->phone }}</td>
            </tr>
        @endforeach
    </div>
</body>

</html>
