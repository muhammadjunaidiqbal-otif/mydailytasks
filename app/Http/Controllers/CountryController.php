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
<<<<<<< HEAD
        }
        
=======
        } 
    }
    public function getstates(){
        $country_state = Country::where('name','pakistan')->with('states')->with('cities')->get();
        return $country_state;
    }

    public function users(){
        $users = Country::where('id',77)->with('users')->get();
        return $users;
>>>>>>> ebdd14d (Added Country/state/city select option on register page)
    }
}
