<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Notifications\emailsent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

class UserController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['message'] =  'User successfully registered';
        Notification::send($user, new emailsent($user));
        return response()->json(['success' => $success], 201);
    }

    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('name')->accessToken;
            return response()->json(['access_token' => $success], 201);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function placeOrder(Request $request)
    {
        $id = $request->id;
        $qty = $request->qty;
        $data = Product::find($id);
        $stocks = $data->stock - $qty;

        if($data->stock < $qty){
            return response()->json(['message' => 'Failed to order this product due to unavailability of the stock'], 400);
        }

        Product::where('id', $id)->update(['stock' => $stocks]);
        return response()->json(['message' => 'You have successfully ordered this product.'], 201);
    }
}
