// Edit Blade
@extends('layouts.employer.master')

@section('title', 'Edit Banner')

@section('css')
    <style>
        .image-preview-container {
            margin-top: 15px;
            border: 2px dashed #ddd;
            border-radius: 6px;
            padding: 15px;
            text-align: center;
            background: #f8f9fa;
        }

        .image-preview-container img {
            max-width: 100%;
            max-height: 300px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .preview-text {
            color: #6c757d;
            font-size: 0.9rem;
            margin-top: 10px;
            display: block;
        }
    </style>
@endsection

@section('breadcrumb-title')
    <h3>Edit Banner</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Dashboard</li>
    <li class="breadcrumb-item active">Edit Banner</li>
@endsection

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Edit Banner</h5>
                    </div>
                    <div class="card-body">
                        <form id="bannerForm" action="{{ route('empbanners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="package_id" class="form-label">Package</label>
                                <select name="package_id" class="form-control">
                                    @foreach ($packages as $package)
                                        <option value="{{ $package->id }}" {{ $banner->package_id == $package->id ? 'selected' : '' }}>
                                            {{ ucfirst($package->duration) }} - LKR {{ $package->price_lkr }} / USD {{ $package->price_usd }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label">Banner Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ $banner->title }}" required>
                            </div>

                            

                            <div class="mb-3">
                                <label for="placement" class="form-label">Banner Placement</label>
                                <select name="placement" id="placement" class="form-control" required>
                                    <option value="banner" {{ $banner->placement == 'banner' ? 'selected' : '' }}>Main Banner (Image size: {{$packageDetailsBanners->mbsize}})</option>
                                    <option value="category_page" {{ $banner->placement == 'category_page' ? 'selected' : '' }}>Category Pag (Image size: {{$packageDetailsBanners->cbsize}})e</option>
                                </select>
                            </div>

                            <div class="mb-3" id="categorySection" style="display: {{ $banner->placement == 'category_page' ? 'block' : 'none' }};">
                                <label for="category_id" class="form-label">Category</label>
                                <select name="category_id" id="category_id" class="form-control" {{ $banner->placement == 'category_page' ? 'required' : '' }}>
                                    <option value="">Select a category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $banner->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Banner Image</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <div class="image-preview-container mt-2">
                                    @if ($banner->image)
                                        <img id="imagePreview" src="{{ asset('storage/' . $banner->image) }}" alt="Preview">
                                    @else
                                        <img id="imagePreview" src="" alt="Preview" style="display: none; max-width: 100%;">
                                    @endif
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Banner</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const placementSelect = document.getElementById('placement');
            const categorySection = document.getElementById('categorySection');
            const categorySelect = document.getElementById('category_id');

            // Function to toggle category field
            function toggleCategoryField() {
                if (placementSelect.value === 'category_page') {
                    categorySection.style.display = 'block';
                    categorySelect.required = true;
                } else {
                    categorySection.style.display = 'none';
                    categorySelect.required = false;
                    categorySelect.value = ''; // Reset category selection
                }
            }

            // Initial check
            toggleCategoryField();

            // Add event listener for placement changes
            placementSelect.addEventListener('change', toggleCategoryField);

            // Image preview handler
            document.getElementById('image').addEventListener('change', function(event) {
                const preview = document.getElementById('imagePreview');
                const file = event.target.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    preview.style.display = 'none';
                }
            });
        });
    </script>
@endsection