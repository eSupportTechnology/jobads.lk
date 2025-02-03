<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/personalprofile.css') }}">

    <style>
        .profile-preview {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
            border: 3px solid #ddd;
        }

        .profile-image-section {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    @include('user.jobseekerprofile.mainview.profilelayout')

    <div class="personalcontainer">
        <h1>Personal Details</h1>
        <!-- resources/views/components/user-profile-form.blade.php -->
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div>
                <label for="name">Name</label>
                <input class="personalprofile" type="text" name="name" value="{{ Auth::user()->name }}"
                    id="name" required>
            </div>
            <div class="profile-image-section">
                @if (Auth::user()->profile_image)
                    <img src="{{ asset('storage/profile_images/' . Auth::user()->profile_image) }}" alt="Profile Image"
                        class="profile-preview">
                    <p>Current Profile Image</p>
                @else
                    <img src="{{ asset('images/default-avatar.png') }}" alt="Default Profile Image"
                        class="profile-preview">
                    <p>No Profile Image</p>
                @endif
            </div>

            <div>
                <label for="profile_image">Profile Image</label>
                <input class="personalprofile" type="file" name="profile_image" id="profile_image">
                <small>Upload new image to update (Max 2MB, JPG/PNG)</small>
            </div>
            <div>
                <label for="email">Email</label>
                <input class="personalprofile" type="email" name="email" value="{{ Auth::user()->email }}"
                    id="email" required>
            </div>

            <div>
                <label for="phone_number">Phone Number</label>
                <input class="personalprofile" type="text" name="phone_number"
                    value="{{ Auth::user()->phone_number }}" id="phone_number" required>
            </div>

            <div>
                <label for="address">Address</label>
                <textarea name="address" id="address" class="personalprofile">{{ Auth::user()->address }}</textarea>
            </div>

            <div>
                <label for="linkedin">LinkedIn Profile</label>
                <input class="personalprofile" type="url" name="linkedin" value="{{ Auth::user()->linkedin }}"
                    id="linkedin">
            </div>

            <div>
                <label for="summary">Professional Summary</label>
                <textarea name="summary" id="summary" class="personalprofile">{{ Auth::user()->summary }}</textarea>
            </div>

            <div>
                <label for="experience">Work experience</label>
                <textarea name="experience" id="experience" class="personalprofile">{{ Auth::user()->experience }}</textarea>
            </div>

            <div>
                <label for="education">Education</label>
                <textarea name="education" id="education" class="personalprofile">{{ Auth::user()->education }}</textarea>
            </div>

            <div>
                <label for="skills">Skills</label>
                <textarea name="skills" id="skills" class="personalprofile">{{ Auth::user()->skills }}</textarea>
            </div>

            <div>
                <label for="certifications">Certifications</label>
                <textarea name="certifications" id="certifications" class="personalprofile">{{ Auth::user()->certifications }}</textarea>
            </div>

            <div>
                <label for="portfolio_link">Portfolio Link</label>
                <input class="personalprofile" type="url" name="portfolio_link"
                    value="{{ Auth::user()->portfolio_link }}" id="portfolio_link">
            </div>

            <div>
                <label for="social_links">Social Media Links</label>
                <textarea name="social_links" id="social_links" class="personalprofile">{{ Auth::user()->social_links }}</textarea>
            </div>

            <div>
                <label for="resume_file">Resume</label>
                <input class="personalprofile" type="file" name="resume_file" id="resume_file">
            </div>

            <button type="submit">Submit</button>
        </form>
    </div>

    <script>
        // පැතිකඩ රූපයේ පෙරදසුන - වැඩිදියුණු කළ අනුවාදය
        document.addEventListener('DOMContentLoaded', function() {
            const profileImageInput = document.getElementById('profile_image');
            const profileImageSection = document.querySelector('.profile-image-section');
            let profilePreview = document.getElementById('profile-preview-image');

            // නව රූපය තෝරාගත් විට
            if (profileImageInput) {
                profileImageInput.addEventListener('change', function(e) {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            if (!profilePreview) {
                                profilePreview = document.createElement('img');
                                profilePreview.id = 'profile-preview-image';
                                profilePreview.className = 'profile-preview';
                                profileImageSection.prepend(profilePreview);
                            }
                            profilePreview.src = e.target.result;
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }

            // පිටු පූරණය වූ විට පෙරදසුන යාවත්කාලීන කිරීම
            @if (Auth::user()->profile_image)
                const img = new Image();
                img.src =
                    "{{ asset('storage/profile_images/' . Auth::user()->profile_image) }}?{{ time() }}";
                img.onload = function() {
                    if (profilePreview) {
                        profilePreview.src = this.src;
                    }
                };
                img.onerror = function() {
                    if (profilePreview) {
                        profilePreview.src = "{{ asset('images/default-avatar.png') }}";
                    }
                };
            @endif
        });
    </script>
</body>

</html>
