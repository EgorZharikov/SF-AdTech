<?php

namespace App\Services;

use App\Models\Wallet;

class WalletService
{
    public static function update($walletId, $balance)
    {
        $wallet = Wallet::find($walletId);
        $wallet->balance = $balance;
        $wallet->save();

    }
}
