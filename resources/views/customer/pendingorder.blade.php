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
            <a href="#" class="btn btn-info">Pending Orders</a>
        </div>
        <div class="col-lg-12 pt-3">
            <div class="card p-3 custom-shadow">
                <h4><b>Item Menu</b></h4>
                <table id="items" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>INV No</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->invoiceno }}</td>
                            <td>{{ $item->gtotal }}</td>
                            <td>{{ $item->invoicedate }}</td>
                            <td><a target="_blank" href="{{ route('customer_printcopy', $item->invoiceno) }}" class="btn btn-primary btn-block" >View Invoice</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#items').DataTable();
    });
</script>

@endsection
