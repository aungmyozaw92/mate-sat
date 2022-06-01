<?php

namespace App\Services\Interfaces;

use App\Models\BottleReturn;

interface BottleReturnServiceInterface
{
    public function getBottleReturns();
    public function getBottleReturn($id);
    public function update(BottleReturn $bottleReturn,array $data);
}