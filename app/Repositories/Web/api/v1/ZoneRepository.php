<?php

namespace App\Repositories\Web\api\v1;

use App\Models\Zone;
use App\Repositories\BaseRepository;

class ZoneRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Zone::class;
    }

    public function getAllZones()
    {
        $zones = Zone::with(['city'])->orderBy('created_at','desc');
         if (request()->has('paginate')) {
            $zones = $zones->paginate(request()->get('paginate'));
        } else {
            $zones = $zones->get();
        }
        return $zones;
    }

    /**
     * @param array $data
     *
     * @return Zone
     */
    public function create(array $data) : Zone
    {
        $zone = Zone::create([
            'name'   => $data['name'],
            'mm_name'   => $data['mm_name'],
            'city_id'   => $data['city_id'],
            'is_available'   => isset($data['is_available']) ? $data['is_availabel'] : true,
            'created_by' => auth()->user()->id
        ]);
        return $zone;
    }

    /**
     * @param Zone  $zone
     * @param array $data
     *
     * @return mixed
     */
    public function update(Zone $zone, array $data) : Zone
    {
        $zone->name = isset($data['name']) ? $data['name'] : $zone->name ;
        $zone->mm_name = isset($data['mm_name']) ? $data['mm_name'] : $zone->mm_name ;
        $zone->city_id = isset($data['city_id']) ? $data['city_id'] : $zone->city_id ;
        $zone->is_available = isset($data['is_available']) ? $data['is_available'] : $zone->is_available ;
       
        if ($zone->isDirty()) {
            $zone->updated_by = auth()->user()->id;
            $zone->save();
        }
        return $zone->refresh();
    }

    /**
     * @param Zone $zone
     */
    public function destroy(Zone $zone)
    {
        $deleted = $this->deleteById($zone->id);

        if ($deleted) {
            $zone->deleted_by = auth()->user()->id;
            $zone->save();
        }
    }
}
