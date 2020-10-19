<?php


namespace app\http;


use app\http\exception\XmlException;
use think\facade\Config;

class OBSOperation
{
    public static function get($bucket = '', $file = ''){
        if (is_file(Config::get('obs_location')."$bucket/$file"))
            return Download(Config::get('obs_location')."$bucket/$file");
        else
            return XmlException::render('The specified object does not exist', 'NoSuchKey');
    }

    public static function put($bucket = '', $file = ''){
        $putData = fopen("php://input", "r");
        $fp = fopen(Config::get('obs_location')."$bucket/$file",'w');

        while($data = fread($putData, 4096))
            fwrite($fp, $data);

        fclose($fp);
        fclose($putData);

        return null;
    }

    public static function delete($bucket = '', $file = ''){
        $obs = Config::get('obs_location');
        if(is_file("$obs$bucket/$file"))
            unlink("$obs$bucket/$file");
        else if (empty($file)){
            if (is_dir("$obs$bucket"))
                if(sizeof(scandir("$obs$bucket")) == 2)
                    rmdir("$obs$bucket/");
                else
                    return XmlException::render('The bucket you tried to operate is not empty','BucketNotEmpty',409);
            else if(!is_dir("$obs$bucket"))
                return XmlException::render('The specified bucket does not exist', 'NoSuchBucket', 404);
        }
        return null;
    }

    public static function dirsize($path){
        $dh = opendir($path);
        $size = 0;
        while($file = @readdir($dh)){
            if($file!="." && $file!=".."){
                if(is_dir("$path/$file")){
                    $size += self::dirsize($path/$file);
                }elseif(is_file("$path/$file")){
                    $size += filesize("$path/$file");
                }
            }
        }
        closedir($dh);
        return $size;
    }
}