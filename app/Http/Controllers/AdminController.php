<?php

namespace App\Http\Controllers;

use App\Http\Resources\BillResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\Bill;
use App\Models\User;
use App\Notifications\FcmNotification;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    function view_bills()
    {
        $user = auth()->user();
        if ($user->is_admin == 1) {
            $pagination = Bill::orderBy('created_at', 'desc')->paginate(6);
            return BillResource::collection($pagination);
        } else {
            return response()->json(['message' => 'you are not admin']);
        }
    }
    function update(Request $request, $id)
    {
        $bill = Bill::find($id);
        $request->validate([
            'data' => 'required|in:Accepted,Rejected'
        ]);
        if (!$bill) {
            return response()->json(['message' => 'Bill not found']);
        }
        $bill->update([
            'status' => $request->data,
            'feedback'=>$request->feedback
        ]);
        $user= $bill->user;
        // $this->sendNotification($user);
        return response()->json(['message' => 'update successful']);
    }
    function all_user()
    {
       $users = User::paginate(6);
        // dd($users);
        // return $users->links()
        $users = UserResource::collection($users);
        return apiSuccessResponse($users, 'User list fetched successfully');
    }

    public function sendNotification($user)
    {
        $deviceToken =$user->FCM_token;
        $title = 'Welcome';
        $message = 'Hello test message';
        $notification = new FcmNotification($title, $message, $deviceToken);
        $notification->toFcm(null);
        return response()->json(['status' => 'Notification Sent']);
    }
}
