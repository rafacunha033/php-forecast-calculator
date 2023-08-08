<?php 

namespace PhpForecast;

use InvalidArgumentException;
use PhpForecast\Interfaces\GeocodingInterface;
use PhpForecast\Interfaces\WeatherSupplierInterface;

class Forecast
{
    /** @var \Suppliers\OPENMETEO */
    public $openMeteo;

    /** @var array */
    public $forecasts;

    public $data;

    /** @var array */
    public $suppliers;

    /** @var Interfaces\GeocodingInterface */
    public $geocoding;

    /** @var array */
    public $averageForecast;

    public function __construct()
    {
    }

    public function fetch($city)  
    {
        if(empty($this->suppliers)) {
            return throw new InvalidArgumentException("You must add at least 1 Supplier. None have been added.");
        }

        if(empty($this->geocoding)) {
            return throw new InvalidArgumentException("You must add a geocoding supplier. None have been added.");
        }

        [ $latitude, $longitude, $timezone ] = $this->geocoding->fetchCoordinatesAndTimezone($city);

        foreach($this->suppliers as $supplier) {
            $this->forecasts[] = $supplier->fetchForecast($latitude, $longitude, $timezone);
        }

        return $this->calculate();
    }

    public function calculate()
    {
        if(empty($this->forecasts)) {
            return throw new InvalidArgumentException("There aren't forecasts.");
        }

        $count = (float) count($this->suppliers);
        foreach($this->forecasts as $forecasts) {
            foreach($forecasts as $day => $forecast) {
                if(isset($this->averageForecast[$day])) {
                    $this->averageForecast[$day] = [
                        "temperature_max" => $this->averageForecast[$day]["temperature_max"] + ($forecast["temperature_max"] / $count),
                        "temperature_min" => $this->averageForecast[$day]["temperature_min"] + ($forecast["temperature_min"] / $count),
                    ];
                } else {
                    $this->averageForecast[$day] = [
                        "temperature_max" => $forecast["temperature_max"] / $count,
                        "temperature_min" => $forecast["temperature_min"] / $count
                    ];
                }
            }    
        }

        return $this->averageForecast;
    }

    public function setGeocoding(GeocodingInterface $geocoding)
    {
        $this->geocoding = $geocoding;
    }

    public function addSupplier($supplier)
    {
        if (!$supplier instanceof WeatherSupplierInterface) { 
            return throw new InvalidArgumentException("Given Supplier is not valid.");
        }

        $this->suppliers[] = $supplier;
    }

}