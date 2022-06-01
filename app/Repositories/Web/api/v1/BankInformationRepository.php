<?php

namespace App\Repositories\Web\api\v1;

use App\Models\BankInformation;
use App\Repositories\BaseRepository;

class BankInformationRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return BankInformation::class;
    }

    public function getBankInformations()
    {
        $inofs = BankInformation::with('bank')->orderBy('id','desc');
         if (request()->has('paginate')) {
            $inofs = $inofs->paginate(request()->get('paginate'));
        } else {
            $inofs = $inofs->get();
        }
        return $inofs;
    }
    /**
     * @param array $data
     *
     * @return BankInformation
     */
    public function create(array $data) : BankInformation
    {
        $bank_information = BankInformation::create([
            'account_name'   => $data['account_name'],
            'account_no'   => $data['account_no'],
            'bank_id'   => $data['bank_id'],
            'resourceable_type'   => $data['resourceable_type'],
            'resourceable_id'   => $data['resourceable_id'],
            'is_default'   => isset($data['is_default']) ? $data['is_default'] : false,
            'branch_name'   => isset($data['branch_name']) ? $data['branch_name'] : null,
            'created_by_type'   => class_basename(auth()->user()->getModel()),
            'created_by_id'   => auth()->user()->id
        ]);
        return $bank_information;
    }

    /**
     * @param BankInformation  $bank_information
     * @param array $data
     *
     * @return mixed
     */
    public function update(BankInformation $bank_information, array $data) : BankInformation
    {
        $bank_information->account_name = isset($data['account_name']) ? $data['account_name'] : $bank_information->account_name ;
        $bank_information->account_no = isset($data['account_no']) ? $data['account_no'] : $bank_information->account_no ;
        $bank_information->bank_id = isset($data['bank_id']) ? $data['bank_id'] : $bank_information->bank_id ;
        $bank_information->is_default = isset($data['is_default']) ? $data['is_default'] : $bank_information->is_default ;
        $bank_information->branch_name = isset($data['branch_name']) ? $data['branch_name'] : $bank_information->branch_name ;
        
        if ($bank_information->isDirty()) {
            $bank_information->updated_by_id = auth()->user()->id;
            $bank_information->updated_by_type = class_basename(auth()->user()->getModel());
            $bank_information->save();
        }
        return $bank_information->refresh();
    }

    /**
     * @param BankInformation $bank_information
     */
    public function destroy(BankInformation $bank_information)
    {
        $deleted = $this->deleteById($bank_information->id);

        if ($deleted) {
            $bank_information->deleted_by_id = auth()->user()->id;
            $bank_information->deleted_by_type = class_basename(auth()->user()->getModel());
            $bank_information->save();
        }
    }
}
