<?php

namespace App\Http\Middleware;

use Closure;

class CheckEnvConfiguration
{
    use \App\Traits\Setup;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->isEnvExist()) {
            return redirect()->action('SetupController@viewSetup');
        }
        return $next($request);
    }
}
