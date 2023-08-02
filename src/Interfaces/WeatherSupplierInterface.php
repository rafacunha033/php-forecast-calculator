<?php

namespace PhpWeather\Interfaces;

interface WeatherSupplierInterface {
    public function fetchCurrentWeather(string $city);
    public function fetchCoordinates(string $city);
}