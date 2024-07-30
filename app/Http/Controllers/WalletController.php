<?php

namespace App\Http\Controllers;

use App\Services\WalletService;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function update(Request $request)
    {
        $data = $request->validate([
            'amount' => ['required', 'numeric'],
            'replenish' => '',
            'withdraw' => '',
        ]);
        if($request->has('replenish')) {
            return WalletService::replenish($data['amount']);
        } elseif($request->has('withdraw')) {
            return WalletService::withdraw($data['amount']);
        }
        
    }

}
