<?php

namespace App\Services\Web\api\v1;

use Exception;
use App\Models\Zone;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Web\api\v1\ZoneRepository;
use App\Services\Interfaces\ZoneServiceInterface;

class ZoneService implements ZoneServiceInterface
{
    protected $zoneRepository;

    public function __construct(ZoneRepository $zoneRepository)
    {
        $this->zoneRepository = $zoneRepository;
    }

    public function getAllZones()
    {
        return $this->zoneRepository->getAllZones();
    }

    public function getZones()
    {
        return $this->zoneRepository->getZones();
    }

    public function getZone($id)
    {
        return $this->zoneRepository->getZone($id);
    }
    
    public function create(array $data)
    {        
        return $this->zoneRepository->create($data);
    }

    public function update(Zone $zone,array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->zoneRepository->update($zone, $data);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to update Zone');
        }
        DB::commit();

        return $result;
    }

    public function destroy(Zone $zone)
    {
        DB::beginTransaction();
        try {
            $result = $this->zoneRepository->destroy($zone);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to delete Zone');
        }
        DB::commit();
        
        return $result;
    }

}