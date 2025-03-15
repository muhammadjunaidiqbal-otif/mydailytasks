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
<<<<<<< HEAD
=======
    public function StatesForCountry($country_id)
    {
        $states = State::where('country_id', $country_id)->get();
        return response()->json($states);
    }

  
>>>>>>> ebdd14d (Added Country/state/city select option on register page)
}