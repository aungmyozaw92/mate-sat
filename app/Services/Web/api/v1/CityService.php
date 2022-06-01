<?php

namespace App\Services\Web\api\v1;

use Exception;
use App\Models\City;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Web\api\v1\CityRepository;
use App\Services\Interfaces\CityServiceInterface;

class CityService implements CityServiceInterface
{
    protected $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function getAllCities()
    {
        return $this->cityRepository->getAllCities();
    }

    public function getCities($request)
    {
        return $this->cityRepository->getAllCities();
    }

    public function getCity($id)
    {
        return $this->cityRepository->getCity($id);
    }
    
    public function create(array $data)
    {        
        return $this->cityRepository->create($data);
    }

    public function update(City $city,array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->cityRepository->update($city, $data);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to update City');
        }
        DB::commit();

        return $result;
    }

    public function destroy(City $city)
    {
        DB::beginTransaction();
        try {
            $result = $this->cityRepository->destroy($city);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to delete City');
        }
        DB::commit();
        
        return $result;
    }

}