<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{
    public function showIndexPage(){
        return view('Admin.Dashboards.index');
    }
    public function showCalenderPage(){
        return view('Admin.Dashboards.calender');
    }
    public function showProfilePage(){
        return view('Admin.Dashboards.user-profile');
    }
    public function showUserDataTablePage(){
        return view('Admin.Dashboards.users-dt');
    }
}
