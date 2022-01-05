@extends('layouts.customer')

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
            <a href="{{ route('customer_dashboard') }}" class="btn btn-info">Back To Dashboard</a>
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
                        <th scope="col">Item</th>
                        <th scope="col">Price</th>
                        <th scope="col">Qty.</th>
                        <th scope="col">Total</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody id="tableBody">
                        @foreach ($invoice as $item)
                        <tr>
                            <td>{{ $item->itemname }}</td>
                            <td>{{ $item->unitprice }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>{{ $item->total }}</td>
                            <td><button class="btn btn-danger" data-target="#removeModal{{ $item->id }}" data-toggle="modal"><i class="fas fa-trash"></i></button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr style="background: black">
                <div class="row">
                    <div class="col-lg-7"><h5>Grand Total: {{ $gtotal }}</h5></div>
                    <div class="col-lg-5">
                        <button data-target="#orderModal" data-toggle="modal" class="btn btn-success">Place Order</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="orderModalLabel">Place Order</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('customer_confirmorder') }}" id="orderForm" method="POST">
                @csrf
                <input type="hidden" name="invoiceno" value="{{ $invoiceno }}">
                <input type="hidden" name="gtotal" value="{{ $gtotal }}">
                <div class="form-group">
                    <label><b>Payment Method</b></label>
                    <select name="paymethod" class="custom-select" required>
                        <option value="" selected>--Select one Option--</option>
                        <option value="Bkash">Bkash</option>
                        <option value="Rocket">Rocket</option>
                        <option value="Nogod">Nogod</option>
                    </select>
                </div>
                <div class="form-group">
                    <label><b>Txn ID</b></label>
                    <input type="text" name="txnid" class="form-control" required>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="submit" form="orderForm" class="btn btn-success">Place Order</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

@foreach ($invoice as $item)
<div class="modal fade" id="removeModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="removeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="removeModalLabel">Delete {{ $item->itemname }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('customer_removeitem') }}" id="removeItemForm{{ $item->id }}" method="POST">
                @csrf
                <input type="hidden" name="invid" value="{{ $item->id }}">
                <input type="hidden" name="invoiceno" value="{{ $invoiceno }}">
                <h3>Are You Sure</h3>
            </form>
        </div>
        <div class="modal-footer">
          <button type="submit" form="removeItemForm{{ $item->id }}" class="btn btn-danger">Remove</button>
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
