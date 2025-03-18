<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function GetCountries(){
        $countriesDetails = Country::all();
        if($countriesDetails->isEmpty()){
            return "No Countries Data";
        }else{
            foreach($countriesDetails as $country){
                echo $country->name;
            }
        } 
    }

    public function getstates(){
        $country_state = Country::where('name','pakistan')->with('states')->with('cities')->get();
        return $country_state;
    }

    public function users(){
        $users = Country::where('id',77)->with('users')->get();
        return $users;
    }
}
