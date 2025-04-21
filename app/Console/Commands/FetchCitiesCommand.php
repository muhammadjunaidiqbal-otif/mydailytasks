<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\State;
use GuzzleHttp\Client;
use App\Models\Country;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FetchCitiesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-cities-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch cities from external API and store into database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client();

        $states = State::all();

    foreach ($states as $state) {
        try {
            if (!$state->country) {
                $this->error("State {$state->name} has no associated country.");
                continue;
            }
            $response = $client->post('https://countriesnow.space/api/v0.1/countries/state/cities', [
                'json' => [
                    'country' => $state->country->name,
                    'state' => $state->name,
                ]
            ]);

            $body = $response->getBody();
            $result = json_decode($body, true);

            if (isset($result['data']) && is_array($result['data'])) {
                foreach ($result['data'] as $city) {
                    City::updateOrCreate(
                        [
                            'name' => $city,
                            'state_id' => $state->id,
                            'country_id' => $state->country_id
                        ],
                        [] 
                    );
                }
                $this->info("Cities for {$state->name} imported successfully!");
            } else {
                $this->error("No cities found for {$state->name}.");
            }

        } catch (\Exception $e) {
            \Log::error("Error fetching cities for {$state->name}: " . $e->getMessage());
            $this->error("API request failed for {$state->name}.");
        }
    }
    }
}
