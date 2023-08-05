<?php 

namespace PhpWeather;

use InvalidArgumentException;
use PhpWeather\Interfaces\GeocodingInterface;
use PhpWeather\Interfaces\WeatherSupplierInterface;

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

        return $this->forecasts;
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