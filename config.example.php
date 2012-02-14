<?php

/* WebApp configuration */
$conf['title'] = 'Agenda';
$conf['css'][] = 'style.css';
//$conf['css'][] = '';
$conf['js'][]  = 'js/prototype.js';
$conf['js'][]  = 'js/scriptaculous.js';

$conf['cache'] = 1; /* 0|1 - off|on */

/* URL base */
$conf['url_root'] = substr(realpath(dirname(__FILE__)),strlen($_SERVER['DOCUMENT_ROOT'])).'/';
$conf['url_abs']  = 1;		/* 0|1 - ?q=path/to/resource|/path/to/resource */

$conf['cache_life'] = 24*60*60;	/* in seconds */

/* Database configuration */
$conf_db_auth = 'mysql://user:passwd@localhost/DB';

?>
