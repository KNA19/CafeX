<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function account($date = null)
    {
        $gtotal = DB::table('confirmorders')->where('invoicedate', $date)->sum('gtotal');
        $data = DB::table('confirmorders')->where('invoicedate', $date)->get();
        return view('accounts',['data'=>$data, 'gtotal'=>$gtotal]);
    }
}
