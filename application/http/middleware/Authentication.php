<?php

namespace app\http\middleware;

use app\http\exception\XmlException;
use app\http\OBSResponse;
use think\Exception;
use think\Request;

class Authentication
{
    public function handle(Request $request, \Closure $next)
    {
        $token = $request->header('Authorization','');
//        if(empty($token))
//            return XmlException::render("Access denied","AccessDenied", 403);

        return $next($request);
    }
}
