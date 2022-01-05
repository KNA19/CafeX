@extends('layouts.customer')

@section('content')
<div class="container">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12 p-3 text-center">
            <h3 class="animate__animated animate__bounce">Welcome {{ Auth()->user()->name }}, What Do You Want To Do</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-7 pt-3">
            <a href="{{ route('customer_pendingorder') }}" class="btn btn-info">Pending Orders</a>
        </div>
        <div class="col-lg-7 pt-3">
            <div class="card p-3 custom-shadow">
                <h4><b>Item Menu</b></h4>
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
                        <th scope="col">Item</th>
                        <th scope="col">Price</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Total</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody id="tableBody">
                        <p>No Item Added Yet</p>
                    </tbody>
                </table>
                <hr style="background: black">
                <div class="row">
                    <div class="col-lg-7"><h5>Grand Total: 0</h5></div>
                    <div class="col-lg-5">
                        <button disabled class="btn btn-success">Place Order</button>
                    </div>
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
            <form action="{{ route('customer_makedraft') }}" id="addItemForm{{ $item->itemid }}" method="POST">
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
