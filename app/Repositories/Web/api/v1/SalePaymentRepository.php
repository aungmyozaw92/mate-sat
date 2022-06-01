<?php

namespace App\Repositories\Web\api\v1;

use App\Models\SalePayment;
use App\Repositories\BaseRepository;

class SalePaymentRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return SalePayment::class;
    }

    public function getSales()
    {
        $sales = SalePayment::filter(request()->all())->orderBy('created_at','desc');
         if (request()->has('paginate')) {
            $sales = $sales->paginate(request()->get('paginate'));
        } else {
            $sales = $sales->get();
        }
        return $sales;
    }

    /**
     * @param array $data
     *
     * @return SalePayment
     */
    public function create_payment($sale, array $data)
    {
        $sale_payment = SalePayment::create([
            'sale_id'   => $sale->id,
            'payment_method' => $data['payment_method'],
            'payment_amount' => $data['amount'],
            'payment_reference' => isset($data['payment_reference']) ? $data['payment_reference'] : null,
            // 'payment_status' => 'paid',
            'note'   => isset($data['note']) ? $data['note'] : null,
            'created_by' => auth()->user()->id,
        ]);

         return $sale_payment->refresh();
    }

}
