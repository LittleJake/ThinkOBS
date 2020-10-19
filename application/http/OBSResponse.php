<?php


namespace app\http;


use app\http\exception\XmlException;
use think\facade\Config;
use think\facade\Request;

class OBSResponse
{
    public static function ListBucketResult($bucket = ''){
        $obs = Config::get('obs_location');
        if(is_dir("$obs$bucket")){
            $dir = scandir("$obs$bucket");

            $objects = [];
            foreach ($dir as $v)
                if($v != '.' && $v != '..' && is_file("$obs$bucket/$v"))
                    $objects[] = [
                        'Key' => $v,
                        'LastModified' => date('c', filemtime("$obs$bucket/$v")),
                        'ETag' => strtoupper('"'.rand_str(32).'"'),
                        'Size' => filesize("$obs$bucket/$v"),
                        'Owner' => [
                            'ID',
                            'DisplayName'
                        ],
                        'StorageClass' => 'STANDARD'
                    ];

            $config = [
                'root_node' => 'ListBucketResult',
                'root_attr' => [
                    'xmlns' => 'http://s3.amazonaws.com/doc/2006-03-01/'
                ],
                'item_node' => 'Contents',
                'item_key' => ''
            ];
            $header = [
                'x-amz-request-id' => implode('/',[
                    rand_num(1), rand_num(1), rand_num(16),rand_hex(10)
                ])
            ];
            $resp = [
                'Name' => $bucket,
                'Prefix' => '',
                'Marker' => '',
                'MaxKeys' => 1000,
                'IsTruncated' => 'false',
            ];

            $resp = array_merge($resp,$objects);

            return xml($resp, 200, $header, $config);
        }

        return XmlException::render('The specified bucket does not exist', 'NoSuchBucket',404);
    }

    public static function GetBucketStorageInfoResult($bucket = ''){
        $config = [
            'root_node' => 'GetBucketStorageInfoResult',
            'root_attr' => ['xmlns' => 'http://s3.amazonaws.com/doc/2006-03-01/']
        ];

        $header = [
            'x-amz-request-id' => implode('/',[
                rand_num(1), rand_num(1), rand_num(16),rand_hex(10)
            ])
        ];

        $obs = Config::get('obs_location');
        if(is_dir("$obs$bucket")){
            $num = sizeof(scandir("$obs$bucket"))-2;
            $size = OBSOperation::dirsize("$obs$bucket");

            $resp = [
                'Size' => $size,
                'ObjectNumber' => $num,
            ];

            return xml($resp, 200, $header, $config);
        }

        return XmlException::render('The specified bucket does not exist', 'NoSuchBucket',404);
    }

    public static function ListAllMyBucketsResult(){
        $obs = Config::get('obs_location');
        $dir = scandir($obs);

        $buckets = [];
        foreach ($dir as $v)
            if($v != '.' && $v != '..' && is_dir($obs.$v))
                $buckets[] = [
                    'Name' => $v,
                    'CreationDate' => date('c',filectime($obs.$v)),
                    'Location' => 'local'
                ];

        $config = [
            'root_node' => 'ListAllMyBucketsResult',
            'root_attr' => [
                'xmlns' => 'http://s3.amazonaws.com/doc/2006-03-01/'
            ],
            'item_node' => 'Bucket',
            'item_key' => ''
        ];
        $header = [
            'x-amz-request-id' => implode('/',[
                rand_num(1), rand_num(1), rand_num(16),rand_hex(10)
            ])
        ];
        $resp = [
            'Owner' => [
                'ID' => rand_num(32),
                'DisplayName' => rand_str(32)
            ],
            'Buckets' => $buckets
        ];

        return xml($resp, 200, $header, $config);
    }

    public static function Location(){
        $resp = 'local';

        $header = [
            'x-amz-request-id' => implode('/',[
                rand_num(1), rand_num(1), rand_num(16),rand_hex(10)
            ])
        ];

        return xml("<Location xmlns='http://s3.amazonaws.com/doc/2006-03-01/'>$resp</Location>", 200, $header);
    }

    public static function StorageClass(){
        $resp = 'STANDARD';
        $header = [
            'x-amz-request-id' => implode('/',[
                rand_num(1), rand_num(1), rand_num(16),rand_hex(10)
            ])
        ];
        return xml("<StorageClass xmlns='http://s3.amazonaws.com/doc/2006-03-01/'>$resp</StorageClass>", 200, $header);
    }
}