<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function users(){
        $users = User::all();
        return $users;
    }
    public function index(Request $request){
        // sleep(60);
         $partners =  User::with('role')->get();
         return response()->json([
             'info' => $partners
         ]);      
    }
    public function delete($id){
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found!'], 404);
        } 
        $user->delete();  
        return response()->json(['msg' => 'User deleted successfully!']); 
    }
    public function update(Request $request){
        $user = User::find($request->id);
        if (!$user) {
            return response()->json(['error' => 'User not found']);
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id=$request->role;
        $user->save();

        return response()->json(['success' => 'User updated successfully']);
    }
    public function deleteSelectedRows(Request $request){
        $ids = $request->ids; 
        if (!empty($ids)) {
            User::whereIn('id', $ids)->delete();
            return response()->json(['success' => 'Records deleted successfully!']);
        }
        return response()->json(['error'=> 'No records selected.'], 400);
    }

    public function storeUser(Request $request){
        $data = $request->validate([
            'name'=>'required|string',
            'email'=>'required|email',
            'password' => [
                            'required',
                            'min:8',
                            'regex:/[A-Z]/',       
                            'regex:/[a-z]/',        
                            'regex:/[0-9]/'],
                        ]);
        $user = User::create($data);
        if($user){
            return response()->json(['success' => 'Records Created successfully']);
        }
        return response()->json(['error' => 'Error Creating Record'], 400);
    } 

}
