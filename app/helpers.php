<?php

use App\Models\Account;
use App\Models\LogStatus;
use Illuminate\Support\Facades\Crypt;
/*
 * Global helpers file with misc functions.
 */

if (!function_exists('include_route_files')) {

    /**
     * Loops through a folder and requires all PHP files
     * Searches sub-directories as well.
     *
     * @param $folder
     */
    function include_route_files($folder)
    {
        try {
            $rdi = new recursiveDirectoryIterator($folder);
            $it = new recursiveIteratorIterator($rdi);

            while ($it->valid()) {
                if (!$it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
                    require $it->key();
                }

                $it->next();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

if (!function_exists('getStatusId')) {
    function getStatusId($status)
    {
        return LogStatus::statusValue($status)->first()->id;
    }
}

if (!function_exists('transformedOrdersAttribute')) {
    function transformedOrdersAttribute($index, $previous, $next)
    {
        $attributes = [
            'note' =>  ['status' => 'change_order_note', 'previous' => $previous, 'next' => $next],
            'customer_name' =>  ['status' => 'change_order_customer', 'previous' => $previous, 'next' => $next],
            'total_overall_discount' =>  ['status' => 'change_order_total_overall_discount', 'previous' => $previous, 'next' => $next],
        ];
        // customer changes
        $attributes['note'] = ['status' => 'change_order_note', 'previous' => $previous, 'next' => $next];
        $attributes['customer_name'] = ['status' => 'change_order_customer', 'previous' => $previous, 'next' => $next];
        $attributes['total_overall_discount'] = ['status' => 'change_order_total_overall_discount', 'previous' => $previous, 'next' => $next];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
if (!function_exists('transformedOrderItemsAttribute')) {
    function transformedOrderItemsAttribute($index, $previous, $next)
    {
        $attributes = [
            'product_name' =>  ['status' => 'change_order_item_product', 'previous' => $previous, 'next' => $next],
            'qty' =>  ['status' => 'change_order_item_qty', 'previous' => $previous, 'next' => $next],
            'discount_amount' =>  ['status' => 'change_order_item_discount', 'previous' => $previous, 'next' => $next],
        ];
        // customer changes
        $attributes['product_name'] = ['status' => 'change_order_item_product', 'previous' => $previous, 'next' => $next];
        $attributes['qty'] = ['status' => 'change_order_item_qty', 'previous' => $previous, 'next' => $next];
        $attributes['discount_amount'] = ['status' => 'change_order_item_discount', 'previous' => $previous, 'next' => $next];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
