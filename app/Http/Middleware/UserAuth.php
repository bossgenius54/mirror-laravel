<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth;
use App\Model\SysUserType;

class UserAuth {
    protected $auth;

    function __construct(Guard $auth) {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next){
        if ($this->auth->guest())
            return redirect()->action('LoginController@getLogin')->with('error', 'Введите логин и пароль, для доступа');

        return $next($request);
    }
}
