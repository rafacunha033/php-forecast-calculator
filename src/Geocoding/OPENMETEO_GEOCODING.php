<?php

namespace PhpForecast\Geocoding;

use PhpForecast\Interfaces\GeocodingInterface;

class OPENMETEO_GEOCODING implements GeocodingInterface
{

    public $geocoding_api_url = "https://geocoding-api.open-meteo.com/v1/search?";
    
    public function fetchCoordinatesAndTimezone(string $city)
    {
        $ch = curl_init();
       
        $params = [
            "name" => $city,
            "format" => "json"
        ];

        $url = $this->geocoding_api_url.http_build_query($params);
    
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
        ];
        
        curl_setopt_array($ch, $options);
        
        $response = json_decode(curl_exec($ch), true);

        $firstResult = $response["results"][0];
        
        return [
            $firstResult["latitude"],
            $firstResult["longitude"],
            $firstResult["timezone"]
        ];     
    }
}