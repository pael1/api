<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\customizeUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Authcontroller extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|max:100',
            'confirm_password'=>'required|same:password'
        ]);

        if($validator->fails()){
            return response()->json([
                'message'=>'Validation failes', 
                'errors'=>$validator->errors()
            ], 422);
        }

        $user = customizeUser::create([
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);

        return response()->json([
            'message'=>'registration successful',
            'data'=>$user
        ], 200);
        
    }
}
