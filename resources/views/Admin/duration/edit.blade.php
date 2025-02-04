@extends('layouts.admin.master')

@section('title', 'Update Package Durations')

<head>
    
</head>

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Update Package Durations</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('durations.update', $duration) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                <label for="duration">Duration</label>
                                <input type="text" name="duration" class="form-control" value="{{  $duration->duration }}" required>
                            </div>

                           

                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

</script>
@endsection