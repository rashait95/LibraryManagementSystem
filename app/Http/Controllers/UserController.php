<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponses;
use PHPUnit\Event\Code\Throwable;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;
use App\Http\Requests\updateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     use ApiResponses;


     public function __construct(){

        $this->middleware(['role_or_permission:Admin|show users|create user|show user profile|update user profile|      
        show books|create book|update book|delete book
       |show authors|create author|update author|delete author']);
       $this->middleware(['role_or_permission:user|show user profile|update user profile
       |show books|borrow book|show borrowed books']);
     }


    public function index()
    {
        $users = User::paginate();
        return (new UserCollection($users))->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
           
           DB::beginTransaction();
            //$user = $request->validated();
            $user=User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'role_name'=>assignRole($request->role_name),
               'status'=>$request->status,
            ]);
            DB::commit();
            return $this->customeResponse(new UserResource($user),'user created successfully',201);

        } catch (\Throwable $th) {

            DB::rollback();
            Log::error($th);
            return $this->customeResponse(new UserResource($user),$th->getMessage(),500);
        }


        

}

    /**
     * Display the specified resource.
     */
    public function showprofile(User $user){
     
      return $this->customeResponse(new UserResource($user),'your profile',200);
    
          
        }

    /**
     * Update the specified resource in storage.
     */
    public function updateprofile(updateUserRequest $request,User $user){
       
            
        $user->name = $request->input('name') ?? $user->name;
        $user->email = $request->input('email') ?? $user->email;
        $user->password = $request->input('password') ?? $user->password;
        $user->role_name = $request->input('role_name') ?? $user->role_name;
        $user->status = $request->input('status') ?? $user->status;

        $user->update();
        $data = new UserResource($user);

     return $this->customeResponse($data,'updated',200);
                     
       }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user->delete($id);
        return $this->customeResponse(new UserResource($user),'user deleted successfully',200);
    }
}




 
        

    
