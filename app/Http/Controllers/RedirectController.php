<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Redirect;
use App\Models\Subscription;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function redirect($referal_link, Request $request)
    {
        
        $advertiserWalletId = Subscription::where('referal_link', $referal_link)->with('user')->first()
        ->user->with('wallet')->first()->wallet->id;
        dd($advertiserWalletId);
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
