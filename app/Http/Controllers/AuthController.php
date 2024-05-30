<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;


class AuthController extends Controller 

{
    

    public function register(UserRequest $request){
        try{

            DB::beginTransaction();
            $user=User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'role_name'=>assignRole($request->role_name),
                'status'=>$request->status,
            ]);

           
            $token = Auth::login($user);

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
   

    } catch(Throwable  $th){

        DB::rollback();
        Log::error($th);
        return response()->json([
            'status'=>'user not created',
            'error'=>$th->getMessage(),
            
        ], 500);

}    }





public function login(LoginRequest $request){


    try{
        
        DB::beginTransaction();
        
        $credentials = $request->only('email', 'password');
        $token = Auth::guard('api')->attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::guard('api')->user();

        DB::commit();
        return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);

    

}catch(\Throwable  $th){

    DB::rollback();
    Log::error($th);
    return response()->json([
        'status'=>'user not authorized',
        'error'=>$th->getMessage(),
        
    ], 500);

}
    
}

public function logout(){
    Auth::guard('api')->logout();

return response()->json([
    'status' => 'success',
    'message' => 'logout'
], 200);
}


}
