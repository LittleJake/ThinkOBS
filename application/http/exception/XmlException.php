<?php


namespace app\http\exception;


use think\facade\Log;
use think\facade\Request;

class XmlException
{
    public static function render($message = 'OK', $code = '', $http_code = 400){
        $time = date("Y-m-d H:i:s");
        $request_hex = rand_hex(10);
        $request_id = implode('/',[rand_num(1), rand_num(1), rand_num(16),$request_hex]);

        Log::error("[$time][$request_hex]: ".Request::method()." ".Request::baseUrl(true));
        Log::error("[$time][$request_hex]: $message");

        return xml([
            'Code' => $code,
            'Message' => $message,
            'Resource' => Request::baseUrl(),
            'RequestId' => $request_id
        ], $http_code, ['x-amz-request-id' => $request_id], ['root_node' => 'Error']);
    }
}