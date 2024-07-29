<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\Offer;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Redirect;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdvertiserController extends Controller
{
    public function index()
    {
        return view('dashboard.profile');
    }

    public function profile()
    {
        return view('dashboard.advertiser.profile');
    }

    public function offers()
    {
        $offers = Offer::where('user_id', Auth::id())->get();
        return view('dashboard.advertiser.offers', compact('offers'));
    }

    public function statistics()
    {
        $offers = Offer::where('user_id', Auth::id())->with('subscriptions')->withTrashed()->get();
        $total = 0;
        $statistics = [];
        foreach ($offers as $offer)
        {
            $count = 0;
            $costs = 0;
            foreach($offer->subscriptions as $subscription)
            {
                $redirects = Redirect::where('subscription_id', $subscription->id)->where('status', 1)->get();
                $count = $redirects->count();
            }
            $costs += $count * $offer->award;
            $total += $costs;
            $statistics[] = ['id' => $offer->id, 'title' => $offer->title, 'sub_now' => $offer->subscriptions->where('deleted_at', null)->count(), 'sub_total' => $offer->subscriptions->count(), 'redirects' => $count, 'costs' => $costs, 'redirect_award' => $offer->award];
        }
        
        return view('dashboard.advertiser.statistics', compact('statistics', 'total'));
    }

    public function wallet()
    {
        $wallet = Wallet::where('user_id', Auth::id())->first();
        return view('dashboard.advertiser.wallet', compact('wallet'));
    }
}
