@php
    $contact = App\Models\ContactUs::first();
@endphp

@if ($contact && $contact->logo_img)
    <img src="{{ asset('Jobads.png') }}" alt="Application Logo"  class="img-fluid" style="max-height: 60px;">
@else
    <img src="{{ asset('Jobads.png') }}" alt="Application Logo"  class="img-fluid" style="max-height: 60px;">
@endif
