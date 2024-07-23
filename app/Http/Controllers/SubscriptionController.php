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
    {
        $isSubscribed = Subscription::where('user_id', Auth::id())->where('offer_id', $offer->id)->exists();
        if($isSubscribed) {
            return redirect()->route('offer.show', $offer->id)->withErrors(['error' => 'you already subscribe']);
        } else {
            Subscription::create([
                'user_id' => Auth::id(),
                'offer_id' => $offer->id,
                'referal_link' => Str::random(36),
                'status' => true,
            ]);
            return redirect()->route('offer.index');
        }
        
    }

    public function show()
    {
        
    }
}
