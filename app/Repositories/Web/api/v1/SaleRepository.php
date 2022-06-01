<?php

namespace App\Repositories\Web\api\v1;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Order;
use App\Models\SaleItem;
use App\Repositories\BaseRepository;
use App\Repositories\Web\api\v1\SaleItemRepository;

class SaleRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Sale::class;
    }

    public function getSales()
    {
        $sales = Sale::with(['created_user'])->filter(request()->all())->orderBy('created_at','desc');
         if (request()->has('paginate')) {
            $sales = $sales->paginate(request()->get('paginate'));
        } else {
            $sales = $sales->get();
        }
        return $sales;
    }

    public function getDailySales()
    {
        $sales = Sale::where('status', 'completed')
                     ->where('payment_status', 'paid')
                     ->dailySaleFilter(request()->all())
                 ->selectRaw("
                            sales.*,
                            SUM(CASE sale_payments.payment_method WHEN 'Cash' THEN payment_amount ELSE 0 END) AS cash_amount,
                            SUM(CASE sale_payments.payment_method WHEN 'KBZ Bank' THEN payment_amount ELSE 0 END) AS kbz_amount,
                            SUM(CASE sale_payments.payment_method WHEN 'KBZ PAY' THEN payment_amount ELSE 0 END) AS kpay_amount,
                            SUM(CASE sale_payments.payment_method WHEN 'CB PAY' THEN payment_amount ELSE 0 END) AS cb_pay_amount,
                            SUM(CASE sale_payments.payment_method WHEN 'CB Bank' THEN payment_amount ELSE 0 END) AS cb_amount,
                            SUM(CASE sale_payments.payment_method WHEN 'AYA PAY' THEN payment_amount ELSE 0 END) AS aya_pay_amount,
                            SUM(CASE sale_payments.payment_method WHEN 'AYA Bank' THEN payment_amount ELSE 0 END) AS aya_amount,
                            SUM(CASE sale_payments.payment_method WHEN 'WavePay' THEN payment_amount ELSE 0 END) AS wave_pay_amount
                ")
                ->join('sale_payments', 'sale_payments.sale_id', '=', 'sales.id')
                ->groupBy('sales.id')
                ->get();
        return $sales;
    }

    public function getCustomerSales($customer)
    {
        $sales = Sale::where('customer_id',$customer->id)
                    ->filter(request()->all())
                    ->orderBy('created_at','desc');
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
     * @return Sale
     */
    public function create(array $data)
    {
        $responses = ['status' => 2,'data' => null];
        $order = Order::findOrFail($data['order_id']);
        if ($order->status) {
            $responses['message'] = 'Order is already sale invoice';
            return $responses;
        }
        $sale = Sale::create([
            'order_id'   => $order->id,
            'customer_id'   => $order->customer_id,
            'customer_name'   => $order->customer_name,
            'customer_phone'   => $order->customer_phone,
            'customer_address'   => $order->customer_address,
            'customer_city_name'   => $order->customer_city_name,
            'customer_zone_name'   => $order->customer_zone_name,
            'total_qty'   => $order->total_qty,
            'total_amount'   => $order->total_amount,
            'total_discount'   => $order->total_product_discount + $order->total_overall_discount,
            'grand_total'   => $order->grand_total_amount,
            'delivery_address'   => $order->delivery_address,
            'status'   => 'new',
            'payment_status'   => 'outstanding',
            'note'   => isset($data['note']) ? $data['note'] : null,
            'created_by' => auth()->user()->id,
        ]);

            $saleItemRepository = new SaleItemRepository();
            foreach ($order->order_items as $key => $item) {
                $item['sale_id'] = $sale->id;

                $sale_item = $saleItemRepository->create($item);
            }
        
        $order->status = true;
        $order->save();

        $order->customer->sale_count += 1;
        $order->customer->save();
        $responses = ['status' => 1,'data' => $sale->refresh(),'message' => "Success"];
        return $responses;
        // return $sale->refresh();
    }

    public function getWeeklySale()
    {
        $data = Sale::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                        ->completeSaleFilter(request()->all())
                        ->get();
        
        return $data;
    }

    public function getDailySale()
    {
        $data = Sale::whereDate('created_at', date('Y-m-d'))
                        ->completeSaleFilter(request()->all())
                        ->selectRaw('count(id) as count,
                             sum(grand_total) as amount, 
                             DATE(created_at) as day')
                            // ->select(\DB::raw("COUNT(id) AS count,
                            //  DATE(created_at) AS day"))
                    ->groupBy('day')
                    ->first();
        
        return $data;
    }

    public function getSaleSummary()
    {
        $month = date('m');
        $data = Sale::whereMonth('created_at', $month)
                ->completeSaleFilter(request()->all())
                ->selectRaw('count(id) as count,
                             sum(grand_total) as amount, 
                             monthname(created_at) as month')
                            // ->select(\DB::raw("COUNT(id) AS count,
                            //  DATE(created_at) AS day"))
                    ->groupBy('month')
                    ->get();
        
        return $data;
    }

}
