<?php

namespace App\Http\Controllers\Web\Api\v1;

use App\Models\Sale;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Services\Web\api\v1\SaleService;
use App\Http\Requests\Web\Sale\CreateSaleRequest;
use App\Http\Requests\Web\Sale\UpdateSaleRequest;
use App\Http\Resources\Web\api\v1\Sale\SaleResource;
use App\Http\Resources\Web\api\v1\Sale\SaleCollection;
use App\Http\Requests\Web\Sale\CreateSalePaymentRequest;
use App\Http\Resources\Web\api\v1\DailySale\DailySaleCollection;

class SaleController extends Controller
{
    /**
     * @var SaleService
     */
    protected $saleService;

    /**
     * SaleController constructor.
     *
     * @param SaleService $saleService
     */
    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
        $this->middleware('permission:sale-list|sale-create|sale-edit|sale-delete', ['only' => ['index','show']]);
        $this->middleware('permission:sale-create', ['only' => ['create','store']]);
        $this->middleware('permission:sale-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:sale-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = $this->saleService->getSales();
        return new SaleCollection($sales);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSaleRequest $request)
    {
        $response = $this->saleService->create($request->all());
        $data = ($response['status'] === 1) ? new SaleResource($response['data']->load(['sale_items'])) : null;
        
        return response()->json(
            [
                'status' => $response['status'],
                'data' => $data,
                'message' => $response['message']
            ],
            Response::HTTP_OK
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        return new SaleResource($sale->load(['sale_items','sale_payments']));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create_sale_payment(CreateSalePaymentRequest $request, Sale $sale)
    {
        $response = $this->saleService->create_sale_payment($sale, $request->all());
        $data = ($response['status'] === 1) ? new SaleResource($response['data']->load(['sale_items','sale_payments'])) : null;
        
        return response()->json(
            [
                'status' => $response['status'],
                'data' =>$data,
                'message' => $response['message']
            ],
            Response::HTTP_OK
        );
        
        // return new SaleResource($sale->load(['sale_items']));
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dailySales()
    {
        $sales = $this->saleService->getDailySales();
        // return response()->json($sales);
        return new DailySaleCollection($sales);
    }
}
