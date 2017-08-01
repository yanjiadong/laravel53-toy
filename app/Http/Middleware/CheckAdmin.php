<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdmin
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
        $admin_id = session('admin_id');
        if(empty($admin_id))
        {
            return redirect()->route('admin.login.index');
        }
        return $next($request);
    }
}
