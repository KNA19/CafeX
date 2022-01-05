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
        <div class="col-lg-4 pt-3">
            <div class="card p-4 custom-shadow">
                <h4><b>Add New Item</b></h4>
                <hr>
                <form method="POST" action="{{ route('saveItem') }}">
                    @csrf
                    <div class="form-group">
                        <label>Item Name</label>
                        <input type="text" name="name" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Item Price</label>
                        <input type="number" name="price" required class="form-control">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-8 pt-3">
            <div class="card p-3 custom-shadow">
                <h4><b>Item List</b></h4>
                <hr>
                <table id="items" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->price }}</td>
                            <td><button class="btn btn-warning btn-block" data-target="#EditModal{{ $item->itemid }}" data-toggle="modal">Edit</button></td>
                            <td><button class="btn btn-danger btn-block" data-target="#DeleteModal{{ $item->itemid }}" data-toggle="modal">Delete</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach ($data as $item)
<div class="modal fade" id="DeleteModal{{ $item->itemid }}" tabindex="-1" aria-labelledby="DeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="DeleteModalLabel">Delete Item</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('deleteItem') }}" method="POST" id="deleteForm{{ $item->itemid }}">
                @csrf
                <input type="hidden" name="itemid" value="{{ $item->itemid }}">
                <h3>Are You Sure?</h3>
            </form>
        </div>
        <div class="modal-footer">
          <button type="submit" form="deleteForm{{ $item->itemid }}" class="btn btn-danger">Delete</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
<div class="modal fade" id="EditModal{{ $item->itemid }}" tabindex="-1" aria-labelledby="EditModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="EditModalLabel">Edit Item</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('editItem') }}" method="POST" id="editForm{{ $item->itemid }}">
                @csrf
                <input type="hidden" name="itemid" value="{{ $item->itemid }}">
                <div class="form-group">
                    <label>Item Name</label>
                    <input class="form-control" type="text" name="name" value="{{ $item->name }}">
                </div>
                <div class="form-group">
                    <label>Item Price</label>
                    <input class="form-control" type="number" name="price" value="{{ $item->price }}">
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="submit" form="editForm{{ $item->itemid }}" class="btn btn-primary">Save changes</button>
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
