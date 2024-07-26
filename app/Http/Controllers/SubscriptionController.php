<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Support\Str;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class SubscriptionController extends Controller
{
    public function create()
    {
        return view('offer.create');
    }

    public function store(Offer $offer)
    {   $subscription = Subscription::where('user_id', Auth::id())->where('offer_id', $offer->id);
        $isSubscribed = $subscription->exists();
        $isRemoved = Subscription::withTrashed()->where('user_id', Auth::id())->where('offer_id', $offer->id)->exists();

        if($isSubscribed) {
            return redirect()->route('offer.show', $offer->id)->withErrors(['error' => 'you already subscribe']);
        } elseif ($isRemoved) {
            Subscription::withTrashed()->where('user_id', Auth::id())->where('offer_id', $offer->id)->restore();
            return redirect()->route('offer.index');
        } else {
            Subscription::create([
                'user_id' => Auth::id(),
                'offer_id' => $offer->id,
                'referal_link' => Str::random(36),
                // 'status' => 1,
            ]);
            return redirect()->route('offer.index');
        }
        
    }

    public function destroy(Offer $offer)
    {
        $Subscription = Subscription::where('user_id', Auth::id())->where('offer_id', $offer->id)->first();
        $Subscription->delete();
        return redirect()->route('offer.index');
    }


}
