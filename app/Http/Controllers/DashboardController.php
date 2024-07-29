<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Redirect;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        
        return view('dashboard.profile');
    }

    public function subscriptions()
    {
        $subscriptions = Subscription::where('user_id', Auth::id())->with('offer')->get();
        return view('dashboard.webmaster.subscriptions', compact('subscriptions'));
    }

    public function statistics()
    {   
        $subscriptions = Subscription::where('user_id', Auth::id())->with('redirect')->get();
        $statistics = [];
        foreach( $subscriptions as $subscription)
        {
            $income = 0;

            foreach($subscription->redirect as $redirect)
            {
            $award = $redirect->subscription->offer->award;
            $fee = Fee::where('id', $redirect->fee_id)->first()->percent;
            $fee = $award * ($fee / 100);
            $income += $award - $fee;
            
            
            }

            $statistics[] = ['subscription' => $subscription->referal_link, 'redirect_count' => $subscription->redirect->count(), 'award' => $income];
        }
        
        return view('dashboard.webmaster.statistics', compact('statistics'));
    }

    public function wallet()
    {
        $wallet = Wallet::where('user_id', Auth::id())->first();
        return view('dashboard.webmaster.wallet', compact('wallet'));
    }

    public function profile()
    {
        $user = User::where('id', Auth::id())->with('fee')->first();
        return view('dashboard.webmaster.profile', compact('user'));
    }
}
