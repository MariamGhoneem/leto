<?php

namespace App\Http\Controllers;

use App\Models\Baby;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class BabyController extends Controller
{
    
    public function insert(Request $request)
    {
        $baby =      new Baby();
        $baby->      name =      $request->name;
        $baby->      birthdate = $request->birthdate;
        $baby->      gender =    $request->gender;
        $baby->      user_id =   $request->user_id;
        $baby->save();
        

        return response()->json(['success'=>'Baby added successfully',"baby_data" => $baby]);
    }


    public function index($user_id)
    {
        if ($babies = Baby::where('user_id', '=',$user_id)->get()) {
            return response()->json($babies);
        } else {
            return response()->json('no babies found');
        }
    }


    public function show($id)
    {
        $baby = Baby::find($id);
        return response()->json($baby);
    }


    public function delete($id)
    {
        if ($baby = Baby::find($id)) {
            $baby->delete();
            return response()->json(["Baby deleted successfully",'baby_data'=>$baby]);
        } else {
            return response()->json(['error'=>'Baby not found']);
        }
    }

    public function update(Request $request, $id)
    {
        $baby =      Baby::find($id);
        $baby->      name =      $request->name;
        $baby->      birthdate = $request->birthdate;
        $baby->      gender =    $request->gender;
        $baby->      user_id =   $request->user_id;
        $baby->save();

        return response()->json(["baby_data" => $baby]);
    }
}
