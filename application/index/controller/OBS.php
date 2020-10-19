<?php

namespace app\index\controller;

use app\http\exception\XmlException;
use app\http\OBSOperation;
use app\http\OBSResponse;
use think\Controller;
use think\facade\Config;

class OBS extends Controller
{
    protected $middleware = ['Authentication'];

    public function get($bucket = '', $file = ''){
        if(input('?storageinfo'))
            return OBSResponse::GetBucketStorageInfoResult($bucket);
        else if(input('?location'))
            return OBSResponse::Location();
        else if(input('?storageClass'))
            return OBSResponse::StorageClass();
        else if($file != '')
            return OBSOperation::get($bucket, $file);

        return OBSResponse::ListBucketResult($bucket);
    }

    public function put($bucket = '', $file = ''){
        return OBSOperation::put($bucket, $file);
    }

    public function miss(){
        return XmlException::render('Bad request', 'BadRequest');
    }

    public function delete($bucket = '', $file = ''){
        return OBSOperation::delete($bucket,$file);
    }

    public function head(){
        return;
    }

    public function bucket(){
        if(input('?location'))
            return OBSResponse::Location();
        else if (sizeof(input()) == 0)
            return OBSResponse::ListAllMyBucketsResult();

        return XmlException::render('The request parameter is invalid','InvalidRequestParameter', 400);
    }
}
