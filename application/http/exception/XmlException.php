<?php


namespace app\http\exception;


use think\facade\Request;

class XmlException
{
    public static function render($message = 'OK', $code = '', $http_code = 400){
        $request_id = implode('/',[
            rand_num(1), rand_num(1), rand_num(16),rand_hex(10)
        ]);
        return xml([
            'Code' => $code,
            'Message' => $message,
            'Resource' => Request::baseUrl(),
            'RequestId' => $request_id
        ], $http_code, ['x-amz-request-id' => $request_id], ['root_node' => 'Error']);
    }
}