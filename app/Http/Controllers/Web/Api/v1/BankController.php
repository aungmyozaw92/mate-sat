<?php

namespace App\Http\Controllers\Web\Api\v1;

use App\Models\Bank;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Services\Web\api\v1\BankService;
use App\Http\Requests\Web\Bank\CreateBankRequest;
use App\Http\Requests\Web\Bank\UpdateBankRequest;
use App\Http\Resources\Web\api\v1\Bank\BankResource;
use App\Http\Resources\Web\api\v1\Bank\BankCollection;

class BankController extends Controller
{
    /**
     * @var BankService
     */
    protected $bankService;

    /**
     * BankController constructor.
     *
     * @param BankService $bankService
     */
    public function __construct(BankService $bankService)
    {
        $this->bankService = $bankService;
        $this->middleware('permission:bank-list|bank-create|bank-edit|bank-delete', ['only' => ['index','show']]);
        $this->middleware('permission:bank-create', ['only' => ['create','store']]);
        $this->middleware('permission:bank-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:bank-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks = $this->bankService->getBanks();
        return new BankCollection($banks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBankRequest $request)
    {
        $bank = $this->bankService->create($request->all());
        return new BankResource($bank);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        return new BankResource($bank);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBankRequest $request, Bank $bank)
    {
        $this->bankService->update($bank, $request->all());
        return new BankResource($bank);
    }
}
