<?php

namespace PhpForecast\Interfaces;

interface WeatherSupplierInterface {
    public function fetchForecast($latitude, $longitude);
}