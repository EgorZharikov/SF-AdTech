<?php

namespace App\Services;

use App\Models\Wallet;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        $wallet = Wallet::where('id', $walletId)->first();
        $wallet->balance = $wallet->balance - $value;
        $wallet->save();
        $wallet->refresh();
    }

    public static function checkBalance(int $wallet_id, float $limit)
    {
        $wallet = Wallet::where('id', $wallet_id)->first();
        $walletBalance = $wallet->balance;
        if ($walletBalance > $limit) {
            return true;
        } else {
            return false;
        }
    }

    public static function withdraw(float $value)
    {
        $wallet = Wallet::where('user_id', Auth::id())->first();
        $systemWallet = Wallet::where('system_code', 101)->first();
        $hash = Str::random(36);
        if ($wallet->balance >= $value) {
            try {
                DB::beginTransaction();
                self::debiting($wallet->id, $value);
                TransactionService::store($wallet->id, 222, 'withdraw', $value, $hash);
                self::debiting($systemWallet->id, $value);
                TransactionService::store($systemWallet->id, 301, 'withdraw_from_wallet_' . $wallet->id, $value, $hash);

                DB::commit();
                return redirect()->back();
            } catch (\Exception $exception) {
                DB::rollBack();
                return $exception->getMessage();
            }
        } else {
           return back()->withErrors(['walletError' => 'Insufficient funds!']);
        }
    }

    public static function replenish(float $value)
    {
        $wallet = Wallet::where('user_id', Auth::id())->first();
        $systemWallet = Wallet::where('system_code', 101)->first();

        $hash = Str::random(36);

        try {
            DB::beginTransaction();
            self::replenishment($wallet->id, $value);
            TransactionService::store($wallet->id, 111, 'replenish', $value, $hash);
            self::replenishment($systemWallet->id, $value);
            TransactionService::store($systemWallet->id, 303, 'replenish_wallet_' . $wallet->id, $value, $hash);

            DB::commit();

            return redirect()->back();
        } catch (\Exception $exception) {
            DB::rollBack();
            return $exception->getMessage();
        }
    }
}
