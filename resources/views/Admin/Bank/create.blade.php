@extends('layouts.admin.master')

@section('title', 'Create Bank Account')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Create Bank Account</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Dashboard</li>
    <li class="breadcrumb-item">Bank Accounts</li>
    <li class="breadcrumb-item active">Create Bank Account</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.bank-accounts.store') }}" class="needs-validation"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                
                                <!-- Existing Fields -->
                                <div class="col-md-6">
                                    <label for="bank_name" class="form-label">Bank Name</label>
                                    <input type="text" class="form-control" id="bank_name" name="bank_name" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="account_name" class="form-label">Account Name</label>
                                    <input type="text" class="form-control" id="account_name" name="account_name"
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <label for="account_no" class="form-label">Account Number</label>
                                    <input type="text" class="form-control" id="account_no" name="account_no" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="bank_code" class="form-label">Bank Code</label>
                                    <input type="text" class="form-control" id="bank_code" name="bank_code" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="branch_code" class="form-label">Branch Code</label>
                                    <input type="text" class="form-control" id="branch_code" name="branch_code" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="branch_name" class="form-label">Branch Name</label>
                                    <input type="text" class="form-control" id="branch_name" name="branch_name" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="swift_code" class="form-label">SWIFT Code</label>
                                    <input type="text" class="form-control" id="swift_code" name="swift_code">
                                </div>

                                <div class="col-md-6">
                                    <label for="currency" class="form-label">Currency</label>
                                    <input type="text" class="form-control" id="currency" name="currency" required>
                                </div>

                                <!-- Add Logo Upload Field -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="logo">Bank Logo</label>
                                        <div class="custom-file">
                                            <input type="file" class="form-control" id="logo" name="logo"
                                                accept="image/*" onchange="previewImage(event)">
                                            @error('logo')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="image-preview mt-2">
                                            <img id="logoPreview" src="#" alt="Logo Preview"
                                                style="max-width: 200px; display: none;" class="img-thumbnail">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="localorforeign" class="form-label">Local or Foreign</label>
                                    <select class="form-control" name="localorforeign" required>
                                        <option value="local">Local</option>
                                        <option value="foreign">Foreign</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-3">
                                <button class="btn btn-primary" type="submit">Create Bank Account</button>
                                <a href="{{ route('admin.bank-accounts.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const preview = document.getElementById('logoPreview');
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.style.display = 'block';
                preview.src = e.target.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
                preview.src = '#';
            }
        }
    </script>
@endsection
