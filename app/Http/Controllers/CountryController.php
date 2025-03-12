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
            return $countriesDetails;
        }
        
    }
}
