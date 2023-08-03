<?php

namespace PhpWeather\Suppliers;

use Exception;
use InvalidArgumentException;
use PhpWeather\Interfaces\WeatherSupplierInterface;

class OPENMETEO implements WeatherSupplierInterface
{
    public $foreacast_api_url = "https://api.open-meteo.com/v1/forecast?";

    public function __construct()
    {
        
    }
    
    public function fetchForecast($latitude, $longitude, $timezone = null)
    {
        if(empty($latitude) || empty($longitude)) {
            return throw new InvalidArgumentException('Empty latitude or longitude!');
        }

        $params = [
            "latitude" => $latitude,
            "longitude" => $longitude,
            "daily" => ["temperature_2m_max", "temperature_2m_min"],
            "timezone" => $timezone
        ];

        $url = $this->foreacast_api_url.http_build_query($params);
    
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
        ];
        
        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $responseArray = json_decode(curl_exec($ch), true);
        
        return $responseArray['current_weather']['temperature'];   
    }

    
}