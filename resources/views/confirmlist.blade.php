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
            <h3>Confirmed Order List</h3>
        </div>
        <div class="col-lg-12 pt-3">
            <div class="card p-3 custom-shadow">
                <table id="items" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Invoice No</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->invoiceno }}</td>
                            <td>{{ date("F j, Y", strtotime($item->invoicedate)) }}</td>
                            <td>{{ $item->gtotal }}</td>
                            <td><button class="btn btn-primary btn-block" data-target="#detailsModal{{ $item->orderid }}" data-toggle="modal">Details</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach($data as $item)
<div class="modal fade" id="detailsModal{{ $item->orderid }}" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="detailsModalLabel">Invoice Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            @php
                $n = 1;
            @endphp
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Item</th>
                        <th scope="col">Price</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                        @if($item->invoiceno == $invoice->invoiceno)
                            <tr>
                                <th scope="row">{{ $n }}</th>
                                <td>{{ $invoice->itemname }}</td>
                                <td>{{ $invoice->unitprice }}</td>
                                <td>{{ $invoice->qty }}</td>
                                <td>{{ $invoice->total }}</td>
                            </tr>
                            @php
                                $n++;
                            @endphp
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
