<?php 

namespace PhpWeather\Interfaces;

interface SupplierHydratorInterface {
    public function hydrate($data);
}