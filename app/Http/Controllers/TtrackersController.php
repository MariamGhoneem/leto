<?php

namespace App\Http\Controllers;

use App\Models\Feeding;
use App\Models\Sleep;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
Use Exception;

class TtrackersController extends Controller
{
    
    public function add_feeding(Request $request, $user_id)
    {
        $rules = array(
            'quantity' => ['required',Rule::in(['1','2','3','4','5'])],
            'time' => 'required',
            'baby_id' => 'required',
        );

        $validated = Validator::make($request->all(),$rules);

        if ($validated->fails()) {
            return $validated->errors();
        }
        else{
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

    public function add_sleep(Request $request, $user_id)
    {
        $rules = array(
            'start_time' => 'required',
            'end_time' => 'required',
            'baby_id' => 'required',
        );
        $validated = Validator::make($request->all(),$rules);

        if ($validated->fails()) {
            return $validated->errors();
        }
        else{

            $sleep = new Sleep();
            $sleep -> start_time =   $request->start_time;
            $sleep -> end_time =     $request-> end_time;
            $sleep -> user_id =      $user_id;
            $sleep -> baby_id =      $request->baby_id;

            try {
                $sleep->save();
                return response()->json($sleep);
            } catch ( Exception  $th) {
                return response()->json(['error: no user id or baby id found']);
            }

        }

        
    }
}
