<?php

require_once('includes/init.php');

$search_string = $_GET['s'];

if( empty($search_string) ) {
    header('Location: '.uri_static(''));
    exit(0);
}

$query = 'SELECT id, MONTH(birth) AS month, CONCAT_WS(" ", name, surname) AS name, birth FROM folks '
    .' WHERE name    LIKE "'.$search_string.'%" OR '
    .'       surname LIKE "'.$search_string.'%" OR '
    .' CONCAT_WS(" ",name,surname) LIKE "%'.$search_string.'%" OR '
    .' CONCAT_WS(" ",surname,name) LIKE "%'.$search_string.'%"'
    .' ORDER BY name,surname';
$result = db_query($query);

$num = db_num_rows($result);

/* Just one result... */
if( $num == 1 ) {
    $single = db_fetch_array($result);
    header( 'Location: '.uri_for('month/'.$single['month'].'/folk/'.$single['id']) );
    exit(0);
}

/* For more than one results */
$people = array();
while( $r = db_fetch_array($result) ) {
    $people[] = li( a( 
	uri_for('month/'.$r['month'].'/folk/'.$r['id']),
	$r['name']).' - '.$r['birth'] 
    );
}
$c = h1('Ricerca')
    .p("La ricerca ha portato a $num risultati.")
    .ul(implode("\n\t",$people));

echo draw_html_layout($c);

?>
