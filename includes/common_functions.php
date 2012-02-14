<?php

function uri_for($resource) {
    global $conf;
    return ($conf['url_abs'] ? $conf['url_root'] : '?q=').$resource;
}
function uri_static($resource) {
    global $conf;
    return $conf['url_root'].$resource;
}

function uri_dispatcher($uri) {
    $array = explode('/',trim($uri,'/'));

    $hash = array();
    foreach(array_chunk($array,2) as $pair) {
	$hash[$pair[0]] = $pair[1];
    }
    return $hash;
}



?>
