<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class checkWalletBalance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $wallet = Wallet::where('user_id', Auth::id())->first(); 
        if ($request->award < $wallet->balance) {
            return $next($request);
        } else {
            return back()->withErrors(['walletError' => true]);
        }
    }
}
