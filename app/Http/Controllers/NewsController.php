<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\News;
use Str;


class NewsController extends Controller
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

        // $name = $request->file('image')->getClientOriginalName();
        // $path = $request->file('image')->storeAs('public/images/',$name);

        Storage::disk('local')->put($imageName, base64_decode($image));

        $news = News::create([
            'chamber_id'=>$request->user_id,
            'title'=>$request->title,
            'image'=>$imageName,
            'description'=>$request->description,

        ]);

       

        if($news){
            return $this->responseSuccess($news);
        }
        else{
            $message = "invalid request";
            return $this->responseFail($message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
        // $data = News::where('chamber_id', '=', $request->chamber_id)->get();
        $data = News::all();

        if ($data) {
            # code...
            return $this->responseSuccess($data);
        }
        else{
            $message = "Something went wrong with query";
            return $this->responseFail($message);
        }
    }

    public function latestNews(Request $request)
    {
        //
        // $data = News::where('chamber_id', '=', $request->chamber_id)->get();
        $data = News::latest()->first();

        if ($data) {
            # code...
            return $this->responseSuccess($data);
        }
        else{
            $message = "Something went wrong with query";
            return $this->responseFail($message);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // Response Fail

    public function responseFail($message){
        return response()->json([
            "status" => false,
            "message" => $message
        ],422);
    }

    // Response Success

    public function responseSuccess($data){
        return response()->json([
            "status" => true,
            "data" => $data
        ],200);
    }


}
