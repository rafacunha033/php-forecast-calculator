<?php

namespace PhpWeather\Interfaces;

interface GeocodingInterface
{
    public function fetchCoordinatesAndTimezone(string $city);
}