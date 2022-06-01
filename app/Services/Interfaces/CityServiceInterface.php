<?php

namespace App\Services\Interfaces;

use App\Models\City;

interface CityServiceInterface
{
    public function getAllCities();
    public function getCities($request);
    public function getCity($id);
    public function create(array $data);
    public function update(City $city,array $data);
    public function destroy(City $city);
}