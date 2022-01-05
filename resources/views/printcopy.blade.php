<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="{{ asset('js/jquery-3.5.1.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}" />

    <title>CafeX | Print Invoice</title>

    <style>
        body {
            background: #eee
        }
    </style>

  </head>
  <body>
    <div class="container mt-5" id="focusDiv">
        <div class="d-flex justify-content-center row">
            <div class="col-md-8" id="printarea">
                <div class="p-3 bg-white rounded">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="text-uppercase">Invoice</h1>
                            <div class="billed"><span class="font-weight-bold text-uppercase">Date:</span><span class="ml-1">{{ date("F j, Y", strtotime($order->invoicedate)) }}</span></div>
                            <div class="billed"><span class="font-weight-bold text-uppercase">Invoice# </span><span class="ml-1">{{ $order->invoiceno }}</span></div>
                        </div>
                        <div class="col-md-6 text-right mt-3">
                            <h4 class="text-danger mb-0">Cafe<span style="color: white;background: linear-gradient(#eee, #333);background-clip: text;text-fill-color: transparent;">X</span></h4><span>www.cafex.com</span>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $item)
                                    <tr>
                                        <td>{{ $item->itemname }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>{{ $item->unitprice }}</td>
                                        <td>{{ $item->total }}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>Total</td>
                                        <td>{{ $gtotal }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-center mb-3"><span class="bg-info text-white btn-sm mr-5">Thank You For Kind Cooperation</span></div>
                </div>
            </div>
            <div class="col-lg-8 pt-2">
                <div class="row">
                    <div class="col-lg-6">
                        <button class="btn btn-primary btn-block" id="btnPrint">Print</button>
                    </div>
                    <div class="col-lg-6">
                        <a href="{{ route('dashboard') }}" class="btn btn-warning btn-block" id="btnBack">Back To Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>

    <script>
        $('#btnPrint').click(function(){
            $("#printarea").show();
            $("#btnPrint").hide();
            $("#btnBack").hide();
            window.print();
            location.reload();
        });

    </script>

  </body>
</html>
