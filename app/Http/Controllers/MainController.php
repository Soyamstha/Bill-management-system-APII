<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;

class MainController extends Controller
{
    function add_bill(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'bill_name'=>'required|string|max:255',
            'description'=>'required|string|max:255',
            'photo'=>'required|file',
        ]);
        $photo =$request->photo;
        $bills = $user->Bill()->create([
            'user_id'=>$user->id,
            'bill_name'=> $request->bill_name,
            'description'=> $request->description,
            'status'=>'pending',
        ]);
        // dd($photo);
        $bills->addMedia($photo)->toMediaCollection('preview');
        return response()->json(['message' => 'Bill added successfully'], 201);
    }
}
