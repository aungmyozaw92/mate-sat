<?php

namespace App\Http\Controllers\Web\Api\v1;

use App\Models\BottleReturn;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Services\Web\api\v1\BottleReturnService;
use App\Http\Requests\Web\BottleReturn\UpdateBottleReturnRequest;
use App\Http\Resources\Web\api\v1\BottleReturn\BottleReturnResource;
use App\Http\Resources\Web\api\v1\BottleReturn\BottleReturnCollection;

class BottleReturnController extends Controller
{
    /**
     * @var BottleReturnService
     */
    protected $bottleReturnService;

    /**
     * AgentController constructor.
     *
     * @param BottleReturnService $bottleReturnService
     */
    public function __construct(BottleReturnService $bottleReturnService
                                )
    {
        $this->bottleReturnService = $bottleReturnService;
        $this->middleware('permission:bottle_return-list|bottle_return-create|bottle_return-edit|bottle_return-delete', ['only' => ['index','show']]);
        $this->middleware('permission:bottle_return-create', ['only' => ['create','store']]);
        $this->middleware('permission:bottle_return-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:bottle_return-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bottle_returns = $this->bottleReturnService->getBottleReturns();
        return new BottleReturnCollection($bottle_returns);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BottleReturn $bottleReturn)
    {
        return new BottleReturnResource($bottleReturn->load(['sale','customer','product','bottle_return_histories']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBottleReturnRequest $request, BottleReturn $bottleReturn)
    {
        if($bottleReturn->status){
            return response()->json([
                'status' => 2,
                'message' => 'All bottle have been returned'
            ], Response::HTTP_OK);
        }
        if($request['returned_bottle'] > $bottleReturn->remain_bottle){
            return response()->json([
                'status' => 2,
                'message' => 'Return bottle qty less than remaing bottle'
            ], Response::HTTP_OK);
        }
        $this->bottleReturnService->update($bottleReturn, $request->all());
        return new BottleReturnResource($bottleReturn->load(['sale','customer','product','bottle_return_histories']));
    }
}
