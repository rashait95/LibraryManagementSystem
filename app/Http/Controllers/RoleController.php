<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\ApiResponses;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  use ApiResponses;


     public function __construct()
     {
            $this->middleware('role:Super Admin| show roles|create role|update role|delete role');
     }


    public function index()
    {
        

      $roles=Role::orderBy('id', 'DESC')->paginate(5);
      return $this->customeResponses($roles,'System roles are',200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $role=$request->validate();
        $role=Role::create(['name'=>$request->name]);
        $role->syncPermissions($request->permissions);
        return $this->customeResponses($role,'Role created successfully',201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)


    {     $rolePermissions = Permission::join("role_has_permissions","permission_id","=","id")
        ->where("role_id",$role->id)
        ->select('name')
        ->get();
        return $this->customeResponses($rolePermissions,'Role shown successfully',200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $input = $request->only('name');

        $role->update($input);

        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();

        $role->syncPermissions($permissions);    

        return $this->customeResponses($role,'Role updated successfully',200);
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($role->name=='Super Admin'){
            abort(403, 'SUPER ADMIN ROLE CAN NOT BE DELETED');
        }
        if(auth()->user()->hasRole($role->name)){
            abort(403, 'CAN NOT DELETE SELF ASSIGNED ROLE');
        }
        $role->delete();
        return $this->customeResponses($role,'Role deleted successfully',200);
    }
}
