<?php

namespace app\http\middleware;

use think\Exception;
use think\Request;

class Authentication
{
    public function handle(Request $request, \Closure $next)
    {
        $token = $request->header('Authorization','');
        return $next($request);
    }
}
