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


}