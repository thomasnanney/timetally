<?php

namespace App\Core\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Users\Models\User;

class Permissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //if user has admin role for current workspace
        if($request->user()->isAdmin()){
            return $next($request);
        }
        if($request->isXmlHttpRequest()){
            return response('Unauthorized', 403);
        }
        return redirect('/dashboard')->with('warning', 'You do not have permission to do that');
    }
}
