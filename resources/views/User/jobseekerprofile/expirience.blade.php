<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Experience</title>

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">

    <style>
        .experience-container {
            max-width: 900px;
            margin: 20px auto;
            padding: 0 20px;
            background: #fff;
            border: 2px dashed #d01b1b;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-top: -800px;
            margin-left: 500px;
        }

        .section-header {
            font-size: 20px;
            font-weight: bold;
            color: #fff;
            background-color: blue;
            padding: 10px;
            border-radius: 5px 5px 0 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .required {
            color: red;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
        }

        textarea.form-control {
            resize: none;
        }

        .info {
            font-size: 12px;
            color: #666;
            display: block;
            margin-top: 5px;
        }

        .example {
            font-size: 12px;
            color: #999;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-primary {
            background-color: #d01b1b;
        }

        .btn-primary:hover {
            background-color: #b81717;
        }

        .btn-success {
            background-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }


        .experience-container {
            max-width: 900px;
            margin: 20px auto;
            padding: 0 20px;
            background: #fff;
            border: 2px dashed #d01b1b;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-top: -800px;
            margin-left: 500px;
        }

        /* Mobile-Friendly Adjustments */
        @media (max-width: 768px) {
            .experience-container {
                width: 90%;
                margin: 10px auto;
                padding: 15px;
                margin-top: 0;
                margin-left: 0;
            }

            .section-header {
                font-size: 18px;
                text-align: center;
            }

            /* Adjust form layout for small screens */
            .form-group {
                flex: 1;
            }

            .form-control {
                font-size: 14px;
            }

            /* Adjust button width for mobile */
            .btn {
                width: 100%;
                text-align: center;
            }

            /* Adjust table for mobile view */
            .table {
                display: block;
                width: 100%;
                overflow-x: auto;
                white-space: nowrap;
            }

            .table th,
            .table td {
                font-size: 14px;
            }

        }
    </style>

</head>

<body>
    @include('user.jobseekerprofile.mainview.profilelayout')
    <div class="experience-container">
        <h2 class="section-header">Professional Experience</h2>

        {{-- Display existing experience entries --}}
        @foreach (auth()->user()->jobExperiences ?? [] as $experience)
            <form method="POST" action="{{ route('experience.update', $experience->id) }}" class="mb-4">
                @csrf
                @method('PUT')
                <div class="experience-entry">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Organisation <span class="required">*</span></label>
                            <input type="text" name="company_name" value="{{ $experience->company_name }}"
                                class="form-control" placeholder="Company Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Designation <span class="required">*</span></label>
                            <input type="text" name="job_title" value="{{ $experience->job_title }}"
                                class="form-control" placeholder="Job Title" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Job Description <span class="required">*</span></label>
                            <textarea name="job_description" class="form-control" rows="3" placeholder="Job Description" required>{{ $experience->job_description }}</textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Start Date <span class="required">*</span></label>
                            <input type="date" name="start_date" value="{{ $experience->start_date }}"
                                class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>End Date <span class="required">*</span></label>
                            <input type="date" name="end_date" value="{{ $experience->end_date }}"
                                class="form-control" required>
                        </div>
                    </div>

                    <div class="form-row mt-2">
                        <div class="col">
                            <button type="submit" class="btn btn-education">Update</button>
                            <a href="{{ route('experience.delete', $experience->id) }}"
                                onclick="return confirm('Are you sure you want to delete this experience record?')"
                                class="btn btn-primary">Delete</a>
                        </div>
                    </div>
                </div>
            </form>
        @endforeach

        {{-- Add new experience form --}}
        <h3 class="mt-4">Add New Experience</h3>
        <form method="POST" action="{{ route('experience.store') }}" id="newExperienceForm">
            @csrf
            <input type="hidden" name="job_seeker_id" value="{{ auth()->id() }}">

            <div id="experienceContainer">
                <div class="experience-entry mb-4">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Organisation <span class="required">*</span></label>
                            <input type="text" name="experiences[0][company_name]" class="form-control"
                                placeholder="Company Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Designation <span class="required">*</span></label>
                            <input type="text" name="experiences[0][job_title]" class="form-control"
                                placeholder="Job Title" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Job Description <span class="required">*</span></label>
                            <textarea name="experiences[0][job_description]" class="form-control" rows="3" placeholder="Job Description"
                                required></textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Start Date <span class="required">*</span></label>
                            <input type="date" name="experiences[0][start_date]" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>End Date <span class="required">*</span></label>
                            <input type="date" name="experiences[0][end_date]" class="form-control" required>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>

            <div class="form-row mt-3 mb-4">
                <div class="col">
                    <button type="button" class="btn btn-education" onclick="addExperienceField()">Add Another
                        Experience</button>
                    <button type="submit" class="btn btn-success">Save All Experience Details</button>
                </div>
            </div>
        </form>
    </div>

    <style>
        .required {
            color: red;
        }
    </style>

    <script>
        let experienceCount = 1;

        function addExperienceField() {
            const container = document.getElementById('experienceContainer');
            const newExperience = document.createElement('div');
            newExperience.className = 'experience-entry mb-4';

            newExperience.innerHTML = `
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Organisation <span class="required">*</span></label>
                    <input type="text" name="experiences[${experienceCount}][company_name]" class="form-control"
                        placeholder="Company Name" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Designation <span class="required">*</span></label>
                    <input type="text" name="experiences[${experienceCount}][job_title]" class="form-control"
                        placeholder="Job Title" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Job Description <span class="required">*</span></label>
                    <textarea name="experiences[${experienceCount}][job_description]" class="form-control" rows="3"
                        placeholder="Job Description" required></textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Start Date <span class="required">*</span></label>
                    <input type="date" name="experiences[${experienceCount}][start_date]" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label>End Date <span class="required">*</span></label>
                    <input type="date" name="experiences[${experienceCount}][end_date]" class="form-control" required>
                </div>
            </div>
            <button type="button" class="btn btn-danger" onclick="removeExperience(this)">Remove</button>
            <hr>
        `;

            container.appendChild(newExperience);
            experienceCount++;
        }

        function removeExperience(button) {
            button.closest('.experience-entry').remove();
        }
    </script>
</body>

</html>
