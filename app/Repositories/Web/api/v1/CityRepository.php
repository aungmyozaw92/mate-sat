<?php

namespace App\Repositories\Web\api\v1;

use App\Models\City;
use App\Repositories\BaseRepository;

class CityRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return City::class;
    }

    public function getAllCities()
    {
        $cities = City::with(['zones'])->orderBy('created_at','desc');
         if (request()->has('paginate')) {
            $cities = $cities->paginate(request()->get('paginate'));
        } else {
            $cities = $cities->get();
        }
        return $cities;
    }

    /**
     * @param array $data
     *
     * @return City
     */
    public function create(array $data) : City
    {
        $city = City::create([
            'name'   => $data['name'],
            'mm_name'   => $data['mm_name'],
            'is_available'   => isset($data['is_available']) ? $data['is_available'] : true,
            'created_by' => auth()->user()->id
        ]);
        return $city;
    }

    /**
     * @param City  $city
     * @param array $data
     *
     * @return mixed
     */
    public function update(City $city, array $data) : City
    {
        $city->name = isset($data['name']) ? $data['name'] : $city->name ;
        $city->mm_name = isset($data['mm_name']) ? $data['mm_name'] : $city->mm_name ;
        $city->is_available = isset($data['is_available']) ? $data['is_available'] : $city->is_available ;
        
        if ($city->isDirty()) {
            $city->updated_by = auth()->user()->id;
            $city->save();
        }
        return $city->refresh();
    }

    /**
     * @param City $city
     */
    public function destroy(City $city)
    {
        $deleted = $this->deleteById($city->id);

        if ($deleted) {
            $city->deleted_by = auth()->user()->id;
            $city->save();
        }
    }
}
