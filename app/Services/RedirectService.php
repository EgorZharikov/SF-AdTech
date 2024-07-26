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
    private $subscription, $offer, $webmaster, $webmasterWalletId,
        $advertiser, $advertiserWalletId, $request, $referalLink;

    public function __construct($referalLink, $request)
    {
        $this->$referalLink = $referalLink;
        $this->request = $request;
        $this->subscription = Subscription::where('referal_link', $referalLink);
        $this->offer = $this->subscription->with('offer')->first()->offer;
        $this->webmaster = $this->subscription->with('user.wallet')->first();
        $this->advertiser = $this->subscription->with('offer.user.wallet')->first();
        $this->webmasterWalletId = $this->webmaster->user->wallet->id;
        $this->advertiserWalletId = $this->advertiser->offer->user->wallet->id;
    }
    public function process()
    {
        WalletService::checkBalance($this->advertiserWalletId, $this->offer->award) ?:
            OfferService::statusChange($this->offer->id);
        $this->offer->refresh();

        $subscriptionId = $this->subscription->first()->id;
        $redirectUrl = $this->offer->url;
        $uniqueIpOnly = $this->offer->unique_ip;
        $clientIp = ip2long($this->request->getClientIp());
        $data = ['subscription_id' => $subscriptionId, 'ip' => $clientIp];
        $isUniqueIp = Redirect::where('ip', $clientIp)->where('subscription_id', $subscriptionId)->doesntExist();

        $offerStatus = ($this->offer->status) === 1 ? true : false;
        
        if ($offerStatus) {
            if ($uniqueIpOnly) {
                if ($isUniqueIp) {
                    $this->store($data, true);
                    return redirect()->away($redirectUrl);
                } else {
                    $this->store($data, false);
                    return abort(404);
                }
            } else {
                $this->store($data, true);
                return redirect()->away($redirectUrl);
            }
        } else {
            $this->store($data, false);
            return abort(404);
        }
    }

    private function store(array $data, bool $status)
    {
        $systemWallet2Id = Wallet::where('system_code', 102)->first()->id;
        $offerAward = $this->offer->award;
        $fee = Fee::find($this->webmaster->user->fee_id)->percent;
        $systemProfit = $offerAward * ($fee / 100);
        $webmasterProfit = $offerAward - $systemProfit;
        $hash = Str::random(36);

        try {
            DB::beginTransaction();

            if ($status) {
                WalletService::debiting($this->advertiserWalletId, $offerAward);
                TransactionService::store($this->advertiserWalletId, 'debiting_offer_award', $offerAward, $hash);
                WalletService::replenishment($this->webmasterWalletId, $webmasterProfit);
                TransactionService::store($this->webmasterWalletId, 'replenishment_offer_award', $webmasterProfit, $hash);
                WalletService::replenishment($systemWallet2Id, $systemProfit);
                TransactionService::store($systemWallet2Id, 'replenishment_fee', $systemProfit, $hash);
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
