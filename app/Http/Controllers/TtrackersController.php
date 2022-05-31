<?php

namespace App\Http\Controllers;

use App\Models\Feeding;
use App\Models\Sleep;
use App\Models\Diaper;
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
            'created_at' => 'required|date_format:Y-m-d H:i:s',
            'baby_id' => 'required',
        );

        $validated = Validator::make($request->all(),$rules);

        if ($validated->fails()) {
            return response()->json([$validated->errors()],400);
        }
        else{
            $feeding = new Feeding();
            $feeding -> quantity    = $request->quantity;
            $feeding -> created_at  = $request->created_at;
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
            'start_time' => 'required|date_format:Y-m-d H:i:s',
            'end_time' => 'required|date_format:Y-m-d H:i:s|after:start_time',
            'baby_id' => 'required',
        );
        $validated = Validator::make($request->all(),$rules);

        if ($validated->fails()) {
            return response()->json([$validated->errors()],400);
            //return $validated->errors();
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
                return response()->json(['error: no user id or baby id found'],404);
            }

        }

        
    }

    public function add_diaper(Request $request, $user_id)
    {
        $rules = array(
            'states' => ['required',Rule::in(['1','2','3','4'])],
            'time' => 'required|date_format:Y-m-d H:i:s',
            'baby_id' => 'required',
        );

        $validated = Validator::make($request->all(),$rules);
        if ($validated->fails()) {
            return response()->json([$validated->errors()],400);
        }
        else{
            $diaper = new Diaper();
            $states = $request->states;
            switch ($states) {
                case '1':
                    $diaper -> wet    = 1;
                    $diaper -> dirty    = 0;
                    break;

                case '2':
                    $diaper -> wet    = 0;
                    $diaper -> dirty    = 1;
                    break;
                
                case '3':
                    $diaper -> wet    = 1;
                    $diaper -> dirty    = 1;
                    break;

                case '4':
                    $diaper -> wet    = 0;
                    $diaper -> dirty    = 0;
                    break;

            }
            $diaper -> time        = $request->time;
            $diaper -> user_id     = $user_id;
            $diaper -> baby_id     = $request->baby_id;
            try {
                $diaper->save();
                return response()->json($diaper);
            } catch ( Exception  $th) {
                return response()->json(['error: no user id or baby id found'],404);
            }
            
        }
        
    }
}
