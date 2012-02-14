<?php

require_once('includes/init.php');

function draw_html_page($uri) {
    $resource = uri_dispatcher($uri);
    global $conf;
    global $cache_filename;

    if(array_key_exists('blank',$resource)) {
	$content = '';
    } else {
	$birthdays_table = isset($resource['month']) ? draw_birthdays_table($resource['month']) : '';
	$folk_div        = isset($resource['folk'])  ? draw_folk_data($resource['folk'])        : '';
	$content = div( $birthdays_table , 'left' , 'birthdays' )
	    .div( $folk_div        , 'right', 'folk' )
	    .div('','clearer');
    }

    $output = draw_html_layout($content);
    
    if( $conf['cache'] )
	file_put_contents( $cache_filename , $output ); // caching

    echo $output;
    return 'show fresh content';
}

/* Dispatching */
$uri = (isset($_GET['q']) && !empty($_GET['q']))
    ? $_GET['q']
    : 'month/'.date("n");

/* Check the cache... */
$cache_filename = CACHE.md5($uri);
if( $conf['cache'] && file_exists($cache_filename) && (time() - filemtime($cache_filename) <= $conf['cache_life']) ) {
    echo file_get_contents($cache_filename);
    return 'show cached content';
} else {
    draw_html_page( $uri );
}

exit(0);
?>
