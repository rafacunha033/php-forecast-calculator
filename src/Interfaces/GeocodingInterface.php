<?php

namespace PhpForecast\Interfaces;

interface GeocodingInterface
{
    public function fetchCoordinatesAndTimezone(string $city);
}