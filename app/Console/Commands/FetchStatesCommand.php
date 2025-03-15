<?php

namespace App\Console\Commands;

use Exception;
use App\Models\State;
use GuzzleHttp\Client;
use App\Models\Country;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FetchStatesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-states-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch states from external API and store into database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client();

       
        $countries = Country::all();

        foreach ($countries as $country) {
            try {
               
                $response = $client->post('https://countriesnow.space/api/v0.1/countries/states', [
                    'json' => ['country' => $country->name]
                ]);

                $body = $response->getBody();
                $result = json_decode($body, true);

                
                if (isset($result['data']['states']) && is_array($result['data']['states'])) {
                    foreach ($result['data']['states'] as $state) {
                        State::updateOrCreate(
                            ['name' => $state['name'], 'country_id' => $country->id,
                            'state_code' => $state['state_code']]
                        );
                    }
                    $this->info("States for {$country->name} imported successfully!");
                } else {
                    $this->error("No states found for {$country->name}.");
                }
            } catch (Exception $e) {
                Log::error("Error fetching states for {$country->name}: " . $e->getMessage());
                $this->error("API request failed for {$country->name}.");
            }
        }
    }
}
