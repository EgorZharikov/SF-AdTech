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
        $userDate = $request->date;
        $dayOffers = [];
        $dayCost = 0;
        if ($request->has('day')) {
            $offers = Offer::where('user_id', Auth::id())->withCount(['subscriptions' => function (Builder $query) {
                $query->withTrashed();
                $query->whereDay('created_at', date("d", strtotime(request()->date)));
                $query->whereMonth('created_at', date("m", strtotime(request()->date)));
                $query->whereYear('created_at', date("Y", strtotime(request()->date)));
            }])->get();
            foreach ($offers as $offer) {
                $dayRedirects = 0;
                foreach ($offer->subscriptions()->withTrashed()->get() as $subscription) {
                    $dayRedirects = Redirect::where('subscription_id', $subscription->id)->
                    where('status', 1)->whereDay('created_at', date("d", strtotime(request()->date)))->
                    whereMonth('created_at', date("m", strtotime(request()->date)))->
                    whereYear('created_at', date("Y", strtotime(request()->date)))->get()->count();
                }
                $offer->redirectsCount = $dayRedirects;
                $offer->subscriptionsNow = Subscription::where('offer_id', $offer->id)->
                whereDay('created_at', date("d", strtotime(request()->date)))->
                whereMonth('created_at', date("m", strtotime(request()->date)))->
                whereYear('created_at', date("Y", strtotime(request()->date)))->get()->count();
                $dayOffers[] = $offer;
                $dayCost += $offer->redirectsCount * $offer->award;
                // $dayRedirects = Redirect::where([['subscription_id', $offer->subscriptions->id],['status', 1]])->get();

            }
        }



        $offers = Offer::where('user_id', Auth::id())->
        withCount(['subscriptions' => function (Builder $query) { $query->withTrashed();}])->get();
        $costTotal = 0;
        $statistics = [];
        foreach ($offers as $offer) {
            $redirects = 0;
            foreach ($offer->subscriptions()->withTrashed()->get() as $subscription) {
                $redirects = Redirect::where('subscription_id', $subscription->id)->where('status', 1)->get()->count();
            }
            $offer->redirectsCount = $redirects;
            $costTotal += $offer->redirectsCount * $offer->award;
            $offer->subscriptionsNow = Subscription::where('offer_id', $offer->id)->get()->count();
            $statistics[] = $offer;
        }

        return view('dashboard.advertiser.statistics', compact('statistics', 'costTotal', 'dayOffers', 'dayCost', 'userDate'));
    }

    public function wallet()
    {
        $wallet = Wallet::where('user_id', Auth::id())->first();
        return view('dashboard.advertiser.wallet', compact('wallet'));
    }
}
