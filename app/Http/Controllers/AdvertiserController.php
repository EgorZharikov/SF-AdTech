<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\Offer;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Redirect;
use App\Models\Subscription;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdvertiserController extends Controller
{
    public function index()
    {
        return view('dashboard.advertiser.index');
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

    public function statistics(Request $request)
    {   
        $dayOffers = [];
        $dayCost = 0;
        if($request->has('day')) {
            $offers = Offer::where('user_id', Auth::id())->withCount(['subscriptions' => function (Builder $query) {
                $query->whereDay('created_at', date("d", strtotime(request()->date)));
            }])->get();
            foreach($offers as $offer) {
                $dayRedirects = 0;
                foreach($offer->subscriptions as $subscription) {
                    $dayRedirects = Redirect::where('subscription_id', $subscription->id)->where('status', 1)->whereDay('created_at', date("d", strtotime(request()->date)))->get()->count();
                }
                $offer->redirectsCount = $dayRedirects;
                $dayOffers[] = $offer;
                $dayCost += $offer->redirectsCount * $offer->award;
                // $dayRedirects = Redirect::where([['subscription_id', $offer->subscriptions->id],['status', 1]])->get();
                
            }
        }



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
        
        return view('dashboard.advertiser.statistics', compact('statistics', 'total', 'dayOffers', 'dayCost'));
    }

    public function wallet()
    {
        $wallet = Wallet::where('user_id', Auth::id())->first();
        return view('dashboard.advertiser.wallet', compact('wallet'));
    }

}
