<?php

class Url {
    public static function redirectUrl($path) {
        if(isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] != "off") {
            $urlProtocol = "https";
        } else {
            $urlProtocol = "http";
        }

        $url = "$urlProtocol://" . $_SERVER["HTTP_HOST"] . $path;
        header("Location: $url");
        exit(); 
    }
}
?>