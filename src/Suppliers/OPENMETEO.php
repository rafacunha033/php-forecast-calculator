<?php

namespace PhpWeather\Suppliers;

use Exception;
use PhpWeather\Interfaces\WeatherSupplierInterface;

class OPENMETEO implements WeatherSupplierInterface
{
    public $foreacast_api_url = "https://api.open-meteo.com/v1/forecast?";
    public $geocoding_api_url = "https://geocoding-api.open-meteo.com/v1/search?";

    public function __construct()
    {
        
    }
    // latitude=52.52&longitude=13.41&hourly=temperature_2m
    public function fetchWeatherInformation($latitude, $longitude)
    {
        $ch = curl_init();
       
        $params = [
            "latitude" => $latitude,
            "longitude" => $longitude,
            "timezone" => "America/Sao_Paulo",
            "daily" => ["temperature_2m_max", "temperature_2m_min"]
        ];

        $url = $this->foreacast_api_url.http_build_query($params);
    
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
        ];
        
        curl_setopt_array($ch, $options);
        
        $response = curl_exec($ch);

        return $response;   
    }

    public function fetchCoordinates(string $city): string
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