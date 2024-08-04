<?php


namespace App\Services;

use App\Models\Offer;
use App\Models\Redirect;
use App\Models\Transaction;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Contracts\Database\Query\Builder;

class AdministratorService
{
    public $totalIncome;
    public $dateIncome;
    private $statistics;
    private $dateStatistics;

    public function statistics()
    {
        $this->totalIncome = 0;
        $this->statistics = [];

        $offers = Offer::all()->count();
        $offersPublicated = Offer::where('status', 1)->count();
        $refLinkCount = Subscription::count();
        $refLinkTotal = Subscription::withTrashed()->count();
        $redirectsSuccess = Redirect::where('status', true)->count();
        $redirectsFail = Redirect::where('status', false)->count();
        $transactions = Transaction::where('operation_code', 302)->get();

        foreach($transactions as $transaction) {
            $this->totalIncome += round($transaction->value, 2);
        }

        $this->statistics[] = ['offersCreated' => $offers, 'offersPublicated' => $offersPublicated, 'refLinkCount' => $refLinkCount, 'refLinkTotal' => $refLinkTotal, 'redirectsSuccess' => $redirectsSuccess, 'redirectsFail' => $redirectsFail, 'totalIncome' => $this->totalIncome];
        return $this->statistics;
    }
    
    public function dayStatistics()
    {
        $this->dateIncome = 0;
        $this->dateStatistics = [];

        $offers = Offer::whereDate('created_at', date("Y-m-d", strtotime(request()->date)))->count();
        $offersPublicated = Offer::where('status', 1)->whereDate('created_at', date("Y-m-d", strtotime(request()->date)))->count();
        $refLinkCount = Subscription::whereDate('created_at', date("Y-m-d", strtotime(request()->date)))->count();
        $refLinkTotal = Subscription::withTrashed()->whereDate('created_at', date("Y-m-d", strtotime(request()->date)))->count();
        $redirectsSuccess = Redirect::where('status', true)->whereDate('created_at', date("Y-m-d", strtotime(request()->date)))->count();
        $redirectsFail = Redirect::where('status', false)->whereDate('created_at', date("Y-m-d", strtotime(request()->date)))->count();
        $transactions = Transaction::where('operation_code', 302)->whereDate('created_at', date("Y-m-d", strtotime(request()->date)))->get();

        foreach ($transactions as $transaction) {
            $this->dateIncome += round($transaction->value, 2);
        }

        $this->dateStatistics[] = ['offersCreated' => $offers, 'offersPublicated' => $offersPublicated, 'refLinkCount' => $refLinkCount, 'refLinkTotal' => $refLinkTotal, 'redirectsSuccess' => $redirectsSuccess, 'redirectsFail' => $redirectsFail, 'dateIncome' => $this->dateIncome];
        return $this->dateStatistics;
    }

    public function monthStatistics()
    {
        $this->dateIncome = 0;
        $this->dateStatistics = [];

        $offers = Offer::whereYear('created_at', date("Y", strtotime(request()->date)))->
            whereMonth('created_at', date("m", strtotime(request()->date)))->count();
        $offersPublicated = Offer::where('status', 1)->
            whereYear('created_at', date("Y", strtotime(request()->date)))->
            whereMonth('created_at', date("m", strtotime(request()->date)))->count();
        $refLinkCount = Subscription::whereYear('created_at', date("Y", strtotime(request()->date)))->
            whereMonth('created_at', date("m", strtotime(request()->date)))->count();
        $refLinkTotal = Subscription::withTrashed()->
            whereYear('created_at', date("Y", strtotime(request()->date)))->
            whereMonth('created_at', date("m", strtotime(request()->date)))->count();
        $redirectsSuccess = Redirect::where('status', true)->
            whereYear('created_at', date("Y", strtotime(request()->date)))->
            whereMonth('created_at', date("m", strtotime(request()->date)))->count();
        $redirectsFail = Redirect::where('status', false)->
            whereYear('created_at', date("Y", strtotime(request()->date)))->
            whereMonth('created_at', date("m", strtotime(request()->date)))->count();
        $transactions = Transaction::where('operation_code', 302)->
            whereYear('created_at', date("Y", strtotime(request()->date)))->
            whereMonth('created_at', date("m", strtotime(request()->date)))->get();

        foreach ($transactions as $transaction) {
            $this->dateIncome += round($transaction->value, 2);
        }

        $this->dateStatistics[] = ['offersCreated' => $offers, 'offersPublicated' => $offersPublicated, 'refLinkCount' => $refLinkCount, 'refLinkTotal' => $refLinkTotal, 'redirectsSuccess' => $redirectsSuccess, 'redirectsFail' => $redirectsFail, 'dateIncome' => $this->dateIncome];
        return $this->dateStatistics;
    }

    public function yearStatistics()
    {
        $this->dateIncome = 0;
        $this->dateStatistics = [];

        $offers = Offer::whereYear('created_at', date("Y", strtotime(request()->date)))->count();
        $offersPublicated = Offer::where('status', 1)->whereYear('created_at', date("Y", strtotime(request()->date)))->count();
        $refLinkCount = Subscription::whereYear('created_at', date("Y", strtotime(request()->date)))->count();
        $refLinkTotal = Subscription::withTrashed()->whereYear('created_at', date("Y", strtotime(request()->date)))->count();
        $redirectsSuccess = Redirect::where('status', true)->whereYear('created_at', date("Y", strtotime(request()->date)))->count();
        $redirectsFail = Redirect::where('status', false)->whereYear('created_at', date("Y", strtotime(request()->date)))->count();
        $transactions = Transaction::where('operation_code', 302)->whereYear('created_at', date("Y", strtotime(request()->date)))->get();

        foreach ($transactions as $transaction) {
            $this->dateIncome += round($transaction->value, 2);
        }

        $this->dateStatistics[] = ['offersCreated' => $offers, 'offersPublicated' => $offersPublicated, 'refLinkCount' => $refLinkCount, 'refLinkTotal' => $refLinkTotal, 'redirectsSuccess' => $redirectsSuccess, 'redirectsFail' => $redirectsFail, 'dateIncome' => $this->dateIncome];
        return $this->dateStatistics;
    }

}