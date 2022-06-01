<?php

namespace App\Http\Controllers\Web\Api\v1;

use App\Models\BankInformation;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Services\Web\api\v1\BankInformationService;
use App\Http\Requests\Web\BankInformation\CreateBankInformationRequest;
use App\Http\Requests\Web\BankInformation\UpdateBankInformationRequest;
use App\Http\Resources\Web\api\v1\BankInformation\BankInformationResource;
use App\Http\Resources\Web\api\v1\BankInformation\BankInformationCollection;

class BankInformationController extends Controller
{
    /**
     * @var BankInformationService
     */
    protected $bank_informationService;

    /**
     * BankInformationController constructor.
     *
     * @param BankInformationService $bank_informationService
     */
    public function __construct(BankInformationService $bank_informationService)
    {
        $this->bank_informationService = $bank_informationService;
        $this->middleware('permission:bank_information-list|bank_information-create|bank_information-edit|bank_information-delete', ['only' => ['index','show']]);
        $this->middleware('permission:bank_information-create', ['only' => ['create','store']]);
        $this->middleware('permission:bank_information-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:bank_information-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bank_informations = $this->bank_informationService->getBankInformations();
        return new BankInformationCollection($bank_informations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBankInformationRequest $request)
    {
        $bank_information = $this->bank_informationService->create($request->all());
        return new BankInformationResource($bank_information->load(['bank']));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BankInformation $bank_information)
    {
        return new BankInformationResource($bank_information->load(['bank']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBankInformationRequest $request, BankInformation $bank_information)
    {
        $this->bank_informationService->update($bank_information, $request->all());
        return new BankInformationResource($bank_information->load(['bank']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankInformation $bank_information)
    {
        $this->bank_informationService->destroy($bank_information);
        return response()->json(['status' => 1,'message' => 'Successful deleted'], Response::HTTP_OK);
    }
}
