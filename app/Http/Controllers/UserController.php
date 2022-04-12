<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Carbon\Carbon;
use DB;
use Mail;
use Str;
use Hash;


class UserController extends Controller
{
    // Registration

    public function register(Request $request){
        $apiToken = Str::random(60);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'token'=>$apiToken,
            'password'=>Hash::make($request->password),
        ]);

        if($user){
            $message = "User Registered Successfully";
            return $this->responseSuccess($user,$message);
        }
        else{
            return $this->responseFail();
        }
    }

    // Login

    public function login(Request $request){
        $userExist = User::where('email',$request->email)->first();

        if($userExist){

            if(password_verify($request->password,$userExist->password)){
                $apiToken = Str::random(60);
                User::where('email',$request->email)->update(['token'=>$apiToken]);
                $userDetails = User::where('email',$request->email)->first();

                $message = 'User Logged in Successfully';

                return $this->responseSuccess($userDetails,$message);
                
            }
            else{
                return $this->responseFail();
            }
        }
        else{
            return $this->responseFail();
        }
    }

    // Forgot Password
    public function forgotpassword(Request $request){

        $userExist = User::where('email',$request->email)->first();

        if($userExist){
            $message = "Email Exist";
            return $this->responseSuccess($userExist,$message);
        }
        // $token = Str::random(64);
        // DB::table('password_resets')->insert([
        //     'email' => $request->email,
        //     'token' => $token,
        //     'created_at' => Carbon::now()
        // ]);



    

    }



// Response Fail Function
    public function responseFail(){
        return response()->json([
            'status'=>false,
            'message'=>'Invalid Request',
            
        ],422);
    }



// Response Success Function
    public function responseSuccess($data,$message){
        return response()->json([
            'status'=>true,
            'message'=>$message,
            'data'=>$data,
            
        ],200);
    }
}
