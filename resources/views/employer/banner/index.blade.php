@extends('layouts.employer.master')

@section('title', 'Jobs')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatable-extension.css') }}">

@endsection

@section('css')
    <style>
        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            border: none;
            background-color: transparent;
            cursor: pointer;
        }

        .btn-action i {
            font-size: 16px;
            /* Adjust size as needed */
            color: #333;
            /* Ensure visible color */
        }

        .btn-delete {
            color: red;
        }

        .btn-toggle-active {
            color: green;
        }

        .btn-toggle-inactive {
            color: gray;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="mb-0">Banners</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="dt-ext table-responsive">
                            @if ($banners->count() > 0)
                                <table class="display" id="keytable">
                                    <thead>
                                        <tr>
                                            <th>Banner ID</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Package</th>
                                            <th>Reviewed By</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($banners as $banner)
                                            <tr>
                                                <td>#{{ $banner->id }}</td>
                                                <td>{{ $banner->title }}</td>
                                                <td>
                                                    <div class="d-flex flex-column gap-1">
                                                        <small
                                                            class="text-muted">{{ $banner->category ? $banner->category->name : '' }}</small>
                                                        <small class="text-muted">{{ ucfirst($banner->placement) }}</small>

                                                    </div>
                                                </td>
                                                <td>{{ $banner->package->duration ?? 'N/A' }}</td>
                                                <td>{{ $banner->admin->name ?? 'N/A' }}</td>
                                                <td>
                                                    {{ $banner->status ?? 'N/A' }}
                                                </td>

                                                <td>
                                                    <div class="action-buttons">

                                                        @if ($banner->status == 'pending')
                                                            <!-- Edit Button -->
                                                            <a href="{{ route('empbanners.edit', $banner->id) }}"
                                                                class="btn-action btn-edit" title="Edit Job">
                                                                <i class="icon-pencil-alt"></i>
                                                            </a>
                                                        @else
                                                            <a href="#" class="btn-action btn-edit disabled"
                                                                title="Edit Job" tabindex="-1" aria-disabled="true">
                                                                <i class="icon-pencil-alt"></i>
                                                            </a>
                                                        @endif



                                                        <!-- Delete Button -->
                                                        {{-- <form
                                                            action="{{ route('employer.job_postings.post.destroy', $job->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class=" btn-action btn-delete"
                                                                title="Delete Job"
                                                                onclick="return confirm('Are you sure you want to delete this job posting?');">
                                                                <i class="icon-trash"></i>
                                                            </button>
                                                        </form>

                                                        <!-- Toggle Active/Inactive Button -->
                                                        <form action="{{ route('job_postings.toggle_active', $job->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit"
                                                                class="btn-action {{ $job->is_active ? 'btn-toggle-active' : 'btn-toggle-inactive' }}"
                                                                title="{{ $job->is_active ? 'Mark as Inactive' : 'Mark as Active' }}">
                                                                <i class="icon-receipt"></i>
                                                            </button>
                                                        </form> --}}
                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center py-4">
                                    <p class="text-gray-500">You haven't created any job postings yet.</p>
                                    <a href="{{ route('employer.job_postings.create') }}" class="btn btn-primary mt-3">
                                        Create Your First Job Posting
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.responsive.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#keytable').DataTable({
                responsive: true,
                order: [
                    [0, 'desc']
                ],
                pageLength: 10,
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                },
                columnDefs: [{
                        orderable: false,
                        targets: -1
                    } // Disable sorting on action column
                ]
            });
        });
    </script>
@endsection

@section('script')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.autoFill.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.colReorder.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.rowReorder.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.scroller.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/custom.js') }}"></script>
@endsection
