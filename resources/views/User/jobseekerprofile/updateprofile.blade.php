<div class="profile-header">
    <h1>Common Profile</h1>
</div>
<form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="form-section">
    <label for="name">Name:</label>
    <span>{{ auth()->user()->name }}</span>
</div>

<div class="form-section">
    <label for="email">Email:</label>
    <span>{{ auth()->user()->email }}</span>
</div>

<div class="form-section">
    <label for="contact">Phone Number:</label>
    <span>{{ auth()->user()->phone_number }}</span>
</div>

<!-- <div class="form-section">
    <label for="address">Address:</label>
    <p>{{ auth()->user()->address }}</p>
</div> -->


    <div class="form-section">
       
        <div class="form-section">
            


           
</form>
