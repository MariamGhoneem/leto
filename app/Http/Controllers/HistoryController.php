<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function allhistories($babyid)
    {
        //get all history for a baby
        if ($history = History::where('baby_id','=',$babyid)->get()) {
            return response()->json($history);
        } else {
            return response()->json('no history found',404);
        } 
    }

    public function add_history(Request $request,$babyid)
    {
        //add health history
        $history = new History();
        $history-> babyname =   $request->babyname;
        $history-> docname =    $request->docname;
        $history-> diagnose =   $request->diagnose;
        $history-> r =          $request->r;
        $history-> baby_id =    $babyid;
        $history->save();
        return response()->json('success');
    }
}
