<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\Offer;
use App\Models\Redirect;
use App\Models\Subscription;
use App\Services\RedirectService;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function redirect($referal_link, Request $request)
    {
        return $redirector = ( new RedirectService())->process($referal_link, $request);
    }
}
