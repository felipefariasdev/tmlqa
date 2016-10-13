<?php
namespace Model\Compomentes;
class RegisterLog {
    public static function getLog() {
        $id_access          = $_SERVER["REMOTE_ADDR"].":".$_SERVER["REMOTE_PORT"];
        @$access_referencia  = $_SERVER["HTTP_REFERER"];
        $accept             = $_SERVER["HTTP_ACCEPT"]; //text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8
        $accept_encode      = $_SERVER["HTTP_ACCEPT_ENCODING"]; //gzip, deflate, sdch
        return $id_access.", ".$access_referencia.", ".$accept.", ".$accept_encode;
    }
} 