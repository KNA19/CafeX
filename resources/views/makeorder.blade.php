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
            <h3>Invoice# {{ $invoiceno }}</h3>
        </div>
        <div class="col-lg-7 pt-3">
            <div class="card p-3 custom-shadow">
                <h4><b>Item List</b></h4>
                <hr>
                <table id="items" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->price }}</td>
                            <td><button class="btn btn-primary btn-block" data-target="#addItemModal{{ $item->itemid }}" data-toggle="modal">Add</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-5 pt-3">
            <div class="card p-4 custom-shadow">
                <h4><b>Added Items</b></h4>
                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">Item Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Total</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody id="tableBody">
                      <tr>
                        <td colspan="5">No Items Added Yet</td>
                      </tr>
                    </tbody>
                </table>
                <hr style="background: black">
                <div class="row">
                    <div class="col-lg-5"><h5>Grand Total: 0</h5></div>
                    <div class="col-lg-7"><button class="btn btn-success" disabled>Place Order</button></div>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($data as $item)
<div class="modal fade" id="addItemModal{{ $item->itemid }}" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addItemModalLabel">Quantity of {{ $item->name }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('makeDraft') }}" id="addItemForm{{ $item->itemid }}" method="POST">
                @csrf
                <input type="hidden" name="invoiceno" value="{{ $invoiceno }}">
                <input type="hidden" name="itemid" value="{{ $item->itemid }}">
                <input type="hidden" name="itemname" value="{{ $item->name }}">
                <input type="hidden" name="unitprice" value="{{ $item->price }}">
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" name="qty" class="form-control" required>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="submit" form="addItemForm{{ $item->itemid }}" class="btn btn-primary">Add Item</button>
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
