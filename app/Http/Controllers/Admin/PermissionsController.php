<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    public function showPermissionsPage(){
        return view('Admin.Roles-and-Permissions.permissions');
    }
    public function permissionsList(){
        $permissions = Permission::all();
        return response()->json([
            'info'=>$permissions
        ]);
    }
    public function storePermission(Request $request){
        $request->validate([
            'modalPermissionName'=>'required'
        ]);
        $permission = Permission::create(['name' => $request->modalPermissionName]);
        return response()->json([
            'success'=>'Permission Created Successfully'
        ]);
    }
    public function updatePermission(Request $request,$id){
        $permission = Permission::findOrFail($id);
        $request->validate([
            'editPermissionName'=>'required'
        ]);
        $permission->update(['name' => $request->editPermissionName]);
        return response()->json([
            'success'=>'Permission Updated Successfully'
        ]);
    }
    public function deletePermission($id){
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return response()->json([
            'success'=>'Permission Deleted Successfully'
        ]);
    }
}
