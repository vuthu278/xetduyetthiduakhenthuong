<?php
/**
 * Created by PhpStorm .
 * User: trungphuna .
 * Date: 4/14/22 .
 * Time: 6:14 AM .
 */

namespace App\Http\Middleware;


use Illuminate\Support\Facades\Hash;

class CheckPassUser
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
        if (get_data_user('web'))  {
            if (Hash::check('123456', get_data_user('web','password'))) {
                return  redirect()->route('user.password');
            }
            return $next($request);
        }

        return redirect()->route('get_user.login');
    }
}
