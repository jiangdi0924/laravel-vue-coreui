<?php

namespace App\Http\Controllers;
use App\Models\UserModel;

use Tymon\JWTAuth\Facades\JWTAuth;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function register(Request $request)
    {

        //  create db
        $user= new UserModel();
        if($request->name!=''&&$request->email!=''&&$request->password!=''){
            $user->name=$request->name;
            if($user->where('email',$request->email)->get()->count()){
                return json_encode('email repeat');
            }
            $user->email=$request->email;
            $user->password=bcrypt($request->password);
            $user->save();
            return json_encode(["message"=>"User Created","user"=>$user]);
        }else{
            return json_encode('empty');
        }

    }


    public function login(Request $request)
    {
        /*$this->validate($request,[
       'email' => 'required|email',
       'password' => 'required|min:6',
       ]);*/

        $crediential=$request->only('email','password');

        if(!$token=JWTAuth::attempt($crediential)){
            return "Not Authenticated";
        }

        return ['token'=>$token];

    }

    public function userInfo()
    {
        $user = request()->user()->name;
        return json_encode(['name' => $user]);
    }
}