<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Community;
use Carbon\Carbon;
use DB;

class CommunityController extends Controller
{
    //
    public function addMessage(Request $request){
        $message = new Community();
        

        $message = Community::create([
            'user_id'=>$request->user_id,
            'message'=>$request->message,
            'date'=>$request->date,
            
        ]);

        if($message){
            return $this->responseSuccess($message);
        }
        else{
            $error = "invalid request";
            return $this->responseFail($error);
        }

    }


    public function showMessages(Request $request){
        $message = DB::table('users')
        ->join('communities', 'users.id', '=', 'communities.user_id')
        ->select('users.name','communities.user_id', 'communities.message')
        ->get();

        if($message){
            return $this->responseSuccess($message);
        }
        else{
            $error = "invalid request";
            return $this->responseFail($error);
        }
    }


    public function responseFail($message){
        return response()->json([
            "status" => false,
            "message" => $message
        ],422);
    }

    public function responseSuccess($data){
        return response()->json([
            "status" => true,
            "data" => $data
        ],200);
    }
}
