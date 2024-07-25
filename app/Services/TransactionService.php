<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Wallet;

class TransactionService
{
    public static function store(int $wallet_id, string $action, float $value, string $hash )
    {
        $Transaction = Transaction::create([
            'wallet_id' => $wallet_id,
            'action' => $action,
            'value' => $value,
            'hash' => $hash,
        ]);
    }

}
