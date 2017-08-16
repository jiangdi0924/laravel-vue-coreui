<?php

namespace App\Http\Controllers;
use App\Models\UserModel;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;

class AuthenticateController extends Controller
{
    //注册
    public function register(Request $request)
    {
        $user= new UserModel();
        if($request->name!=''&&$request->email!=''&&$request->password!=''){
            $user->name=$request->name;
            //重复email
            if($user->where('email',$request->email)->get()->count()){
                return response()->json(["message"=>'email already exists']);
            }
            $user->email=$request->email;
            $user->password=bcrypt($request->password);
            $user->save();
            return response()->json(["message"=>"User Created","user"=>$user]);
        }else{
            return response()->json(["message"=>'empty']);
        }
    }
    
    //登录
    public function login(Request $request)
    {
        $crediential=$request->only('email','password');
        if(!$token=JWTAuth::attempt($crediential)){
            return "Not Authenticated";
        }

        return ['token'=>$token];   
    }

    //获取当前用户登录信息
    public function userInfo()
    {   
        $user = request()->user()->name;

        return $user;  
    }
}