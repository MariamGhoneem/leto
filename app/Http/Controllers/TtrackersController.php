<?php

namespace App\Http\Controllers;

use App\Models\Feeding;
use Illuminate\Http\Request;
Use Exception;



class TtrackersController extends Controller
{
    
    public function add_feeding(Request $request, $user_id)
    {  
        $feeding = new Feeding();
        $feeding -> quantity    = $request->quantity;
        $feeding -> time        = $request->time;
        $feeding -> user_id     = $user_id;
        $feeding -> baby_id     = $request->baby_id;
        try {
            $feeding->save();
            return response()->json($feeding);
        } catch ( Exception  $th) {
            return response()->json(['error: no user id or baby id found']);
        }
        
    }
}
