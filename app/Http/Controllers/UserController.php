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
use Validator;

class UserController extends Controller
{
    // Registration

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
        ]);

        if ($validator->fails()) {
            $message = "Email already exist";
            return $this->responseFail($message);
        }

        else{
            $apiToken = Str::random(60);
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'token'=>$apiToken,
                'type'=>$request->type,
                'password'=>Hash::make($request->password),
            ]);
                $message = "User Registered Successfully";
                return $this->responseSuccess($user,$message);
            
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
                $message = "Invalid Password";
                return $this->responseFail($message);
            }
        }
        else{
            $message = "Invalid Email";
            return $this->responseFail($message);
        }
    }

    // Forgot Password
    public function forgotpassword(Request $request){

        $userExist = User::where('email',$request->email)->first();

        if($userExist){
            $randomNumber = random_int(100000, 999999);

            DB::table('password_resets')->insert([
                'email' => $request->email,
                'otpcode' => $randomNumber,
                'created_at' => Carbon::now()
            ]);

            $message = "Email Exist";
            return $this->responseSuccess($randomNumber,$message);
        }
        else{
            $message = "Invalid Email";
            return $this->responseFail($message);
        }


    }

    // UpdatePassword

    public function updatePassword(Request $request){
        $email = DB::table('password_resets')->select('email')->where('otpcode', '=', $request->otpcode)->get();
        // ->toArray();
        if(count($email)){
            $user = User::where('email','=',$email[0]->email)->first();
            $message = "Email Exist";
            return $this->responseSuccess($user,$message);
        }else{
            $message = "Invalid OTP Code";
            return $this->responseFail($message);
        }
    }


    // reset password
    public function resetPassword(Request $request){
        $user = User::find($request->id);

        if($user){
            $user->password = Hash::make($request->password);
            $user->save();

            $message = "Password Updated Successfully";
            return $this->responseSuccess($user,$message);

        }else{
            $message = "Invalid Request";
            return $this->responseFail($message);
        }
    }

    // Update Profile
    public function profileUpdate(Request $request){
        $user = User::find($request->id);

        if($user){
            if(password_verify($request->oldpassword,$user->password)){
                $user->name = $request->name;
                $user->email = $request->email;
                $user->phone = $request->phone;
                $user->password = Hash::make($request->newpassword);
                $user->save();

                $message = "Profile Updated Successfully";
                return $this->responseSuccess($user,$message);
            }
            else{
                $user->name = $request->name;
                $user->email = $request->email;
                $user->phone = $request->phone;
                $user->save();
                $message = "Profile Updated Successfully";
                return $this->responseSuccess($user,$message);
            }
        } else{
            $message = "User id not found";
            return $this->responseFail($message);
        }
    }



// Response Fail Function
    public function responseFail($message){
        return response()->json([
            'status'=>false,
            'message'=>$message,
            
        ],200);
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
