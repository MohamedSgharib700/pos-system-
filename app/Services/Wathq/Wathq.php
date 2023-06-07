<?php
namespace App\Services\Wathq;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class Wathq
{
    protected $api_key;

    protected $base_url;

    const API_END_POINTS = [
        'commercial_registration_info'=> 'commercialregistration/fullinfo/',
    ];

    function __construct()
    {
        $this->api_key = config('services.wathq.api_key');

        $this->base_url = config('services.wathq.base_url');
    }

    public function getCommercialRegistrationInfo($commercial_registration_number)
    {
        $response =  Http::withHeaders($this->defaultHeaders())
                         ->acceptJson()
                         ->get($this->base_url . self::API_END_POINTS['commercial_registration_info'] . $commercial_registration_number);

        $this->logResponse($response);

        if (! $response->successful()) {
            $response->throw();
        }

         return $response->json();
    }

    protected function defaultHeaders()
    {
        return [
           'apiKey'=>$this->api_key
        ];
    }

    protected function logResponse($response)
    {
        Log::channel('wathqlog')->info("\n". json_encode($response->json(), JSON_UNESCAPED_UNICODE));
    }
}
