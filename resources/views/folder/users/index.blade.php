@extends('folder.home')

@section('title', 'Dashboard')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row g-6 mb-6">
    <!-- Summary Cards -->
    <div class="col-sm-6 col-xl-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
              <span class="text-heading">Total Users</span>
              <div class="d-flex align-items-center my-1">
                <h4 class="mb-0 me-2">21,459</h4>
                <p class="text-success mb-0">(+29%)</p>
              </div>
              <small class="mb-0">Last week analytics</small>
            </div>
            <div class="avatar">
              <span class="avatar-initial rounded bg-label-primary">
                <i class="ti ti-users ti-26px"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Add other cards as needed -->
  </div>

  <!-- Users List Table -->
  <div class="card">
    <div class="card-header border-bottom">
      <h5 class="card-title mb-0">User List</h5>
    </div>
    <div class="card-datatable table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Title</th>
            <th>Availability</th>
            <th>Start Date</th>
            <th>Role</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $user)
          <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->title }}</td>
            <td>{{ $user->availability }}</td>
            <td>{{ $user->start_date }}</td>
            <td>{{ $user->role }}</td>
            <td>
              <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>
              <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="mt-3">
      {{ $users->links() }} <!-- Pagination -->
    </div>
  </div>

  <!-- Offcanvas to Add/Edit User -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser">
    <div class="offcanvas-header border-bottom">
      <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Add User</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 p-6">
      <form id="addNewUserForm" method="POST" action="{{ route('users.store') }}">
        @csrf
        <div class="mb-3">
          <label for="name" class="form-label">Full Name</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="John Doe" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="john.doe@example.com" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="******" required>
        </div>
        <div class="mb-3">
          <label for="title" class="form-label">Title</label>
          <input type="text" class="form-control" id="title" name="title" placeholder="Manager">
        </div>
        <div class="mb-3">
          <label for="availability" class="form-label">Availability</label>
          <input type="text" class="form-control" id="availability" name="availability" placeholder="Full-Time">
        </div>
        <div class="mb-3">
          <label for="start_date" class="form-label">Start Date</label>
          <input type="date" class="form-control" id="start_date" name="start_date">
        </div>
        <div class="mb-3">
          <label for="role" class="form-label">Role</label>
          <input type="text" class="form-control" id="role" name="role" placeholder="Admin">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancel</button>
      </form>
    </div>
  </div>
</div>

@endsection
