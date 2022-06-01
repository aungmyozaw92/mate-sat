<?php

namespace App\Services\Web\api\v1;

use Exception;
use App\Models\Branch;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Web\api\v1\BranchRepository;
use App\Repositories\Web\api\v1\AccountRepository;
use App\Services\Interfaces\BranchServiceInterface;

class BranchService implements BranchServiceInterface
{
    protected $branchRepository;
    protected $accountRepository;

    public function __construct(BranchRepository $branchRepository, AccountRepository $accountRepository)
    {
        $this->branchRepository = $branchRepository;
        $this->accountRepository = $accountRepository;
    }

    public function getBranches()
    {
        return $this->branchRepository->getBranches();
    }

    public function getBranch($id)
    {
        return $this->branchRepository->getBranch($id);
    }
    
    public function create(array $data)
    {       
        DB::beginTransaction();
        try {
            $branch = $this->branchRepository->create($data);
            $account = [
                'account_name' => $branch->name,
                'city_id' => $branch->city_id,
                'zone_id' => $branch->zone_id,
                'accountable_type' => 'Branch',
                'accountable_id' => $branch->id,
            ];
            $account = $this->accountRepository->create($account);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to create branch');
        }
        DB::commit();

        return $branch;
    }

    public function update(Branch $branch,array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->branchRepository->update($branch, $data);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to update Branch');
        }
        DB::commit();

        return $result;
    }

    public function destroy(Branch $branch)
    {
        DB::beginTransaction();
        try {
            $result = $this->branchRepository->destroy($branch);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to delete Branch');
        }
        DB::commit();
        
        return $result;
    }

}