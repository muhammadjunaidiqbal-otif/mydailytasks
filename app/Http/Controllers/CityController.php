<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function GetCities(){
        $citiesDetails = City::all();
        if($citiesDetails->isEmpty()){
            return "No Cities Data";
        }else{
            return "Have Cities";
        }
        
    }
    
}    
