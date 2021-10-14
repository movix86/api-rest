<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class TestController extends Controller
{
    public function test_json(Request $request){
        $name = $request->input('name', null);
        if ($name){
            return response()->json([
                "message" => "Se logro crear bien el usuario"
            ], 404);
        }else{
            return response()->json([
                "message" => "No se logro crear bien el usuario"
            ], 400);
        }
    }

    public function test_data(){
        var_dump(auth()->user());
    }


    public function register(Request $request){
        $json = $request->input('json', null);

        $data_array = json_decode($json, true);

        $validation = Validator::make($data_array, [
            'name' => 'required',
            'lastname' => 'required',
            'rol' => 'required',
            'edad' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        if ($validation->fails()){
            return response()->json([
                "message" => "Fallo la api y no paso nada"
            ], 400);
        }

        User::create([
            'name'=>$data_array['name'],
            'lastname'=>$data_array['lastname'],
            'rol'=>$data_array['rol'],
            'edad'=>$data_array['edad'],
            'email'=>$data_array['email'],
            'password' => Hash::make($data_array['password'])
        ]);
        return response()->json([
            "message" => "Se logro crear bien el usuario"
        ], 404);
    }
}
