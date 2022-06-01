<?php

namespace App\Repositories\Web\api\v1;

use App\Models\Bank;
use App\Repositories\BaseRepository;

class BankRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Bank::class;
    }

    public function getBanks()
    {
        $banks = Bank::orderBy('id','asc');
         if (request()->has('paginate')) {
            $banks = $banks->paginate(request()->get('paginate'));
        } else {
            $banks = $banks->get();
        }
        return $banks;
    }

    /**
     * @param array $data
     *
     * @return Bank
     */
    public function create(array $data) : Bank
    {
        $bank = Bank::create([
            'name'   => $data['name'],
            // 'created_by_id' => auth()->user()->id,
            // 'created_by_type' => class_basename(auth()->user()->getModel())
        ]);

        return $bank;
    }

    /**
     * @param Bank  $bank
     * @param array $data
     *
     * @return mixed
     */
    public function update(Bank $bank, array $data) : Bank
    {
        $bank->name = isset($data['name']) ? $data['name'] : $bank->name;
       
        if ($bank->isDirty()) {
            // $bank->updated_by_id = auth()->user()->id;
            // $bank->updated_by_type = class_basename(auth()->user()->getModel());
            $bank->save();
        }
        return $bank->refresh();
    }

    /**
     * @param Bank $bank
     */
    public function destroy(Bank $bank)
    {
        $deleted = $this->deleteById($bank->id);

        if ($deleted) {
            // $bank->deleted_by_id = auth()->user()->id;
            // $bank->deleted_by_type = class_basename(auth()->user()->getModel());
            $bank->save();
        }
    }
}
