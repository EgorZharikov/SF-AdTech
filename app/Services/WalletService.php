<?php

namespace App\Services;

use App\Models\Wallet;

class WalletService
{
    public static function replenishment(int $walletId, float $value)
    {
        $wallet = Wallet::find($walletId);
        $wallet->balance = $wallet->balance + $value;
        $wallet->save();
        $wallet->refresh();

    }

    public static function debiting(int $walletId, float $value)
    {
        $wallet = Wallet::find($walletId);
        $wallet->balance = $wallet->balance - $value;
        $wallet->save();
        $wallet->refresh();
    }
}
