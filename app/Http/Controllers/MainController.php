<?php

namespace App\Http\Controllers;

use App\Http\Resources\BillResource;
use App\Models\Bill;
use Illuminate\Http\Request;

class MainController extends Controller
{
    function add_bill(Request $request)
    {
        // dd($request->photo);
        $user = auth()->user();
        $request->validate([
            'bill_name'=>'required|string|max:255',
            'description'=>'required|string|max:255',
            'photo'=>'required|array',
            'photo.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        $photo =$request->photo;
        $bills = $user->Bill()->create([
            'user_id'=>$user->id,
            'bill_name'=> $request->bill_name,
            'description'=> $request->description,
            'status'=>'pending',
        ]);
        // dd($photo);
        foreach ($request->file('photo') as $photo)
        {
            $bills->addMedia($photo)->toMediaCollection('preview');
        }
        return response()->json(['message' => 'Bill added successfully'], 201);
    }
    function view_user_bills()
    {
        $user = auth()->user();
        $bills= Bill::where('user_id', $user->id)->orderBy('updated_at', 'desc')->paginate(10);
        if(!$bills)
        {
            return response()->json(['message' => 'your bills are empty.Try adding bills']);
        }
        return BillResource::collection($bills);
    }
}
