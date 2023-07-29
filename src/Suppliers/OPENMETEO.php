<?php

namespace PhpWeather\Suppliers;

use Exception;
use PhpWeather\Interfaces\WeatherSupplierInterface;

class OPENMETEO implements WeatherSupplierInterface
{
    public $geocoding_api_url = "https://geocoding-api.open-meteo.com/v1/search?";

    public function __construct()
    {
        
    }
    
    public function fetchWeatherInformation()
    {
        echo 'hi';
    }

    public function fetchCoordinates(string $city)
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
        
        $response = curl_exec($ch);

        return $response;     
       
    }


}