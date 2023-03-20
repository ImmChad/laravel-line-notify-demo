<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Auth;
use Session;
use Symfony\Component\HttpFoundation\Response;

class checkAdminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $data_admin = Session::get('data_admin');
        if($data_admin)
        {
            return $next($request);
        }
        else
        {
            return redirect('admin');
        }
    }
}
