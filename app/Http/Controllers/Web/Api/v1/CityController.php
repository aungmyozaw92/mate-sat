<?php

namespace App\Http\Controllers\Web\Api\v1;

use App\Models\City;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Services\Web\api\v1\CityService;
use App\Http\Requests\Web\City\CreateCityRequest;
use App\Http\Requests\Web\City\UpdateCityRequest;
use App\Http\Resources\Web\api\v1\City\CityResource;
use App\Http\Resources\Web\api\v1\City\CityCollection;

class CityController extends Controller
{
    /**
     * @var CityService
     */
    protected $cityService;

    /**
     * AgentController constructor.
     *
     * @param CityService $cityService
     */
    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
        $this->middleware('permission:city-list|city-create|city-edit|city-delete', ['only' => ['index','show']]);
        $this->middleware('permission:city-create', ['only' => ['create','store']]);
        $this->middleware('permission:city-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:city-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = $this->cityService->getAllCities();
        return new CityCollection($cities);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCityRequest $request)
    {
        $city = $this->cityService->create($request->all());
        return new CityResource($city);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        return new CityResource($city->load(['zones']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCityRequest $request, City $city)
    {
        $this->cityService->update($city, $request->all());
        return new CityResource($city);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $this->cityService->destroy($city);
        return response()->json(['status' => 1,'message' => 'Successful deleted'], Response::HTTP_OK);
    }
}
