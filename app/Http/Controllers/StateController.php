<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function GetStates(){
        $statesDetails = State::with('country')->get();
        if($statesDetails->isEmpty()){
            return "No States Data";
        }else{
            return $statesDetails;
        }
        
    }
    public function StatesForCountry($country_id)
    {
        //return response()->json($country_id);
        $states = State::where('country_id', $country_id)->orderBy('name')->get();
        return response()->json($states);
    }

  
}