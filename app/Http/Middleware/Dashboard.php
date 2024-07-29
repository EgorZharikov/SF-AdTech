<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Dashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userRole = User::find(Auth::id());
        switch ($userRole->role_id) {
            case 1:
                return redirect()->route('dashboard.advertiser.index');
                break;
            case 2:
                return redirect()->route('dashboard.webmaster.index');
                break;
            case 3:
                return redirect()->route('dashboard.administrator.index');
                break;
            default:
                return abort(404);
        }
        
    }
}
