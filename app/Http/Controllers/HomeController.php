<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\User;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return redirect('login');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function waiterlist()
    {
        $data = DB::table('users')->where('role', 'waiter')->get();
        return view('waiterlist', ['data'=>$data]);
    }

    public function addwaiter(Request $request)
    {
        try
        {
            if($request->pass1 == $request->pass2)
            {
                $user = new User;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = bcrypt($request->pass1);
                $user->role = 'waiter';
                $user->save();
                return redirect(route('waiterlist'))->with('success', 'Waiter Added Successfully');
            }
            else
            {
                return redirect(route('waiterlist'))->with('failed', 'Both Password Should Match');
            }

        }
        catch(Exception $e)
        {
            return redirect(route('waiterlist'))->with('failed', 'Operation Error !!!');
        }
    }

    public function removewaiter(Request $request)
    {
        try
        {
            DB::table('users')->where('id',$request->uid)->delete();
            return redirect(route('waiterlist'))->with('success', 'Waiter Deleted Successfully');

        }
        catch(Exception $e)
        {
            return redirect(route('waiterlist'))->with('failed', 'Operation Error !!!');
        }
    }
}
