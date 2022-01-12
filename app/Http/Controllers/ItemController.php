<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Item;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function items()
    {
        $data = DB::table('items')->get();
        return view('items',['data'=>$data]);
    }

    public function saveitem(Request $request)
    {
        try
        {
            //dd($request->input());
            $item = new Item;
            $item->name = $request->name;
            $item->price = $request->price;
            $item->save();
            return redirect(route('items'))->with('success', 'Item Added Successfully');
        }
        catch(Exception $e)
        {
            return redirect(route('items'))->with('failed', 'Operation Error !!!');
        }
    }

    public function edititem(Request $request)
    {
        try
        {
            DB::table('items')->where('itemid', $request->itemid)->update([
                'name'=>$request->name,
                'price'=>$request->price
            ]);
            return redirect(route('items'))->with('success', 'Item Edited Successfully');
        }
        catch(Exception $e)
        {
            return redirect(route('items'))->with('failed', 'Operation Error !!!');
        }
    }

    public function deleteitem(Request $request)
    {
        try
        {
            DB::table('items')->where('itemid', $request->itemid)->delete();
            return redirect(route('items'))->with('success', 'Item Edited Successfully');
        }
        catch(Exception $e)
        {
            return redirect(route('items'))->with('failed', 'Operation Error !!!');
        }
    }
}
