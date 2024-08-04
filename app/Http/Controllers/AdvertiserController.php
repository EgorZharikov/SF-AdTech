<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\Offer;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Redirect;
use App\Models\Subscription;
use App\Services\AdvertiserService;
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
        $offers = Offer::where('user_id', Auth::id())->paginate(9);
        return view('dashboard.advertiser.offers', compact('offers'));
    }

    public function statistics(Request $request)
    {
        $userDate = $request->date;
        $advertiserService = (new AdvertiserService);
        $totalCost = 0;
        $statistics = [];
        $dateStatistics = [];
        $dateCost = 0;

        $statistics = $advertiserService->statisctics();
        $totalCost = $advertiserService->totalCost;

        if ($request->has('day')) {
            $dateStatistics = $advertiserService->dayStatistics();
            $dateCost = $advertiserService->totalCost;
        }

        if ($request->has('month')) {
            $dateStatistics = $advertiserService->monthStatistics();
            $dateCost = $advertiserService->totalCost;
        }

        if ($request->has('year')) {
            $dateStatistics = $advertiserService->yearStatistics();
            $dateCost = $advertiserService->totalCost;
        }



        return view('dashboard.advertiser.statistics', compact('statistics', 'totalCost', 'dateStatistics', 'dateCost', 'userDate'));
    }

    public function wallet()
    {
        $wallet = Wallet::where('user_id', Auth::id())->first();
        return view('dashboard.advertiser.wallet', compact('wallet'));
    }
}
