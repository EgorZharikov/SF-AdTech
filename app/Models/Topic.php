<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $guarded = false;
    public $timestamps = false;

    public function offers()
    {
       return $this->hasMany(Offer::class, 'topic_id', 'id');
    }
}
