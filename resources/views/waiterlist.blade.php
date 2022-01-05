@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (session('failed'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ session('failed') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
        <div class="col-lg-12 pb-3">
            <a href="{{ route('dashboard') }}" class="btn btn-info">Back To Dashboard</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 pt-3">
            <h3>Waiter Management</h3>
        </div>
        <div class="col-lg-4 pt-3">
            <div class="card p-3 custom-shadow">
                <form action="{{ route('addWaiter') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="pass1" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="pass2" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Save User</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-8 pt-3">
            <div class="card p-3 custom-shadow">
                <table id="items" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Waiter Name</th>
                            <th>Email</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td><button class="btn btn-danger btn-block" data-target="#deleteModal{{ $item->id }}" data-toggle="modal">Delete</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach($data as $item)
<div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Invoice Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('removeWaiter') }}" method="POST" id="deleteForm{{ $item->id }}">
                @csrf
                <input type="hidden" name="uid" value="{{ $item->id }}">
                <h3>Are You Sure?</h3>
            </form>
        </div>
        <div class="modal-footer">
          <button type="submit" form="deleteForm{{ $item->id }}" class="btn btn-danger">Delete</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
@endforeach


<script>
    $(document).ready(function() {
        $('#items').DataTable();
    });
</script>

@endsection
