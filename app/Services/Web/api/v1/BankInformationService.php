<?php

namespace App\Services\Web\api\v1;

use Exception;
use App\Models\BankInformation;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Web\api\v1\BankInformationRepository;
use App\Services\Interfaces\BankInformationServiceInterface;

class BankInformationService implements BankInformationServiceInterface
{
    protected $bank_informationRepository;

    public function __construct(BankInformationRepository $bank_informationRepository)
    {
        $this->bank_informationRepository = $bank_informationRepository;
    }

    public function getBankInformations()
    {
        return $this->bank_informationRepository->getBankInformations();
    }

    public function getBankInformation($id)
    {
        return $this->bank_informationRepository->getBankInformation($id);
    }
    
    public function create(array $data)
    {        
        $result = $this->bank_informationRepository->create($data);
        return $result;
    }

    public function update(BankInformation $bank_information,array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->bank_informationRepository->update($bank_information, $data);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to update BankInformation');
        }
        DB::commit();

        return $result;
    }

    public function destroy(BankInformation $bank_information)
    {
        DB::beginTransaction();
        try {
            $result = $this->bank_informationRepository->destroy($bank_information);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to delete BankInformation');
        }
        DB::commit();
        
        return $result;
    }

}