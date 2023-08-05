<?php

namespace PhpForecast\Suppliers;

use InvalidArgumentException;
use PhpForecast\Hydrators\WEATHERAPI_HYDRATOR;
use PhpForecast\Interfaces\WeatherSupplierInterface;

class WEATHERAPI implements WeatherSupplierInterface
{
    public $foreacast_api_url = "https://api.weatherapi.com/v1/forecast.json?";

    /** @var WEATHERAPI_HYDRATOR */
    public $hydrator;

    public function __construct()
    {
        $this->hydrator = new WEATHERAPI_HYDRATOR;
    }
    
    public function fetchForecast($latitude, $longitude, $timezone = null)
    {
        if(empty($latitude) || empty($longitude)) {
            return throw new InvalidArgumentException('Empty latitude or longitude!');
        }

        $params = [
            "key" => $_ENV['WEATHERAPI_API_KEY'],
            "q" => "$latitude,$longitude",
            "days" => 7
        ];

        $url = $this->foreacast_api_url.http_build_query($params);
    
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
        ];
        
        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $responseArray = json_decode(curl_exec($ch), true);
        
        return $this->hydrator->hydrate($responseArray);   
    }

    
}