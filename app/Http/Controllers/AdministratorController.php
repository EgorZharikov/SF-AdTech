<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AdministratorService;
use App\Services\UserService;

class AdministratorController extends Controller
{
    public function index()
    {
        return view('dashboard.administrator.index');
    }

    public function profile()
    {
        $user = User::where('id', Auth::id())->first();
        return view('dashboard.administrator.profile', compact('user'));
    }

    public function statistics(Request $request)
    {
        $userDate = $request->date;
        $statistics = [];
        $dateStatistics = [];
        $totalIncome = 0;
        $dateIncome = 0;

        $administratorService = (new AdministratorService);
        $statistics = $administratorService->statistics();
        
        if ($request->has('day')) {
            $dateStatistics = $administratorService->dayStatistics();
        }

        if ($request->has('month')) {
            $dateStatistics = $administratorService->monthStatistics();
        }

        if ($request->has('year')) {
            $dateStatistics = $administratorService->yearStatistics();
        }
        return view('dashboard.administrator.statistics', compact('statistics', 'dateStatistics', 'userDate'));
    }

    public function users() {
        return view('dashboard.administrator.users');
    }

    public function createUser()
    {
        return view('dashboard.administrator.users.create');
    }

    public function storeUser()
    {
        return UserService::store();
    }

    public function controlUser()
    {
        return view('dashboard.administrator.users.control');
    }

    public function userList()
    {
        $users = User::with('role')->paginate(20);
        return view('dashboard.administrator.users.index', compact('users'));
    }

    public function updateUser(User $user, Request $request)
    {
        if($request->has('ban')){
            UserService::ban($user);
        }

        if ($request->has('unban')) {
            UserService::unban($user);
        }
        $users = User::with('role')->get();
        return view('dashboard.administrator.users.index', compact('users'));
    }

    public function wallet()
    {
        $wallet =  Wallet::where('system_code', 101)->first();
        $walletIncome = Wallet::where('system_code', 102)->first();
        return view('dashboard.administrator.wallet', compact('wallet', 'walletIncome'));
    }
}
