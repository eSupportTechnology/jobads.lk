<head>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">


    <style>
        /* Container adjustments */
        .education-container {
            width: 100%;
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border: 2px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);

        }



        /* Form layout styles */
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            flex: 1;
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

        .example {
            font-size: 12px;
            color: #999;
            display: block;
            margin-top: 5px;
        }

        /* Button styles */
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s ease-in-out;
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

        .btn-add-grade {
            margin-left: 10px;
            background: none;
            border: none;
            cursor: pointer;
        }

        /* Table styles */
        .table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            overflow-x: auto;
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

        .check {
            margin-top: 50px;
        }

        /* Mobile-Friendly Adjustments */
        @media (max-width: 768px) {
            .education-container {
                width: 35%;
                padding: 15px;
                margin-left: 0;
                /* Align to the left */
                margin-right: auto;
            }

            /* Adjust form layout for small screens */
            .form-row {
                flex-direction: column;
                gap: 10px;
            }

            .form-group {
                flex: 1;
            }

            /* Adjust button width for mobile */
            .btn {
                width: 100%;
                text-align: center;
            }

            /* Adjust table for mobile view */
            .table {
                display: block;
                width: 50%;
                overflow-x: auto;
                white-space: nowrap;
            }

            .table th,
            .table td {
                font-size: 14px;
            }

            .check {
                margin-top: 900px;
                margin-left: -430px;
            }
        }
    </style>
</head>

<body>
    @include('user.jobseekerprofile.mainview.profilelayout')

    <div class="check">
        <div class="education-container">
            <h2 class="section-header">School Education</h2>

            {{-- Display existing education entries --}}
            @foreach (auth()->user()->jobEducations ?? [] as $education)
                <form method="POST" action="{{ route('education.update', $education->id) }}" class="mb-4">
                    @csrf
                    @method('PUT')
                    <div class="education-entry">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>School/Institute <span class="required">*</span></label>
                                <input type="text" name="institution_name" value="{{ $education->institution_name }}"
                                    class="form-control" placeholder="Institution Name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Program <span class="required">*</span></label>
                                <input type="text" name="degree" value="{{ $education->degree }}"
                                    class="form-control" placeholder="Degree" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Field of Study <span class="required">*</span></label>
                                <textarea name="field_of_study" class="form-control" rows="3" placeholder="Field of Study" required>{{ $education->field_of_study }}</textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Start Date <span class="required">*</span></label>
                                <input type="date" name="start_date" value="{{ $education->start_date }}"
                                    class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>End Date <span class="required">*</span></label>
                                <input type="date" name="end_date" value="{{ $education->end_date }}"
                                    class="form-control" required>
                            </div>
                        </div>

                        <div class="form-row mt-2">
                            <div class="col">
                                <button type="submit" class="btn btn-education">Update</button>
                                <a href="{{ route('education.delete', $education->id) }}"
                                    onclick="return confirm('Are you sure you want to delete this education record?')"
                                    class="btn btn-primary">Delete</a>
                            </div>
                        </div>
                    </div>
                </form>
            @endforeach

            {{-- Add new education form --}}
            <h3 class="mt-4">Add New Education</h3>
            <form method="POST" action="{{ route('education.store') }}" id="newEducationForm">
                @csrf
                <input type="hidden" name="job_seeker_id" value="{{ auth()->id() }}">

                <div id="educationContainer">
                    <div class="education-entry mb-4">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>School/Institute <span class="required">*</span></label>
                                <input type="text" name="educations[0][institution_name]" class="form-control"
                                    placeholder="Institution Name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Program <span class="required">*</span></label>
                                <input type="text" name="educations[0][degree]" class="form-control"
                                    placeholder="Degree" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Field of Study <span class="required">*</span></label>
                                <textarea name="educations[0][field_of_study]" class="form-control" rows="3" placeholder="Field of Study"
                                    required></textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Start Date <span class="required">*</span></label>
                                <input type="date" name="educations[0][start_date]" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>End Date <span class="required">*</span></label>
                                <input type="date" name="educations[0][end_date]" class="form-control" required>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>

                <div class="form-row mt-3 mb-4">
                    <div class="col">
                        <button type="button" class="btn btn-education" onclick="addEducationField()">Add Another
                            Education</button>
                        <button type="submit" class="btn btn-success">Save All Education Details</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        let educationCount = 1;

        function addEducationField() {
            const container = document.getElementById('educationContainer');
            const newEducation = document.createElement('div');
            newEducation.className = 'education-entry mb-4';

            newEducation.innerHTML = `
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>School/Institute <span class="required">*</span></label>
                        <input type="text" name="educations[${educationCount}][institution_name]" class="form-control" placeholder="Institution Name" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Program <span class="required">*</span></label>
                        <input type="text" name="educations[${educationCount}][degree]" class="form-control" placeholder="Degree" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label>Field of Study <span class="required">*</span></label>
                        <textarea name="educations[${educationCount}][field_of_study]" class="form-control" rows="3" placeholder="Field of Study" required></textarea>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Start Date <span class="required">*</span></label>
                        <input type="date" name="educations[${educationCount}][start_date]" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>End Date <span class="required">*</span></label>
                        <input type="date" name="educations[${educationCount}][end_date]" class="form-control" required>
                    </div>
                </div>
                <button type="button" class="btn btn-danger" onclick="removeEducation(this)">Remove</button>
                <hr>
            `;

            container.appendChild(newEducation);
            educationCount++;
        }

        function removeEducation(button) {
            button.closest('.education-entry').remove();
        }
    </script>
</body>
