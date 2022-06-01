<?php

namespace App\Services\Web\api\v1;

use Exception;
use App\Models\Sale;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Web\api\v1\SaleRepository;
use App\Repositories\Web\api\v1\AccountRepository;
use App\Repositories\Web\api\v1\SalePaymentRepository;
use App\Services\Interfaces\SaleServiceInterface;

class SaleService implements SaleServiceInterface
{
    protected $saleRepository;
    protected $salePaymentRepository;

    public function __construct(SaleRepository $saleRepository,
    SalePaymentRepository $salePaymentRepository)
    {
        $this->saleRepository = $saleRepository;
        $this->salePaymentRepository = $salePaymentRepository;
    }

    public function getSales()
    {
        return $this->saleRepository->getSales();
    }

    public function getSale($id)
    {
        return $this->saleRepository->getSale($id);
    }
    
    public function create(array $data)
    {       
        DB::beginTransaction();
        try {
            $sale = $this->saleRepository->create($data);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to create Sale');
        }
        DB::commit();

        return $sale;
    }

    public function create_sale_payment(Sale $sale,array $data)
    {
        $responses = ['status' => 2,'data' => null];
        if($sale->status === 'completed' && $sale->payment_status === 'paid'){
            $responses['message'] = 'This sale invoice is already complete and paid';
            return $responses;
        }
       
        if(($sale->grand_total - $sale->paid_amount) < $data['amount']){
            $responses['message'] = 'Please enter less than or equal amount';
            return $responses;
        }
        DB::beginTransaction();
        try {
            $result = $this->salePaymentRepository->create_payment($sale, $data);
            if($result){
                if(($data['amount'] + $sale->paid_amount) == $sale->grand_total){
                    $sale->status = 'completed';
                    $sale->payment_status = 'paid';
                }else{
                    $sale->status = 'outstanding';
                }
                $sale->paid_amount += $data['amount'];
                $sale->save();
            }
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to update Order');
        }
        DB::commit();


         $responses = ['status' => 1,'data' => $sale->refresh(),'message' => "Success"];
        return $responses;
    }

    public function getDailySales()
    {
        return $this->saleRepository->getDailySales();
    }
    
    public function getDailySale()
    {
        return $this->saleRepository->getDailySale();
    }

    public function getWeeklySale()
    {
        return $this->saleRepository->getWeeklySale();
    }
    
    public function getSaleSummary()
    {
        return $this->saleRepository->getSaleSummary();
    }

}