<?php

namespace PhpWeather\Interfaces;

interface GeocodingInterface
{
    public function fetchCoordinates(string $city);
}