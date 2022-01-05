<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Invoice;
use App\ConfirmOrder;
use Exception;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $data = DB::table('items')->get();
        $invoiceno = date('dmYhis');
        return view('customer.dashboard', ['data'=>$data, 'invoiceno'=>$invoiceno]);
    }

    public function makedraft(Request $request)
    {
        try
        {
            //dd($request->input());
            $total = $request->unitprice * $request->qty;

            $inv = new Invoice;
            $inv->invoiceno = $request->invoiceno;
            $inv->itemid = $request->itemid;
            $inv->itemname = $request->itemname;
            $inv->unitprice = $request->unitprice;
            $inv->qty = $request->qty;
            $inv->total =$total;
            $inv->save();

            return redirect(route('customer_addorder', $request->invoiceno))->with('success', 'Item Added Successfully');
        }
        catch(Exception $e)
        {
            dd($e);
            return redirect(route('customer_addorder', $request->invoiceno))->with('failed', 'Operation Error !!');
        }
    }

    public function removeitem(Request $request)
    {
        try
        {
            //dd($request->input());
            DB::table('invoices')->where('id', $request->invid)->delete();
            return redirect(route('customer_addorder', $request->invoiceno))->with('success', 'Item Deleted Successfully');
        }
        catch(Exception $e)
        {
            dd($e);
            return redirect(route('customer_addorder', $request->invoiceno))->with('failed', 'Operation Error !!');
        }
    }

    public function addorder($invno)
    {
        $data = DB::table('items')->get();
        $invoice = DB::table('invoices')->where('invoiceno', $invno)->get();
        $gtotal = DB::table('invoices')->where('invoiceno', $invno)->sum('total');
        return view('customer.addorder', ['data'=>$data, 'invoiceno'=>$invno,'invoice'=>$invoice, 'gtotal'=>$gtotal]);
    }

    public function confirmorder(Request $request)
    {
        try
        {
            $today = date('Y-m-d');
            $order = new ConfirmOrder;
            $order->invoiceno = $request->invoiceno;
            $order->gtotal = $request->gtotal;
            $order->invoicedate = $today;
            $order->status = 'pending';
            $order->paymethod = $request->paymethod;
            $order->txnid = $request->txnid;
            $order->cid = Auth()->user()->id;
            $order->save();
            return redirect(route('customer_printcopy', $request->invoiceno));
        }
        catch(Exception $e)
        {
            return redirect(route('customer_addorder', $request->invoiceno))->with('failed','Operation Error !!!');
        }
    }

    public function printcopy($invno)
    {
        $data = DB::table('invoices')->where('invoiceno', $invno)->get();
        $gtotal = DB::table('invoices')->where('invoiceno', $invno)->sum('total');
        $order = DB::table('confirmorders')->where('invoiceno', $invno)->get()->first();
        return view('customer.printcopy',['data'=>$data, 'gtotal'=>$gtotal, 'order'=>$order]);
    }

    public function pendingorder()
    {
        $data = DB::table('confirmorders')->where(['status'=>'pending', 'cid'=>Auth()->user()->id])->get();
        return view('customer.pendingorder', ['data'=>$data]);
    }
}
