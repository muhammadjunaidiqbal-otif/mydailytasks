<?php

namespace App\Console\Commands;


use Exception;
use GuzzleHttp\Client;
use App\Models\Country;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;


class FetchCountriesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-countries-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch countries from external API and store into database';

    /**
     * Execute the console command.
     */
    public function handle()
{
    $client = new Client();

    try {
        $response = $client->get('https://countriesnow.space/api/v0.1/countries/flag/unicode');
        $body = $response->getBody();
        $result = json_decode($body, true);

        if (isset($result['data']) && is_array($result['data'])) {
            foreach ($result['data'] as $countryData) {
                Country::updateOrCreate(
                    [
                        'name' => $countryData['name'],
                        'iso3' => $countryData['iso3'],
                        'unicodeFlag' => $countryData['unicodeFlag'],
                    ]
                );
            }
            $this->info('Countries imported successfully!');
        } else {
            $this->error('Failed to fetch Countries or empty data!');
        }

    } catch (Exception $e) {
        Log::error('Error fetching countries: ' . $e->getMessage());
        $this->error('An error occurred while fetching countries. Please check the logs for more details.');
    }
}
}
