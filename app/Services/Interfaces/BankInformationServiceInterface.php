<?php

namespace App\Services\Interfaces;

use App\Models\BankInformation;

interface BankInformationServiceInterface
{
    public function getBankInformations();
    public function getBankInformation($id);
    public function create(array $data);
    public function update(BankInformation $bank_information,array $data);
    public function destroy(BankInformation $bank_information);
}