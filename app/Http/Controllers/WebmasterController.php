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
        $subscriptions = Subscription::where('user_id', Auth::id())->with('offer')->paginate(9);
        return view('dashboard.webmaster.subscriptions', compact('subscriptions'));
    }

    public function statistics(Request $request)
    {
        $statistics = [];
        $totalAward = 0;
        $userDate = $request->date;
        $dateStatistics = [];
        $dateAward= 0;

        $webmasterService = (new WebmasterService);

        $statistics = $webmasterService->statisctics();
        $totalAward = $webmasterService->totalAward;

        if ($request->has('day')) {
            $dateStatistics = $webmasterService->dayStatistics();
            $dateAward = $webmasterService->dateAward;
        }

        if ($request->has('month')) {
            $dateStatistics = $webmasterService->monthStatistics();
            $dateAward = $webmasterService->dateAward;
        }

        if ($request->has('year')) {
            $dateStatistics = $webmasterService->yearStatistics();
            $dateAward = $webmasterService->dateAward;
        }

        return view('dashboard.webmaster.statistics', compact('statistics', 'totalAward', 'userDate', 'dateStatistics', 'dateAward'));
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
