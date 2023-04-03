<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Session;
class checkUserLogin
{

    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $inforUser = Session::get('inforUser');
        if($inforUser)
        {
            return $next($request);
        }
        else
        {
            return redirect('/login');
        }
        return $next($request);
    }
}
