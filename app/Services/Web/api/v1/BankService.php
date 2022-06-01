<?php

namespace App\Services\Web\api\v1;

use Exception;
use App\Models\Bank;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Web\api\v1\BankRepository;
use App\Repositories\Web\api\v1\AccountRepository;
use App\Services\Interfaces\BankServiceInterface;

class BankService implements BankServiceInterface
{
    protected $bankRepository;

    public function __construct(BankRepository $bankRepository)
    {
        $this->bankRepository = $bankRepository;
    }

    public function getBanks()
    {
        return $this->bankRepository->getBanks();
    }

    public function getBank($id)
    {
        return $this->bankRepository->getBank($id);
    }
    
    public function create(array $data)
    {       
        DB::beginTransaction();
        try {
            $bank = $this->bankRepository->create($data);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to create Bank');
        }
        DB::commit();

        return $bank;
    }

    public function update(Bank $bank,array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->bankRepository->update($bank, $data);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to update Bank');
        }
        DB::commit();

        return $result;
    }

    public function destroy(Bank $bank)
    {
        DB::beginTransaction();
        try {
            $result = $this->bankRepository->destroy($bank);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to delete Bank');
        }
        DB::commit();
        
        return $result;
    }

}