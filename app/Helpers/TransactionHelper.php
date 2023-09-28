<?php


// TransactionHelper.php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionHelper
{
    public static function executeTransaction($callback)
    {
        DB::beginTransaction();

        try {
            $result = $callback();
            DB::commit();
            // Log a success message
            Log::info('Transaction succeeded.');
            return $result;
        } catch (\Exception $e) {
            DB::rollback();
            // You can handle the exception or log it here

            // Log an error message
            Log::error('Transaction failed');

            // throw $e;
        }
    }
}
