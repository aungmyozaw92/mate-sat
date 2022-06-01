<?php

namespace App\Services\Interfaces;

use App\Models\Sale;

interface SaleServiceInterface
{
    public function getSales();
    public function getDailySales();
    public function getDailySale();
    public function getWeeklySale();
    public function getSaleSummary();
    public function getSale($id);
    public function create(array $data);
    // public function update(Sale $sale,array $data);
    // public function destroy(Sale $sale);
}