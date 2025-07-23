<?php
/**
 * Created by PhpStorm .
 * User: trungphuna .
 * Date: 4/14/22 .
 * Time: 6:14 AM .
 */

namespace App\Http\Middleware;


use Illuminate\Support\Facades\Hash;
use Closure;

class CheckLoginUser
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
        if (!get_data_user('web')) {
            return redirect()->route('get_user.login');
        }
        
        // Share user data with all views
        $user = \App\Models\User::find(get_data_user('web'));
        \View::share('user', $user);
        
        return $next($request);
    }
}
