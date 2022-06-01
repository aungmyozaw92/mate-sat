<?php

namespace App\Jobs;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateJournalJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $transaction;
    protected $transfer_type;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction, $transfer_type)
    {
        $this->transaction = $transaction;
        $this->transfer_type = $transfer_type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       
    }
}

