<?php

namespace App\Services;

use App\Models\Redirect;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Wallet;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RedirectService
{

    public function process($referal_link)
    {
        /**
         * Create a new request instance.
         *
         * @var Request $request
         */

        $subscription = Subscription::where('referal_link', $referal_link)->with('offer')->first();
        $offerStatus = $subscription->offer->status;
        $uniqueIpOnly = $subscription->offer->unique_ip;
        $clientIp = ip2long($request->getClientIp());
        $data = ['subscription_id' => $subscription->id, 'ip' => $clientIp];
        $isUniqueIp = Redirect::where('ip', $clientIp)->doesntExist();
        if ($offerStatus) {
            if ($uniqueIpOnly) {
                if ($isUniqueIp) {
                    DB::beginTransaction();
                    try{
                    $this->store($data, true);
                    DB::commit();
                    } catch (\Exception $exception) {
                        DB::rollBack();
                        return $exception->getMessage();
                    }
                } else {
                    DB::beginTransaction();
                    try {
                        $this->store($data, false);
                        DB::commit();
                    } catch (\Exception $exception) {
                        DB::rollBack();
                        return $exception->getMessage();
                    }
                }
            } else {
                DB::beginTransaction();
                try {
                    $this->store($data, true);
                    DB::commit();
                } catch (\Exception $exception) {
                    DB::rollBack();
                    return $exception->getMessage();
                }
            }
        } else {
            DB::beginTransaction();
            try {
                $this->store($data, false);
                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
                return $exception->getMessage();
            }
        }
    }

    private function store(array $data, bool $status, $referal_link)
    {
        if($status) {
            $advertiserWalletId = Subscription::where('') 
            WalletService::update()
        }
        Redirect::create([
            'subscription_id' => $data['subscription_id'],
            'fee_id' => 1,
            'ip' => $data['ip'],
            'status' => $status,
        ]);
    }
}
