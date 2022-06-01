<?php

namespace App\Exports;

use App\Models\Journal;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Services\Web\api\v1\JournalService;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class TransactionHistory implements FromCollection, WithTitle, WithHeadings, WithMapping
{

    public function collection()
    {
        $data = request()->only(['account_id','paginate','start_date','end_date']);
        if(!$data['account_id']){
            $data['account_id'] = auth()->user()->account->id;
        }
        $journals = Journal::with(['resourceable'])
                            ->where('account_id', $data['account_id'])
                            ->filter($data)
                            ->orderBy('created_at','desc')
                            ->get();
        return $journals;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Transaction History';
    }

    public function map($row): array
    {
        return [
            $row->journal_no,
            $row->type,
            $row->resourceable_type,
            $row->resourceable_id,
            $row->resourceable,
            $row->credit_amount,
            $row->debit_amount,
            $row->balance,
            $row->status
        ];
    }

    public function headings(): array
    {
        return [
            'journal_no',
            'type',
            'resourceable_type',
            'resourceable_id',
            'resourceable',
            'credit_amount',
            'debit_amount',
            'balance',
            'status',
        ];
    }
}