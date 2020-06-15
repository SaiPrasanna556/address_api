<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Address;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class APIController extends Controller
{
    public function index($api_token){
        if($api_token)
            return view('client.addressess',compact('api_token'));
        else
            return response()->json(['Invalid API Token'],401);
    }

    public function saveAddress(Request $request){
        $api_token = $request->header('token');    
        $user = User::where('api_token','=',$api_token)->first();
        if($api_token != null && $user){
            $i = 0;
            foreach($request->get('address') as $value){                      
                $address = new Address();
                $address->address = $value;
                $address->type = $request->get('address_type'.$i);
                $address->user_id = $user->id ;
                $address->pincode = 0;
                $address->save();
                $i++;
            }
            return response()->json(['msg'=>'User address saved successfully'],200);
        }else{
            return response()->json(['msg'=>'Invalid Api Token'],401);
        }
    }

    public function login(Request $request){
        if(Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])){
            return response()->json(['api_token' => Auth::user()->api_token],200);
        }else{
            return response()->json(['message' => 'Invalid Credentials'],401);
        }
    }

    public function register(Request $request){
        $user = 
        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'api_token' => Str::random(20),
        ]);
        if($user){
            return response()->json(['api_token' => $user->api_token],200);
        }else{
            return response()->json(['message' => 'Please check all the fields are filled'],401);
        }
    }
}
