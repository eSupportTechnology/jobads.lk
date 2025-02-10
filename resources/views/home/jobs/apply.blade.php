<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply by Email</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 60%;
            margin: 20px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 1.8rem;
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-size: 1rem;
            color: #333;
            margin-bottom: 5px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-left: -10px;
        }

        .text-danger {
            color: red;
            font-size: 0.9rem;
        }

        .note {
            background: #e8f5e9;
            border-left: 5px solid #4caf50;
            padding: 10px;
            margin-bottom: 20px;
            color: #4caf50;
            font-size: 0.9rem;
        }

        .form-group input[type="file"] {
            padding: 5px;
        }

        .form-group small {
            color: #888;
        }

        .form-group .checkbox-label {
            display: inline-block;

        }

        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 15px;
            border: none;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-submit {
            background: #007bff;
        }

        .btn-clear {
            background: #ffc107;
        }

        .btn-close {
            background: #dc3545;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Apply by Email</h1>
        @if (session('success'))
            <div class="alert alert-success"
                style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('apply.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="note">
                Your CV is sent to the employer directly and they will contact you directly on the selection process.
            </div>
            <!-- Hidden Fields for employer_id and user_id -->
            <input type="hidden" name="job_posting_id" value="{{ $job->id }}">
            <input type="hidden" name="employer_id" value="{{ $job->employer_id }}">
            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
            <div class="form-group">
                <label for="company_mail">Company Email:</label>
                <input type="disabled" id="company_mail" name="company_mail" value="{{ $employerEmail }}" readonly>
            </div>
            <div class="form-group">
                <label for="name">Your Name: <span class="text-danger"></span></label>
                <input type="text" name="name" id="name" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="contact_number">Contact No: <span class="text-danger"></span></label>
                <input type="text" name="contact_number" id="contact_number" required>
                @error('contact_no')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Your Email: <span class="text-danger"></span></label>
                <input type="email" name="email" id="email" required>
                <small>Please check your email address carefully.</small>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="message">Message: <span class="text-danger"></span></label>
                <textarea name="message" id="message" rows="4" required></textarea>
                @error('message')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="cv_option">CV Option:</label>
                <div>
                    <input type="radio" id="upload_cv" name="cv_option" value="upload" checked>
                    <label for="upload_cv">Upload CV</label>
                    <input type="radio" id="create_cv" name="cv_option" value="create">
                    <label for="create_cv">Create CV</label>
                </div>
            </div>

            <div id="upload_cv_section" class="form-group">
                <label for="cv_path">Attach Your CV: <span class="text-danger">*</span></label>
                <input type="file" name="cv_path" id="cv_path"
                    accept=".doc,.docx,.pdf,.odt,.rtf,.jpg,.jpeg,.gif,.png">
                <small>Allowed types: .doc, .docx, .odt, .pdf, .rtf, .jpg, .jpeg, .gif, .png. Max size: 2.0MB</small>
            </div>

            <div id="create_cv_section" class="form-group" style="display: none;">
                <label for="cv_template">Select CV Template:</label>
                <select id="cv_template" name="cv_template">
                    <option value="template1">Template 1</option>
                    <option value="template2">Template 2</option>
                    <option value="template3">Template 3</option>
                </select>
                <button type="button" class="btn btn-clear" id="create_cv_button">Create CV</button>
            </div>

            <div class="form-group">

                <label for="send_copy" class="checkbox-label">Send me a copy of my email application</label>
            </div>

            <div class="form-group">
                <label for="verify_email">Verify Your Email: <span class="text-danger">*</span></label>
                <input type="email" name="verify_email" id="verify_email"
                    placeholder="Verify your email address carefully." required>
                @error('verify_email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <p><strong>General Message:</strong> Apply for this vacancy only if you are genuinely interested in this
                position.</p>

            <div class="btn-group">
                <button type="submit" class="btn btn-submit">Apply</button>
                <button type="reset" class="btn btn-clear">Clear</button>
                <button type="button" onclick="location.reload();" class="btn btn-close">Close</button>

            </div>

        </form>
    </div>
    <script>
        // $(document).ready(function() {
        //     $('input[name="cv_option"]').on('change', function() {
        //         if ($(this).val() === 'upload') {
        //             $('#upload_cv_section').show();
        //             $('#create_cv_section').hide();
        //         } else if ($(this).val() === 'create') {
        //             $('#upload_cv_section').hide();
        //             $('#create_cv_section').show();
        //         }
        //     });

        //     $('#create_cv_button').on('click', function() {
        //         // Get form data
        //         var name = $('#name').val();
        //         var email = $('#email').val();
        //         var contact_number = $('#contact_number').val();
        //         var message = $('#message').val();
        //         var job_posting_id = $('input[name="job_posting_id"]').val();
        //         var employer_id = $('input[name="employer_id"]').val();
        //         var selectedTemplate = $('#cv_template').val(); // Get selected template

        //         // Determine the correct route based on the selected template
        //         var route = '';
        //         if (selectedTemplate === 'template1') {
        //             route = "/profile/cv";
        //         } else if (selectedTemplate === 'template2') {
        //             route = "/profile/cv2";
        //         } else if (selectedTemplate === 'template3') {
        //             route = "/profile/cv3";
        //         }

        //         // Construct the URL with query parameters
        //         var url = route + "?name=" + encodeURIComponent(name) +
        //             "&email=" + encodeURIComponent(email) +
        //             "&contact_number=" + encodeURIComponent(contact_number) +
        //             "&message=" + encodeURIComponent(message) +
        //             "&job_posting_id=" + job_posting_id +
        //             "&employer_id=" + employer_id;

        //         // Redirect to the appropriate CV generation page
        //         window.location.href = url;
        //     });
        // });
        $(document).ready(function() {
            // Handle CV option radio buttons
            $('input[name="cv_option"]').on('change', function() {
                if ($(this).val() === 'upload') {
                    $('#upload_cv_section').show();
                    $('#create_cv_section').hide();
                } else if ($(this).val() === 'create') {
                    $('#upload_cv_section').hide();
                    $('#create_cv_section').show();
                }
            });

            // Handle create CV button click
            $('#create_cv_button').on('click', function(e) {
                e.preventDefault(); // Prevent any default button behavior
                e.stopPropagation(); // Stop event bubbling

                // Check required fields
                let isValid = true;
                let errorMessage = '';

                // Validate name
                if (!$('#name').val().trim()) {
                    isValid = false;
                    errorMessage += 'Please enter your name\n';
                    $('#name').css('border-color', 'red');
                } else {
                    $('#name').css('border-color', '#ddd');
                }

                // Validate contact number
                if (!$('#contact_number').val().trim()) {
                    isValid = false;
                    errorMessage += 'Please enter your contact number\n';
                    $('#contact_number').css('border-color', 'red');
                } else {
                    $('#contact_number').css('border-color', '#ddd');
                }

                // Validate email
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!$('#email').val().trim() || !emailRegex.test($('#email').val().trim())) {
                    isValid = false;
                    errorMessage += 'Please enter a valid email address\n';
                    $('#email').css('border-color', 'red');
                } else {
                    $('#email').css('border-color', '#ddd');
                }

                // Validate message
                if (!$('#message').val().trim()) {
                    isValid = false;
                    errorMessage += 'Please enter your message\n';
                    $('#message').css('border-color', 'red');
                } else {
                    $('#message').css('border-color', '#ddd');
                }

                // Validate verify email
                if (!$('#verify_email').val().trim()) {
                    isValid = false;
                    errorMessage += 'Please verify your email address\n';
                    $('#verify_email').css('border-color', 'red');
                } else if ($('#verify_email').val().trim() !== $('#email').val().trim()) {
                    isValid = false;
                    errorMessage += 'Email addresses do not match\n';
                    $('#verify_email').css('border-color', 'red');
                } else {
                    $('#verify_email').css('border-color', '#ddd');
                }

                // If validation fails, show error and return
                if (!isValid) {
                    alert(errorMessage);
                    return false;
                }

                // Only proceed if validation passed
                if (isValid) {
                    // Get form data
                    const formData = {
                        name: $('#name').val().trim(),
                        email: $('#email').val().trim(),
                        contact_number: $('#contact_number').val().trim(),
                        message: $('#message').val().trim(),
                        job_posting_id: $('input[name="job_posting_id"]').val(),
                        employer_id: $('input[name="employer_id"]').val()
                    };

                    // Determine route based on selected template
                    let route = '';
                    const selectedTemplate = $('#cv_template').val();

                    switch (selectedTemplate) {
                        case 'template1':
                            route = "/profile/cv";
                            break;
                        case 'template2':
                            route = "/profile/cv2";
                            break;
                        case 'template3':
                            route = "/profile/cv3";
                            break;
                    }

                    // Construct URL with query parameters
                    const queryString = Object.keys(formData)
                        .map(key => `${encodeURIComponent(key)}=${encodeURIComponent(formData[key])}`)
                        .join('&');

                    // Redirect to CV generation page only if validation passed
                    window.location.href = `${route}?${queryString}`;
                }
            });

            // Prevent form submission
            $('form').on('submit', function(e) {
                // Always prevent default form submission for create CV option
                if ($('input[name="cv_option"]:checked').val() === 'create') {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }
            });
        });
    </script>
</body>

</html>
