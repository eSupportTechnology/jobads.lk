@extends('layouts.admin.master')

@section('title', 'Create Banner Details')

<head>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Quill.js CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <style>
        .ql-editor {
            min-height: 200px;
        }
    </style>
</head>

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Create Banner Details</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('bannerdetails.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $post->email ?? '') }}" required>
                            </div>

                            <div class="form-group mb-3 col-md-6">
                                <label for="effective_date">Effective Date</label>
                                <input type="date" name="effective_date" class="form-control" value="{{ old('effective_date', $post->effective_date ?? '') }}" required>
                            </div>

                            <div class="form-group mb-3 col-md-6">
                                <label for="mbsize">Main Banner Size</label>
                                <input type="text" name="mbsize" class="form-control" value="{{ old('mbsize', $post->mbsize ?? '') }}" required>
                            </div>

                            <div class="form-group mb-3 col-md-6">
                                <label for="cbsize">Category Banner Size</label>
                                <input type="text" name="cbsize" class="form-control" value="{{ old('cbsize', $post->cbsize ?? '') }}" required>
                            </div>

                            <div class="form-group mb-3 col-md-12">
                                <label for="editor-one">Description 1</label>
                                <div id="editor-one" style="height: 200px;"></div>
                                <input type="hidden" id="hidden-input-one" name="description_one" value="{{ old('description_one', $post->description_one ?? '') }}">
                            </div>

                            <div class="form-group mb-3 col-md-12">
                                <label for="editor-two">Description 2</label>
                                <div id="editor-two" style="height: 200px;"></div>
                                <input type="hidden" id="hidden-input-two" name="description_two" value="{{ old('description_two', $post->description_two ?? '') }}">
                            </div>

                            <div class="form-group mb-3 col-md-12">
                                <label for="editor-three">Description 3</label>
                                <div id="editor-three" style="height: 200px;"></div>
                                <input type="hidden" id="hidden-input-three" name="description_three" value="{{ old('description_three', $post->description_three ?? '') }}">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- jQuery (If Needed) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Quill.js -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
    $(document).ready(function() {


        var toolbarOptions = [
            [{
                'font': []
            }],
            [{
                'size': ['small', false, 'large', 'huge']
            }],
            ['bold', 'italic', 'underline', 'strike'],
            [{
                'color': []
            }, {
                'background': []
            }],
            [{
                'script': 'sub'
            }, {
                'script': 'super'
            }],
            [{
                'header': [1, 2, 3, 4, 5, 6, false]
            }],
            [{
                'align': []
            }],
            ['blockquote', 'code-block'],
            [{
                'list': 'ordered'
            }, {
                'list': 'bullet'
            }],
            [{
                'indent': '-1'
            }, {
                'indent': '+1'
            }],
            ['link', 'image', 'video'],
            ['clean']
        ];

        // Initialize Quill editors
        var quill1 = new Quill('#editor-one', {
            theme: 'snow',
            modules: {
                toolbar: toolbarOptions
            }
        });
        var quill2 = new Quill('#editor-two', {
            theme: 'snow',
            modules: {
                toolbar: toolbarOptions
            }
        });
        var quill3 = new Quill('#editor-three', {
            theme: 'snow',
            modules: {
                toolbar: toolbarOptions
            }
        });

        // Load existing data from hidden inputs
        quill1.root.innerHTML = $("#hidden-input-one").val();
        quill2.root.innerHTML = $("#hidden-input-two").val();
        quill3.root.innerHTML = $("#hidden-input-three").val();

        // Ensure Quill.js content is stored before form submission
        $("form").on("submit", function(event) {


            $("#hidden-input-one").val(quill1.root.innerHTML.trim());
            $("#hidden-input-two").val(quill2.root.innerHTML.trim());
            $("#hidden-input-three").val(quill3.root.innerHTML.trim());


        });
    });
</script>
@endsection