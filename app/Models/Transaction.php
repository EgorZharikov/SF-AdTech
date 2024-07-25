<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function wallet()
    {
        $this->belongsTo(Wallet::class, 'wallet_id', 'id');
    }
}
