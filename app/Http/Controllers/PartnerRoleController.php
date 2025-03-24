<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Country;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PartnerRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('role_id','2')->get();
        return view('Partners.index',compact('users'));
    }

    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::orderBy('name','asc')->get();
       return view('Partners.create',compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email',
            'password' => [
        'required',
        'min:8','confirmed',
        'regex:/[A-Z]/',       
        'regex:/[a-z]/',        
        'regex:/[0-9]/'],
        'country_id'=>'required|int',
        'state_id'=>'required|int',
        'city_id'=>'required|int'
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
            'role_id'=>'2',
            'country_id'=>$request->country_id,
            'state_id'=>$request->state_id,
'city_id'=>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     $request->city_id

        ]);
        //gi$users = User::where('role_id','2')->get();
        return redirect('/partners')->with('status',  "Created");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('role')->findOrFail($id);
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $partner = User::findOrFail($id);
        $countries = Country::orderBy('name', 'asc')->get();
        
        return view('Partners.create', compact('countries', 'partner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email',
            'password' => [
        'required',
        'min:8','confirmed',
        'regex:/[A-Z]/',       
        'regex:/[a-z]/',        
        'regex:/[0-9]/'],
        'country_id'=>'required|int',
        'state_id'=>'required|int',
        'city_id'=>'required|int'
        ]);
        $user = User::findOrFail($id); 
        $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
            'role_id'=>'2'
        ]);
        //gi$users = User::where('role_id','2')->get();
        return redirect('/partners')->with('status',  "Updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back();
    }
}
