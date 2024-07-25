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
        $wallet = Wallet::where('id', $walletId);
        $wallet->balance = $wallet->balance - $value;
        $wallet->save();
        $wallet->refresh();
    }

    public static function checkBalance(int $wallet_id, float $limit) 
    {
        $wallet = Wallet::where('id', $wallet_id)->first();
        $walletBalance = $wallet->balance;
        if($walletBalance > $limit){
            return true;
        } else {
            return false;
        }
    }

}
