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
    public function fetchCountriesStates()
    {
        $client = new Client();

        try {
            $response = $client->get('https://countriesnow.space/api/v0.1/countries/states');
            $body = $response->getBody();
            $result = json_decode($body, true);
            //return $result;
            if (isset($result['data']) && is_array($result['data'])) {
    
                foreach ($result['data'] as $countryData) {
                    
                    $country = Country::updateOrCreate(
                        ['name' => $countryData['name']],
                        []
                    );
    
                    if (isset($countryData['states']) && is_array($countryData['states'])) {
                        foreach ($countryData['states'] as $stateData) {
                            State::updateOrCreate(
                                [
                                    'name' => $stateData['name'],
                                    'country_id' => $country->id
                                ],
                                []
                            );
                        }
                    }
                }
                return "success, message => Countries and states imported successfully";
                //return response()->json(['status' => 'success', 'message' => 'Countries and states imported successfully!']);
            } else {
                //return response()->json(['status' => 'error', 'message' => 'Invalid API data format!']);
                return "status => error, message => Invalid API data format!";
            }
    
        } catch (Exception $e) {
            //return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            return "status => error message";
        }
    }

    public function fetchCities()
    {
    $client = new Client();

    try {
        $countries = Country::all(); // Fetch stored countries
    
        foreach ($countries as $country) {
            $states = State::where('country_id', $country->id)->get();
    
            foreach ($states as $state) {
                // API to fetch cities based on country and state
                $response = $client->post('https://countriesnow.space/api/v0.1/countries/state/cities', [
                    'json' => [
                        'country' => $country->name,
                        'state' => $state->name
                    ]
                ]);
    
                $body = $response->getBody();
                $result = json_decode($body, true);
                //return $result;
                if (isset($result['data']) && is_array($result['data'])) {
                    foreach ($result['data'] as $cityName) {
                        City::updateOrCreate(
                            ['name' => $cityName, 'state_id' => $state->id],
                            []
                        );
                    }
                }
            }
        }
    
        return "success, message => Countries and cities imported successfully";
    } catch (Exception $e) {
        return "status => error message";
    }
    }    

}
