@php
    $contact = App\Models\ContactUs::first();
@endphp

@if ($contact && $contact->logo_img)
<img class="img-fluid" style="width: 200px" src="https://jobads.ottesupport.xyz/storage/app/public/contactus/logo.png" alt="Application Logo">

@else
    <p>No logo available</p>
@endif
