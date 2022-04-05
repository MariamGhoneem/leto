<?php

namespace App\Http\Controllers;

use App\Models\Baby;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class BabyController extends Controller
{
    public function insert(Request $request)
    {
        $baby = new Baby();
        $baby-> name =      $request->name;
        $baby-> birthdate = $request->birthdate;
        $baby-> gender =    $request->gender;
        $baby->save();
        

        return response()->json(["baby_data" => $baby]);
    }

    public function index(Request $request)
    {
        $babies = Baby::all();
        return response()->json($babies);
    }

    public function show($id)
    {
        $baby = Baby::find($id);
        return response()->json($baby);
    }

    public function delete($id)
    {
        $baby = Baby::find($id);
        $baby->delete();
        return response()->json([$baby]);
    }

    public function update(Request $request, $id)
    {
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        $baby = Baby::find($id);
        $baby-> name =      $request->name;
        $baby-> birthdate = $request->birthdate;
        $baby-> gender =    $request->gender;
        $baby-> user_id =   $user->id;
        $baby->save();

        return response()->json(["baby_data" => $baby]);
    }
}
