<?php

define( 'ROOT' , realpath(dirname(__FILE__).'/../').'/' );
define( 'INC'  , ROOT.'includes/' );
define( 'CACHE', ROOT.'cache/' );

require_once( ROOT.'config.php' );
$rdbms = parse_url($conf_db_auth, PHP_URL_SCHEME);
require_once( INC."db.$rdbms.php" );
db_connect($conf_db_auth);
require_once( INC.'common_functions.php' );
require_once( INC.'common_html.php' );

require_once( INC.'specific_functions.php' );
require_once( INC.'specific_html.php' );


?>
