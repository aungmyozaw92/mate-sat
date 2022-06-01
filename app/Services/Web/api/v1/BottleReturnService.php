<?php

namespace App\Services\Web\api\v1;

use Exception;
use App\Models\BottleReturn;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Web\api\v1\BottleReturnRepository;
use App\Repositories\Web\api\v1\AccountRepository;
use App\Services\Interfaces\BottleReturnServiceInterface;

class BottleReturnService implements BottleReturnServiceInterface
{
    protected $bottleReturnRepository;

    public function __construct(BottleReturnRepository $bottleReturnRepository)
    {
        $this->bottleReturnRepository = $bottleReturnRepository;
    }

    public function getBottleReturns()
    {
        return $this->bottleReturnRepository->getBottleReturns();
    }

    public function getBottleReturn($id)
    {
        return $this->bottleReturnRepository->getBottleReturn($id);
    }

    public function update(BottleReturn $bottleReturn,array $data)
    {
        // DB::beginTransaction();
        // try {
            $result = $this->bottleReturnRepository->update($bottleReturn, $data);
        // }
        // catch(Exception $exc){
        //     DB::rollBack();
        //     Log::error($exc->getMessage());
        //     throw new InvalidArgumentException('Unable to update BottleReturn');
        // }
        // DB::commit();

        return $result;
    }

}