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
        <div class="col-lg-3 pt-3">
            <div class="card p-3">
                <label>Select A Date</label>
                <input type="date" name="selectdate" class="form-control" id="inpDate" required>
                <button class="btn btn-primary mt-3" id="search">Search</button>
            </div>
        </div>
        <div class="col-lg-6 pt-3">
            <div class="card p-3">
                <h3>Total: {{ $gtotal }}</h3>
            </div>
        </div>
        <div class="col-lg-12 pt-3">
            <div class="card p-3 custom-shadow">
                <table id="items" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Invoice No</th>
                            <th>Date</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->invoiceno }}</td>
                            <td>{{ date("F j, Y", strtotime($item->invoicedate)) }}</td>
                            <td>{{ $item->gtotal }}</td>
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

    $('#search').click(function(){
        var dt = $('#inpDate').val();
        window.location.replace('/admin/account/'+dt);
    });

</script>

@endsection
