<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class EventController extends Controller
{
    //
    public function showEvents(Request $request){
        $data = DB::table('events')->get();

        return response()->json($data);
    }
}
