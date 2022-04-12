<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chamber;

class ChamberController extends Controller
{
    //
    public function create(Request $request){

        $chamber = Chamber::create([
            'user_id'=>$request->user_id,
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'logo'=>$request->logo,
            'events'=>$request->events,
            'news'=>$request->news,

        ]);

        if($chamber){
            return $this->responseSuccess($chamber);
        }
        else{
            $message = "invalid request";
            return $this->responseFail($message);
        }
    }

    public function show(Request $request){
        // $chamber = Chamber::select('*')->where('user_id', '=', $request->user_id)->get();
        $chamber = Chamber::with('user')->where('user_id', '=', $request->user_id)->get();
        if($chamber){
            return $this->responseSuccess($chamber);
        }
        else{
            $message = "invalid request";
            return $this->responseFail($message);
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
            "status" => false,
            "data" => $data
        ],200);
    }

}
