<?php


namespace App\Services;

use App\Models\Offer;

class OfferService
{
    public static function disabled(int $offerId)
    {
        $offer = Offer::find($offerId)->first();
        $offer->status = 0;
        $offer->save();
        $offer->refresh();
    }
}