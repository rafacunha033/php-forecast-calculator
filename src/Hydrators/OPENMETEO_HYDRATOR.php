<?php 

namespace PhpForecast\Hydrators;

use PhpForecast\Interfaces\SupplierHydratorInterface;

class OPENMETEO_HYDRATOR implements SupplierHydratorInterface
{
    public function hydrate($data)
    {
        $dailyForecast = $data["daily"];
        $daysCount = count($dailyForecast["time"]);

        $responseArray = [];
        for($i = 0; $i < $daysCount ; $i++) {
            $responseArray[$dailyForecast["time"][$i]] = [
                "temperature_max" => $dailyForecast["temperature_2m_max"][$i],
                "temperature_min" => $dailyForecast["temperature_2m_min"][$i]
            ];
        }

        return $responseArray;
    }
}