<?php

namespace App\Http\Controllers;

use App\Http\Resources\BillResource;
use App\Models\Bill;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    function view_bills()
    {
        $user = auth()->user();
        if($user->is_admin == 1)
        {
            $pagination =Bill::orderBy('created_at', 'desc')->paginate(10);
            return BillResource::collection($pagination);
        }
        else
        {
            return response()->json(['message'=>'you are not admin']);
        }
    }
    function update(Request $request,$id)
    {
        $bill = Bill::find($id);
        if($request->data=='accept')
        {
            $bill->status=$request->data;
            $bill->save();
            return response()->json(['message'=>'update successful']);
        }
        elseif($request->data=='reject')
        {
            $bill->status=$request->data;
            $bill->save();
            return response()->json(['message'=>'update successful']);
        }
        else
        {
            return response()->json(['message'=>'Bill not found']);
        }
    }
}
