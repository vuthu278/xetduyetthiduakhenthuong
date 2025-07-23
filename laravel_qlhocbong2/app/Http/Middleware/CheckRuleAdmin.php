<?php
/**
 * Created by PhpStorm .
 * User: trungphuna .
 * Date: 2/24/21 .
 * Time: 9:10 PM .
 */

namespace App\Http\Middleware;


class CheckRuleAdmin
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
        if (get_data_user('admins'))  {
            $level = get_data_user('admins','level');
            $rule = $this->rule();
            if ($level == 0) return $next($request);

            $listRules = $rule;
            if (!empty($listRules))
            {
                $routeName = \Request::route()->getName();
                if ( in_array($routeName, $listRules)) return $next($request);
            }
            return abort(401);
        }

        return redirect()->route('get_admin.login');
    }

    protected function rule()
    {
        return routeRuleAdm();
    }
}
