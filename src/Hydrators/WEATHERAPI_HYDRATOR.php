<?php

namespace PhpForecast\Hydrators;

class WEATHERAPI_HYDRATOR 
{
    public function hydrate($data) 
    {
        $dailyForecast = $data["forecast"]["forecastday"];
        $responseArray = [];
        foreach($dailyForecast as $forecast) {
            $responseArray[$forecast["date"]] = [
                "temperature_max" => $forecast["day"]["maxtemp_c"],
                "temperature_min" => $forecast["day"]["mintemp_c"]
            ]; 
        }

        return $responseArray;
    }
}