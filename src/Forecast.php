<?php 

namespace PhpWeather;

use InvalidArgumentException;
use PhpWeather\Interfaces\WeatherSupplierInterface;
use PhpWeather\Suppliers\OPENMETEO;

class Forecast
{
    /** @var \Suppliers\OPENMETEO */
    public $openMeteo;

    /** @var array */
    public $forecasts;

    public $data;

    /** @var array */
    public $suppliers;

    public function __construct()
    {
        $this->openMeteo = new OPENMETEO;
    }

    public function addSupplier($supplier)
    {
        if (!$supplier instanceof WeatherSupplierInterface) { 
            return throw new InvalidArgumentException("Given Supplier is not valid.");
        }

        $this->suppliers[] = $supplier;
    }

    public function fetch($city)  
    {
        if(empty($this->suppliers)) {
            return throw new InvalidArgumentException("You must add at least 1 Supplier. None have been added.");
        }

        foreach($this->suppliers as $supplier) {
            $weatherResponseArray = json_decode($supplier->fetchWeatherInformation($city), true);
            $this->forecasts[] = $weatherResponseArray['current_weather']['temperature'];
        }

        return $this->forecasts;

    }

}