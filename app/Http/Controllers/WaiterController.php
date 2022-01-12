<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WaiterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $data = DB::table('confirmorders')->where('status', 'pending')->get();
        $invoices = DB::table('invoices')->get();
        return view('waiter.dashboard', ['data'=>$data, 'invoices'=>$invoices]);
    }

    public function confirm(Request $request)
    {
        try
        {
            //dd($request->input());
            DB::table('confirmorders')->where('orderid', $request->orderid)->update(['status'=>'approved']);
            return redirect(route('waiter_dashboard'))->with('success', 'Order Confirmed');
        }
        catch(Exception $e)
        {
            dd($e);
            return redirect(route('waiter_dashboard'))->with('failed', 'Operation Error !!!');
        }
    }
}
