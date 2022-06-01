<?php

namespace App\Services\Interfaces;

use App\Models\Zone;

interface ZoneServiceInterface
{
    public function getAllZones();
    public function getZones();
    public function getZone($id);
    public function create(array $data);
    public function update(Zone $zone,array $data);
    public function destroy(Zone $zone);
}