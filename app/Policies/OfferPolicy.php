<?php

namespace App\Policies;

use App\Models\Offer;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OfferPolicy
{   
    
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    public function view(User $user, Offer $offer): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function subscribe(User $user, Offer $offer): bool
    {
        $unsubscribed = Subscription::where('offer_id', $offer->id)->where('user_id', $user->id)->doesntExist(); 
        return $user->role_id == 2 && $unsubscribed && $offer->status == 1;
    }

    public function unsubscribe(User $user, Offer $offer): bool
    {
        $subscribed = Subscription::where('offer_id', $offer->id)->where('user_id', $user->id)->exists();
        return $user->role_id == 2 && $subscribed && $offer->status == 1;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Offer $offer): bool
    {
        return $offer->user_id === $user->id;
    }
    
    public function unpublish(User $user, Offer $offer): bool
    {
        return $offer->user_id === $user->id && $offer->status === 1;
    }

    public function publish(User $user, Offer $offer): bool
    {
        return $offer->user_id === $user->id && $offer->status !== 1;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Offer $offer): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Offer $offer): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Offer $offer): bool
    {
        //
    }
}
