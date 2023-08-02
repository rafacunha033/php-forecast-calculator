<?php

namespace PhpWeather\Suppliers;

use Exception;
use InvalidArgumentException;
use PhpWeather\Interfaces\WeatherSupplierInterface;

class OPENMETEO implements WeatherSupplierInterface
{
    public $foreacast_api_url = "https://api.open-meteo.com/v1/forecast?";
    public $geocoding_api_url = "https://geocoding-api.open-meteo.com/v1/search?";

    public function __construct()
    {
        
    }
    
    public function fetchWeatherInformation($city)
    {
        if (!is_string($city)) {
            throw new InvalidArgumentException("Parameter 'city' must be a string.");
        }

        $coordinates = $this->fetchCoordinates($city);

        $params = [
            "latitude" => $coordinates->latitude,
            "longitude" => $coordinates->longitude,
            "timezone" => $coordinates->timezone,
            "current_weather" => true
        ];

        $url = $this->foreacast_api_url.http_build_query($params);
    
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
        ];
        
        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);

        return $response;   
    }

    private function fetchCoordinates(string $city)
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
        
        $response = json_decode(curl_exec($ch));

        return $response->results[0];     
    }


}