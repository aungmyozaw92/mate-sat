<?php

namespace App\Services\Interfaces;

use App\Models\Bank;

interface BankServiceInterface
{
    public function getBanks();
    public function getBank($id);
    public function create(array $data);
    public function update(Bank $bank,array $data);
    public function destroy(Bank $bank);
}