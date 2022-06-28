<?php

namespace App\Http\Controllers;

use App\Models\Cry;
use App\Models\Diaper;
use App\Models\Feeding;
use App\Models\Sleep;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
Use Exception;
use Illuminate\Support\Arr;

class CryController extends Controller
{
    public function trackers($baby_id)
    {
        //get the last 7 days data
        $date       = Carbon::now()->subDays(7);
        $feeding    = Feeding::where('baby_id','=',$baby_id)->where('created_at', '>=' ,$date)->get(['created_at','quantity']);
        $sleeping   = Sleep::where('baby_id','=',$baby_id)->where('end_time','>=',$date)->get(['start_time','end_time']);
        $diaper     = Diaper::where('baby_id','=',$baby_id)->where('time','>=',$date)->get(['time','dirty','wet']);
        $label      = Cry::where('baby_id','=',$baby_id)->where('created_at','>=',$date)->get(['created_at','label']);
        
        return response()->json(['feeding'=>$feeding,'sleep'=>$sleeping,'diaper'=>$diaper,'labels'=>$label]);
    }

    public function insert(Request $request, $baby_id)
    {
        $rules = array(
            'last_wake' => 'required','sleep24' => 'required','sleep_avg' => 'required','last_wet' => 'required','wet24' => 'required',
            'wet_avg' => 'required','last_dirty' => 'required','dirty24' => 'required','dirty_avg' => 'required','last_feed' => 'required',
            'feed24' => 'required','feed_avg' => 'required','normal_frq' => 'required','sleep_frq' => 'required','wet_frq' => 'required',
            'dirty_frq' => 'required','food_frq' => 'required','normal_instance' => 'required','sleep_instance' => 'required',
            'wet_instance' => 'required','dirty_instance' => 'required','food_instance' => 'required','label' => 'required',
        );

        $validated = Validator::make($request->all(),$rules);
        if ($validated->fails()) {
            return response()->json([$validated->errors()],400);
        }else{
            $cry = new Cry();
            $cry -> last_week       = $request->last_wake;
            $cry -> sleep24         = $request->sleep24;
            $cry -> sleep_avg       = $request->sleep_avg;
            $cry -> last_wet        = $request->last_wet;
            $cry -> wet24           = $request->wet24;
            $cry -> wet_avg         = $request->wet_avg;
            $cry -> last_dirty      = $request->last_dirty;
            $cry -> dirty24         = $request->dirty24;
            $cry -> dirty_avg       = $request->dirty_avg;
            $cry -> last_feed       = $request->last_feed;
            $cry -> feed24          = $request->feed24;
            $cry -> feed_avg        = $request->feed_avg;
            $cry -> normal_freq     = $request->normal_frq;
            $cry -> sleep_frq       = $request->sleep_frq;
            $cry -> wet_freq        = $request->wet_frq;
            $cry -> dirty_freq      = $request->dirty_frq;
            $cry -> food_freq       = $request->food_frq;
            $cry -> normal_instance = $request->normal_instance;
            $cry -> sleep_instance  = $request->sleep_instance;
            $cry -> wet_instance    = $request->wet_instance;
            $cry -> dirty_instance  = $request->dirty_instance;
            $cry -> food_instance   = $request->food_instance;
            $cry -> Label           = $request->label;
            $cry -> baby_id         = $baby_id;
            $cry -> created_at      = Carbon::now();
            try {
                $cry -> save();
                return response()->json('success');
            } catch ( Exception $th) {
                return response()->json($th);
            }
        }  
    }

    public function edit(Request $request, $baby_id)
    {
        if ($data =Cry::where('baby_id','=',$baby_id)->latest()->first()){
            $data -> label      = json_decode($request-> label,true);
            $data->save();
            return response()->json('success');
        }  else{
            return response()->json('error',400);
        } 
    }

    public function cry($baby_id)
    {
        $date       = Carbon::now()->subDays(14);
        $cry        = Cry::where('baby_id','=',$baby_id)->where('created_at', '>=' ,$date)->get();
        return response()->json($cry);
    }
}
