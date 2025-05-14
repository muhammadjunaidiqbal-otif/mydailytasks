<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashBoardController extends Controller
{
    public function showIndexPage(){
        return view('Admin.Dashboards.index');
    }
    public function showCalenderPage(){
        return view('Admin.Dashboards.calender');
    }
    public function showProfilePage(){
        $user = Auth::user();
        return view('Admin.Dashboards.user-profile',compact('user'));
    }
    public function showUserDataTablePage(){
        $roles = Role::all();
        return view('Admin.Dashboards.users-dt',compact('roles'));
    }
}
