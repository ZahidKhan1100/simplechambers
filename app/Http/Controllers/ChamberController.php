<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Chamber;
use Str;

class ChamberController extends Controller
{
    //
    public function create(Request $request){

        // $logo = base64_decode($request->logo);
        $image_64 = $request->logo;
        $extension = explode(';base64',$image_64);
        $extension = explode('/',$extension[0]);
        $extension = $extension[1];
        $replace = substr($image_64, 0, strpos($image_64, ',')+1);
        $image = str_replace($replace, '', $image_64);
        $image = str_replace(' ', '+', $image);
        $imageName = time().'_'.Str::random(20).'.'.$extension;

        // $name = $request->file('image')->getClientOriginalName();
        // $path = $request->file('image')->storeAs('public/images/',$name);

        Storage::disk('local')->put($imageName, base64_decode($image));

        $chamber = Chamber::create([
            'user_id'=>$request->user_id,
            'name'=>$request->name,
            'logo'=>$imageName,
            'zip'=>$request->zip,
            'state'=>$request->state,

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
        // $chamber = Chamber::with('user')->where('user_id', '=', $request->user_id)
        $chamber = Chamber::Where('name', 'LIKE', '%'.$request->name.'%')
        ->orWhere('state', 'LIKE', '%'.$request->state.'%')
        ->orWhere('zip', 'LIKE', '%'.$request->zip.'%')
        ->get();
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
            "status" => true,
            "data" => $data
        ],200);
    }

}
