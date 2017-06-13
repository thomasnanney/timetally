<?php

function isActive($path){
    $path = explode('.', $path);
    $requestPath = Request::path();
    $requestPath = explode('/', $requestPath);
    $requestPath = array_slice($requestPath, 0, 2);
    if(count($requestPath) != count($path)){
        return '';
    }
    $segment = 0;
    foreach($path as $p) {
        if(($requestPath[$segment] == $p) == false) {
            return '';
        }
        $segment++;
    }
    return 'active';
}

?>