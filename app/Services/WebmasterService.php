<?php


namespace App\Services;

use App\Models\Fee;
use App\Models\Offer;
use App\Models\Redirect;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Contracts\Database\Query\Builder;

class WebmasterService
{
    public $totalAward;
    private $statistics;
    public $dateAward;
    private $dateStatistics;



    public function dayStatistics(): array
    {
        $this->dateAward = 0;
        $this->dateStatistics = [];

        $subscriptions = Subscription::where('user_id', Auth::id())->
        whereDate('created_at', '<=', date("Y-m-d", strtotime(request()->date)))->
        withCount(['redirects' => function (Builder $query) {
            $query->where('status', 1);
            $query->whereDate('created_at', date("Y-m-d", strtotime(request()->date)));
        }])->withTrashed()->get();

        foreach ($subscriptions as $subscription) {

            foreach ($subscription->redirects as $redirect) {
                $subscription->award = round(Offer::where('id', $subscription->offer_id)->first()->award, 2);
                $fee = Fee::where('id', $redirect->fee_id)->first()->percent;
                $subscription->fee = round($subscription->award * ($fee / 100), 2);
            }
            $this->dateAward += round($subscription->redirects_count * ($subscription->award - $subscription->fee), 2);
            $this->dateStatistics[] = $subscription;
        }

        return $this->dateStatistics;
    }

    public function monthStatistics(): array
    {
        $this->dateAward = 0;
        $this->dateStatistics = [];

        $subscriptions = Subscription::where('user_id', Auth::id())->
        whereYear('created_at', '<=', date("Y", strtotime(request()->date)))->
        whereMonth('created_at', '<=', date("m", strtotime(request()->date)))->
        withCount(['redirects' => function (Builder $query) {
                $query->where('status', 1);
                $query->whereYear('created_at', date("Y", strtotime(request()->date)));
                $query->whereMonth('created_at', date("m", strtotime(request()->date)));
            }])->withTrashed()->get();

        foreach ($subscriptions as $subscription) {

            foreach ($subscription->redirects as $redirect) {
                $subscription->award = round(Offer::where('id', $subscription->offer_id)->first()->award, 2);
                $fee = Fee::where('id', $redirect->fee_id)->first()->percent;
                $subscription->fee = round($subscription->award * ($fee / 100), 2);
            }
            $this->dateAward += round($subscription->redirects_count * ($subscription->award - $subscription->fee), 2);
            $this->dateStatistics[] = $subscription;
        }

        return $this->dateStatistics;
    }

    public function yearStatistics(): array
    {
        $this->dateAward = 0;
        $this->dateStatistics = [];

        $subscriptions = Subscription::where('user_id', Auth::id())->
        whereYear('created_at', '<=', date("Y", strtotime(request()->date)))->
        withCount(['redirects' => function (Builder $query) {
                $query->where('status', 1);
                $query->whereYear('created_at', date("Y", strtotime(request()->date)));
            }])->withTrashed()->get();

        foreach ($subscriptions as $subscription) {

            foreach ($subscription->redirects as $redirect) {
                $subscription->award = round(Offer::where('id', $subscription->offer_id)->first()->award, 2);
                $fee = Fee::where('id', $redirect->fee_id)->first()->percent;
                $subscription->fee = round($subscription->award * ($fee / 100), 2);
            }
            $this->dateAward += round($subscription->redirects_count * ($subscription->award - $subscription->fee), 2);
            $this->dateStatistics[] = $subscription;
        }

        return $this->dateStatistics;
    }

    public function statisctics() {
        $this->totalAward = 0;
        $this->statistics = [];

        $subscriptions = Subscription::where('user_id', Auth::id())->withCount(['redirects' => function (Builder $query) {
        $query->where('status', 1);
        }])->withTrashed()->get();

        foreach ($subscriptions as $subscription) {

            foreach ($subscription->redirects as $redirect) {
                $subscription->award = round(Offer::where('id', $subscription->offer_id)->first()->award, 2);
                $fee = Fee::where('id', $redirect->fee_id)->first()->percent;
                $subscription->fee = round($subscription->award * ($fee / 100), 2);
            }
            $this->totalAward += round($subscription->redirects_count * ($subscription->award - $subscription->fee),2);
            $this->statistics[] = $subscription;

        }
        
        return $this->statistics;
    }
}
