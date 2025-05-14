<?php

namespace App\Http\Controllers\Admin;

use DB;
use Log;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Validator;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class RoleController extends Controller
{
    public function showRolesPage(){
        $roles = Role::withCount('users')->get();
        $permissions = Permission::all();
        return view('Admin.Roles-and-Permissions.roles',compact('permissions','roles'));
    }

    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
           $request->validate([
            'modalRoleName' => 'required|string|max:255|unique:roles,name',
        ]);

        // Create the new role
        $role = Role::create(['name' => $request->modalRoleName]);

        // Sync permissions if provided
        if ($request->has('permissions')) {
            $permissions = json_decode($request->permissions, true);
            if (is_array($permissions)) {
                $role->syncPermissions($permissions);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Role added successfully.',
            'role' => $role
        ], 201);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    public function getPermissions($id)
    {
        $role = Role::findOrFail($id);
        $permissions = $role->permissions->pluck('name')->toArray();
    
        return response()->json([
            'success' => true,
            'permissions' => $permissions
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = $role->permissions->pluck('name')->toArray();
        return response()->json([
            'role'=>$role,
            'permissions' => $permissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);    
        // \Log::info('Update Role Request:', [
        //     'role_id' => $id,
        //     'current_role_name' => $role->name,
        //     'requested_name' => $request->input('name'),
        //     'permissions' => $request->input('permissions', [])
        // ]);
    
        //$allRoles = DB::table('spatie_roles')->select('id', 'name')->get()->toArray();
        // \Log::info('All Roles in Database:', $allRoles);    
        $role->name = $request->input('name');
        $role->save();
    
        $permissions = $request->input('permissions', []);
        $role->syncPermissions($permissions);
    
        return response()->json(['success' => 'Role updated successfully']);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return response()->json(['success' => 'Role deleted successfully']);
    }
}
