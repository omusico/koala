<?php
namespace Koala\Server\Image;
class Factory extends \Koala\Server\Factory{
    public static function getServerName($name){
        $server_name = 'LAEImage';
        switch($name){
        	case 'Image':
            case 'laeimage':
                $server_name = 'LAEImage' ;
            break;
        }
        return self::getRealName('Image',$server_name);
    }
}