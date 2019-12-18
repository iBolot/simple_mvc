<?php


class DefaultAction
{
    public function show404(){
        echo "Error 404";
    }

    public function redirect301($url){
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $url);
    }
}