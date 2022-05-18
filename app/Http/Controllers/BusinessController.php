<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $image_64 = $request->image;
        $extension = explode(';base64',$image_64);
        $extension = explode('/',$extension[0]);
        $extension = $extension[1];
        $replace = substr($image_64, 0, strpos($image_64, ',')+1);
        $image = str_replace($replace, '', $image_64);
        $image = str_replace(' ', '+', $image);
        $imageName = time().'_'.Str::random(20).'.'.$extension;

        Storage::disk('local')->put($imageName, base64_decode($image));


        //
        $user_id = 1;
        $business = Business::create([
            'user_id'=>$user_id,
            'business_title'=>$request->title,
            'zip'=>$request->zip,
            'state'=>$request->state,
            'phone'=>$request->phone,
            'email'=>$request->email,
            'image'=>$imageName,

        ]);

        if($business){
            return $this->responseSuccess($business);
        }
        else{
            $message = "invalid request";
            return $this->responseFail($message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Business $business)
    {
        //
        $business = Business::Where('business_title', 'LIKE', '%'.$request->title.'%')
        ->orWhere('state', 'LIKE', '%'.$request->state.'%')
        ->orWhere('zip', 'LIKE', '%'.$request->zip.'%')
        ->orWhere('phone', 'LIKE', '%'.$request->phone.'%')
        ->orWhere('email', 'LIKE', '%'.$request->email.'%')
        ->get();
        if($business){
            return $this->responseSuccess($business);
        }
        else{
            $message = "invalid request";
            return $this->responseFail($message);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function edit(Business $business)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Business $business)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function destroy(Business $business)
    {
        //
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
