<?php

namespace App\Services\Interfaces;

use App\Models\Region;

interface RegionServiceInterface
{
    public function getRegions();
    public function getRegion($id);
    public function create(array $data);
    public function update(Region $region,array $data);
    public function destroy(Region $region);
}