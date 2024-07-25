<?php

namespace App\Services;

use App\Models\Fee;
use App\Models\User;
use App\Models\Offer;
use App\Models\Wallet;
use App\Models\Redirect;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RedirectService
{

    public function process($referal_link, $request)
    {
        $subscription = Subscription::where('referal_link', $referal_link)->with('offer')->first();
        $offerStatus = $subscription->offer->status;
        $redirectUrl = $subscription->offer->url;
        $uniqueIpOnly = $subscription->offer->unique_ip;
        $clientIp = ip2long($request->getClientIp());
        $data = ['subscription_id' => $subscription->id, 'ip' => $clientIp];
        $isUniqueIp = Redirect::where('ip', $clientIp)->doesntExist();

        if ($offerStatus) {
            if ($uniqueIpOnly) {
                if ($isUniqueIp) {
                    $this->store($data, true, $referal_link);
                     return redirect()->away($redirectUrl);
                } else {
                    $this->store($data, false, $referal_link);
                     return abort(404);
                }
            } else {
                $this->store($data, true, $referal_link);
                return redirect()->away($redirectUrl);
            }
        } else {
            $this->store($data, false, $referal_link);
            return abort(404);
        }
    }

    private function store(array $data, bool $status, $referal_link)
    {
        $subscription = Subscription::where('referal_link', $referal_link)->with('user.wallet')->first();
        $webmasterWalletId = $subscription->user->wallet->id;
        $offer = Offer::find($subscription->offer_id)->with('user.wallet')->first();
        $advertiserWalletId = $offer->user->wallet->id;
        $systemWallet1Id = Wallet::where('system_code', 101)->first()->id;
        $systemWallet2Id = Wallet::where('system_code', 102)->first()->id;
        $offerAward = $offer->award;
        $fee = Fee::find($subscription->user->fee_id)->percent;
        $systemProfit = $offerAward * ($fee / 100);
        $webmasterProfit = $offerAward - $systemProfit;
        $hash = Str::random(36);

        try {
            DB::beginTransaction();

            if ($status) {
                WalletService::debiting($advertiserWalletId, $offerAward);
                TransactionService::store($advertiserWalletId, 'debiting_offer_award', $offerAward, $hash);
                WalletService::replenishment($webmasterWalletId, $webmasterProfit);
                TransactionService::store($webmasterWalletId, 'replenishment_offer_award', $offerAward, $hash);
                WalletService::replenishment($systemWallet2Id, $systemProfit);
                TransactionService::store($systemWallet2Id, 'replenishment_fee', $offerAward, $hash);
            }
            Redirect::create([
                'subscription_id' => $data['subscription_id'],
                'ip' => $data['ip'],
                'status' => $status,
            ]);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return $exception->getMessage();
        }
    }
}
