<?php
/**
 * Created by PhpStorm .
 * User: trungphuna .
 * Date: 4/14/22 .
 * Time: 6:14 AM .
 */

namespace App\Http\Middleware;


class CheckLoginAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if (get_data_user('admins'))  return $next($request);

        return redirect()->route('get_admin.login');
    }
}
