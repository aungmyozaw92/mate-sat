<?php

namespace App\Http\Controllers\Web\Api\v1;

use App\Models\Zone;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Services\Web\api\v1\ZoneService;
use App\Http\Requests\Web\Zone\CreateZoneRequest;
use App\Http\Requests\Web\Zone\UpdateZoneRequest;
use App\Http\Resources\Web\api\v1\Zone\ZoneResource;
use App\Http\Resources\Web\api\v1\Zone\ZoneCollection;

class ZoneController extends Controller
{
    /**
     * @var ZoneService
     */
    protected $zoneService;

    /**
     * AgentController constructor.
     *
     * @param ZoneService $zoneService
     */
    public function __construct(ZoneService $zoneService)
    {
        $this->zoneService = $zoneService;
        $this->middleware('permission:zone-list|zone-create|zone-edit|zone-delete', ['only' => ['index','show']]);
        $this->middleware('permission:zone-create', ['only' => ['create','store']]);
        $this->middleware('permission:zone-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:zone-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $zones = $this->zoneService->getAllZones();
        return new ZoneCollection($zones);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateZoneRequest $request)
    {
        $zone = $this->zoneService->create($request->all());
        return new ZoneResource($zone->load(['city']));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Zone $zone)
    {
        return new ZoneResource($zone->load(['city']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateZoneRequest $request, Zone $zone)
    {
        $this->zoneService->update($zone, $request->all());
        return new ZoneResource($zone->load(['city']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zone $zone)
    {
        $this->zoneService->destroy($zone);
        return response()->json(['status' => 1,'message' => 'Successful deleted'], Response::HTTP_OK);
    }
}
