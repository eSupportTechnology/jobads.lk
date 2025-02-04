@extends('layouts.admin.master')

@section('title', 'Package Durations')

@section('css')
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatable-extension.css') }}">
    <style>
        .icon-fixed-size {
            width: 16px;
            height: 16px;
            font-size: 16px;
            line-height: 16px;
            display: inline-block;
            text-align: center;
        }

        .custom-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 12px;
            font-size: 14px;
            border-radius: 4px;
            text-transform: uppercase;
            font-weight: bold;
            min-width: 100px;
            height: 36px;
            margin: 0 4px;
            transition: all 0.3s ease;
        }

        .custom-btn i {
            font-size: 16px;
            margin-right: 6px;
        }

        .custom-btn-warning {
            background-color: #ffc107;
            color: #fff;
            border: 1px solid #ffc107;
        }

        .custom-btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }

        .custom-btn-danger {
            background-color: #dc3545;
            color: #fff;
            border: 1px solid #dc3545;
        }

        .custom-btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

       
    </style>
@endsection

@section('breadcrumb-title')
    <h3>Package Durations</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Dashboard</li>
    <li class="breadcrumb-item active">Package Durations</li>
@endsection

@section('content')
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Durations</h5>
                        
                    </div>
                    <div class="card-body">
                        <div class="dt-ext table-responsive">
                            <table class="display" id="countries-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Type</th>
                                        <th>Duration</th>
                                        <th class="actions-column">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($durations as $duration)
                                        <tr>
                                            <td>{{ $duration->id }}</td>
                                            <td>{{ $duration->type }}</td>
                                            <td>{{ $duration->duration }}</td>
                                            <td class="actions-column">
                                                <a href="{{route('durations.edit',$duration)}}"
                                                    class="btn custom-btn custom-btn-warning">
                                                    <i class="icon-pencil-alt icon-fixed-size"></i> Edit
                                                </a>
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
    <script>
        $(document).ready(function() {
            $('#countries-table').DataTable({
                responsive: true,
                pageLength: 10,
                order: [
                    [0, 'asc']
                ],
                columnDefs: [{
                    targets: [-1],
                    orderable: false
                }]
            });
        });
    </script>
@endsection
