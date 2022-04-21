<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'error'=>$validator->errors()]);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('Token')->accessToken;
        return response()->json(['message'=>'berhasil','token'=>$token, 'user'=>$user]);
    }

    public function login(Request $request)
    {

        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if(auth()->attempt($data)){
            $token = auth()->user()->createToken('Token')->accessToken;
            return response()->json(['status'=>true,'token'=>$token, 'message'=>'login berhasil']);
        } else {
            return response()->json(['status'=>false,'error'=>'login gagal']);
        }
    }

    public function userInfo()
    {
        $user = auth()->user();
        return response()->json(['status'=>true,'user'=>$user, 'message'=>'data ditemukan']);
    }

    public function editUser(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'error'=>$validator->errors()]);
        }
        $user = auth()->user();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password= Hash::make($request->password);
        if ($user->save()) {
            return response()->json(['Data telah diupdate.', $user]);
        }

    }
}
