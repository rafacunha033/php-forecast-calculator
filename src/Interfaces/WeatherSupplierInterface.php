<?php

namespace PhpWeather\Interfaces;

interface WeatherSupplierInterface {
    public function fetchForecast($latitude, $longitude);
}