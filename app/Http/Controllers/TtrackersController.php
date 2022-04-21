<?php

namespace App\Http\Controllers;

use App\Models\Feeding;
use App\Models\Sleep;
use Illuminate\Http\Request;
Use Exception;



class TtrackersController extends Controller
{
    
    public function add_feeding(Request $request, $user_id)
    {  
        
        $quantity = $request->quantity;
        if (0<$quantity and $quantity<6) {
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
        } else {
            return response()->json('Quantity must be a scale from 1 to 5');
        }
        
    }

    public function add_sleep(Request $request, $user_id)
    {
        $sleep = new Sleep();
        $sleep -> start_time =   $request-> start_time;
        $sleep -> end_time =     $request-> end_time;
        $sleep -> user_id =     $user_id;
        $sleep -> baby_id =     $request->baby_id;

        try {
            $sleep->save();
            return response()->json($sleep);
        } catch ( Exception  $th) {
            return response()->json(['error: no user id or baby id found']);
        }
    }
}
