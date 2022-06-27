<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /** 
         * login api 
         * 
         * @return \Illuminate\Http\Response 
         */ 
        public function login(){ 
            if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
                $user = Auth::user(); 
                $success['token'] =  $user->createToken('MyApp')-> accessToken; 
                return response()->json(['access_token' => $success], 200); 
            } 
            else{ 
                return response()->json(['message'=>'Invalid credentials'], 401)->middleware('throttle:login'); 
            } 
        }
    /** 
         * Register api 
         * 
         * @return \Illuminate\Http\Response 
         */ 
        public function register(Request $request) 
        { 
            $validator = Validator::make($request->all(), [ 
                'name' => 'required', 
                'email' => 'required|email|unique:users,email', 
                'password' => 'required', 
                'c_password' => 'required|same:password', 
            ]);
            if ($validator->fails()) { 
                        return response()->json(['error'=>$validator->errors()], 401);            
                    }

            $input = $request->all(); 
                    $input['password'] = bcrypt($input['password']); 
                    $user = User::create($input); 
                    $success['token'] =  $user->createToken('MyApp')-> accessToken; 
                    $success['name'] =  $user->name;
                    $success['message'] =  'User successfully registered';
            return response()->json(['success'=>$success], 201); 
        }

        public function placeOrder(Request $request)
        {
            $id = $request->id;
            $qty = $request->qty;
            // $data = Product::find($id);
            return response()->json(['success'=>$qty], 201); 
        }

}
