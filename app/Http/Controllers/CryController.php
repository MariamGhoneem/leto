<?php

namespace App\Http\Controllers;

use App\Models\Cry;
use App\Models\Diaper;
use App\Models\Feeding;
use App\Models\Sleep;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
Use Exception;


class CryController extends Controller
{
    public function trackers($baby_id)
    {
        //get the last 7 days data
        $date       = Carbon::now()->subDays(7);
        $feeding    = Feeding::where('baby_id','=',$baby_id)->where('created_at', '>=' ,$date)->get(['created_at','quantity']);
        $sleeping   = Sleep::where('baby_id','=',$baby_id)->where('end_time','>=',$date)->get(['start_time','end_time']);
        $diaper     = Diaper::where('baby_id','=',$baby_id)->where('time','>=',$date)->get(['time','dirty','wet']);
        
        return response()->json(['feeding'=>$feeding,'sleep'=>$sleeping,'diaper'=>$diaper]);
    }
}
