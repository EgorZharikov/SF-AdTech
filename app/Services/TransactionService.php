<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Wallet;

class TransactionService
{
    public static function store(int $wallet_id, int $operationCode, string $action, float $value, string $hash )
    {
        $Transaction = Transaction::create([
            'wallet_id' => $wallet_id,
            'operation_code' => $operationCode,
            'action' => $action,
            'value' => $value,
            'hash' => $hash,
        ]);
    }

}
