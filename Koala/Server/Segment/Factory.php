<?php
namespace Server\Segment;
class Factory extends \Server\Factory{
    public static function getServerName($name){
        $server_name = 'LAESegment';
        switch($name){
            case 'segment':
                if(APPENGINE=='SAE'){
                    if (function_exists('SAESegment')) $server_name = 'SAESegment' ;
                }elseif(APPENGINE=='BAE'){
                    if (class_exists('BaeSegment')) $server_name = 'BaeSegment' ;
                }else{
                    if (class_exists('Segment')) $server_name = 'LAESegment' ;
                }
            break;
        }
        return self::getRealName('Segment',$server_name);
    }
}