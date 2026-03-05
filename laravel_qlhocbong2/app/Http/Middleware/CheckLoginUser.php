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

        $user = \App\Models\User::find(get_data_user('web'));
        if (!$user) {
            \Auth::guard('web')->logout();
            return redirect()->route('get_user.login')->with('error', 'Phiên đăng nhập không hợp lệ. Vui lòng đăng nhập lại.');
        }
        \View::share('user', $user);

        return $next($request);
    }
}
