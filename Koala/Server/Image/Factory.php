<?php
namespace Koala\Server\Image;
class Factory extends \Koala\Server\Factory{
    public static function getServerName($name){
        $server_name = 'LAEImage';
        switch($name){
            case 'gdimage':
                $server_name = 'LAEGDImage' ;
            break;
        	case 'image':
            case 'laeimage':
                $server_name = 'LAEImage' ;
            break;
        }
        return self::getRealName('Image',$server_name);
    }
}