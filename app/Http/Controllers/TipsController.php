<?php

namespace App\Http\Controllers;

use App\Models\Baby;
use App\Models\Tip;
use Carbon\Carbon;

class TipsController extends Controller
{
    public function tipoftheday($babyid)
    {
        try {
        $baby = Baby::where('id', '=', $babyid)->first();
        } catch (\Throwable $th) {
            return response()->json('no babyid found',404);
        }
        $getfirstdate   = $baby-> birthdate;
        $birthdate      = $getfirstdate.' 00:00:00';
        $firstdate      = new Carbon($birthdate);
        $lastdate       = Carbon::now();
        $day            = $firstdate->diffInDays($lastdate);
        $tips           = Tip::where('tipnum','<=',$day+1)->paginate(7);
        $tip            = Tip::find($day+1) ;
        return response()->json(['tips' => $tips,'daily tip' => $tip]);
    }
}