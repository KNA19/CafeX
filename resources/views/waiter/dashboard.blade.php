@extends('layouts.waiter')

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
    </div>
    <div class="row">
        <div class="col-md-12 p-3 text-center">
            <h3 class="animate__animated animate__bounce">Welcome {{ Auth()->user()->name }}, What Do You Want To Do</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 pt-3">
            <div class="card p-3 custom-shadow">
                <h4><b>Order List</b></h4>
                <table id="items" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Total</th>
                            <th>Pay Method</th>
                            <th>Txn ID</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->orderid  }}</td>
                            <td>{{ $item->gtotal }}</td>
                            <td>{{ $item->paymethod }}</td>
                            <td>{{ $item->txnid }}</td>
                            <td><button class="btn btn-info btn-block" data-target="#detailsModal{{ $item->orderid }}" data-toggle="modal">Details</button></td>
                            <td><button class="btn btn-primary btn-block" data-target="#confirmModal{{ $item->orderid }}" data-toggle="modal">Confirm</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach($data as $item)
<div class="modal fade" id="confirmModal{{ $item->orderid  }}" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addItemModalLabel">Confirm Order# {{ $item->orderid }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('waiter_confirm') }}" id="confirmForm{{ $item->orderid  }}" method="POST">
                @csrf
                <input type="hidden" value="{{ $item->orderid }}" name="orderid">
                <h3>Are You Sure?</h3>
            </form>
        </div>
        <div class="modal-footer">
          <button type="submit" form="confirmForm{{ $item->orderid  }}" class="btn btn-primary">Confirm</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="detailsModal{{ $item->orderid  }}" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addItemModalLabel">Order Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">Item Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Total</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                    @if($invoice->invoiceno == $item->invoiceno)
                  <tr>
                    <td>{{ $invoice->itemname }}</td>
                    <td>{{ $invoice->unitprice }}</td>
                    <td>{{ $invoice->qty }}</td>
                    <td>{{ $invoice->total }}</td>
                  </tr>
                  @endif
                  @endforeach
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
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
