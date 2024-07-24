<?php

namespace App\Services;

use App\Models\User;
use App\Models\Offer;
use App\Models\Wallet;
use App\Models\Redirect;
use App\Models\Subscription;
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
        $subscription = Subscription::where('referal_link', $referal_link)->with('user.wallet')->first();
        $webmasterWalletId = $subscription->user->wallet->id;
        $offer = Offer::find($subscription->offer_id)->with('user.wallet')->first();
        $advertiserWalletId = $offer->user->wallet->id;
        $offer_award = $offer->award;
        $fee = Fee::find($subscription->user->fee_id)->percent;
        
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
            
            
        }
        Redirect::create([
            'subscription_id' => $data['subscription_id'],
            'fee_id' => 1,
            'ip' => $data['ip'],
            'status' => $status,
        ]);
    }
}
