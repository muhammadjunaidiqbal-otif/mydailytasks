<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\City;
use App\Models\State;
use GuzzleHttp\Client;
use App\Models\Country;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function fetchCountries(){
        $client = new Client();

       // try {
            $response = $client->get('https://countriesnow.space/api/v0.1/countries/flag/unicode');
            $body = $response->getBody();
            $result = json_decode($body, true);
            //return $result;
            $i = 1;
            $totalCountries = 0;
            foreach($result['data'] as $country){
                echo "$i  {$country['name']} - {$country['iso3']} - {$country['unicodeFlag']} <br>" ; 
                $i++;
                $totalCountries++;
            }
            echo "Total Countries = {$totalCountries}";
        //     if (isset($result['data']) && is_array($result['data'])) {
    
        //         foreach ($result['data'] as $countryData) {
                    
        //             $country = Country::updateOrCreate(
        //                 ['name' => $countryData['name']],
        //                 []
        //             );
    
        //             if (isset($countryData['states']) && is_array($countryData['states'])) {
        //                 foreach ($countryData['states'] as $stateData) {
        //                     State::updateOrCreate(
        //                         [
        //                             'name' => $stateData['name'],
        //                             'country_id' => $country->id
        //                         ],
        //                         []
        //                     );
        //                 }
        //             }
        //         }
        //         return "success, message => Countries and states imported successfully";
        //         //return response()->json(['status' => 'success', 'message' => 'Countries and states imported successfully!']);
        //     } else {
        //         //return response()->json(['status' => 'error', 'message' => 'Invalid API data format!']);
        //         return "status => error, message => Invalid API data format!";
        //    }
    
        // } catch (Exception $e) {
        //     //return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        //     return "status => error message";
         }
    
         public function fetchStates(){
            $client = new Client();
            $response = $client->get('https://countriesnow.space/api/v0.1/countries/states');
            $body = $response->getBody();
            $result = json_decode($body,true);
            //return $result;
            $totalCountries = 0 ;
            $totalStates = 0;
            foreach($result['data'] as $country){
                echo "Country =>  " . $country['name']; 
                $totalCountries++;
                echo "<br> States => <br> ";
                $i = 1; 
                foreach($country['states'] as $state){
                   echo $i ." - " . $state['name'] . " - " .  $state['state_code']  . " <br> "  ;
                   $i++;
                   $totalStates++;
                }
            }
            echo "Total Countries = {$totalCountries} , Total States = {$totalStates}";
         }
         public function fetchCities(){
            $client = new Client();
            $response = $client->get('https://countriesnow.space/api/v0.1/countries');
            $body = $response->getBody();
            $result = json_decode($body,true);
           // return  $result['data'];
           $totalCountries = 0 ;
           $totalCities = 0;
            foreach($result['data'] as $country){
                echo "Country =>  " . $country['country']; 
                $totalCountries++;
                echo " Cities => <br> "; 
                $i=1;
                foreach($country['cities'] as $city){
                   echo "$i - {$city}   <br>";
                   $i++;
                   $totalCities++;
                }
            }
            echo "Total Countries = {$totalCountries} , Total Cities = {$totalCities}";
         }
    
}
