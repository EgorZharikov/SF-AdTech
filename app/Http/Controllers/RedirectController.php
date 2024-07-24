<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\Offer;
use App\Models\Redirect;
use App\Models\Subscription;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function redirect($referal_link, Request $request)
    {
        
        $subscription = Subscription::where('referal_link', $referal_link)->with('user.wallet')->first();
        $webmasterWalletId = $subscription->user->wallet->id;
        $offer = Offer::find($subscription->offer_id)->with('user.wallet')->first();
        $advertiserWalletId = $offer->user->wallet->id;
        $fee = Fee::find($subscription->user->fee_id)->percent;
        dd($fee);
        $subscription = Subscription::where('referal_link', $referal_link)->with('offer')->first();
        $offerStatus = $subscription->offer->status;
        $uniqueIpOnly = $subscription->offer->unique_ip;
        $clientIp = ip2long($request->getClientIp());
        if ($offerStatus) {
            if($uniqueIpOnly) {
            $isUniqueIp = Redirect::where('ip', $clientIp)->doesntExist();
            if ($isUniqueIp) {
                Redirect::create([
                    'subscription_id' => $subscription->id,
                    'fee_id' => 1,
                    'ip' => $clientIp,
                    'status' => true,
                ]);
            } else {
                Redirect::create([
                    'subscription_id' => $subscription->id,
                    'fee_id' => 1,
                    'ip' => $clientIp,
                    'status' => false,
                ]);
            }
        } else {
                Redirect::create([
                    'subscription_id' => $subscription->id,
                    'fee_id' => 1,
                    'ip' => $clientIp,
                    'status' => true,
                ]);
        }
        } else {
            Redirect::create([
                'subscription_id' => $subscription->id,
                'fee_id' => 1,
                'ip' => $clientIp,
                'status' => false,
            ]);
        }

    }
}
