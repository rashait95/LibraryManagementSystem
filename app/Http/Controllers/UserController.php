<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\updateUserRequest;

class UserController extends Controller
{
    //

    public function showprofile(User $user){
     
    $userProfile = new UserResource($user);
    return response()->json([
        'status'=>'success',
        'user'=>$userProfile
    ]);

      
    }

    public function updateprofile(updateUserRequest $request,User $user){
       
            
        $user->name = $request->input('name') ?? $user->name;
        $user->email = $request->input('email') ?? $user->email;

        $user->update();
        $data = new UserResource($user);

        return response()->json([
            'status'=>'update user success',
            'user'=>$data
        ]);
                     
       }

 
        

    
}
