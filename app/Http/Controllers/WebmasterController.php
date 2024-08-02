<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Redirect;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Services\WebmasterService;
use Illuminate\Support\Facades\Auth;

class WebmasterController extends Controller
{
    public function index()
    {
        return view('dashboard.webmaster.index');
    }

    public function subscriptions()
    {
        $subscriptions = Subscription::where('user_id', Auth::id())->with('offer')->get();
        return view('dashboard.webmaster.subscriptions', compact('subscriptions'));
    }

    public function statistics(Request $request)
    {
        $statistics = [];
        $total = 0;
        $userDate = $request->date;
        $webmasterService = (new WebmasterService);
        

        return view('dashboard.webmaster.statistics', compact('statistics', 'total'));
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
