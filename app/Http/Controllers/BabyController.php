<?php

namespace App\Http\Controllers;

use App\Models\Baby;
use Illuminate\Http\Request;

class BabyController extends Controller
{
    public function insert(Request $request)
    {
        $baby = new Baby();
        $baby-> name =      $request->name;
        $baby-> birthdate = $request->birthdate;
        $baby-> gender =    $request->gender;
        $baby->save();

        return response()->json($baby);
    }
}
