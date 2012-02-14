<?php
require_once('includes/init.php');

if( isset($_GET['folk']) ) {
    echo draw_folk_data($_GET['folk']);
    exit(0);
}

if( isset($_GET['s']) ) {
    $kw = $_GET['s'];
    $format = !empty($_GET['format']) ? $_GET['format'] : 'xml';
    $output = get_suggestion($kw,$format);
    if( $format == 'xml' )
	xml_header();
    echo $output;
}

function xml_header() {
    header('Cache-Control: no-cache, must-revalidate');
    header('Pragma: no-cache');
    header('Content-Type: text/xml');
}

function get_suggestion( $keyword, $format = 'xml' ) {
    $patterns = array( '/"+/', '/%+/' );
    $keyword = preg_replace( $patterns , '' , trim($keyword));

    if( !empty($keyword) )
	$query = 'SELECT id, CONCAT_WS(" ", name, surname) AS name, MONTH(birth) AS month, birth FROM folks WHERE name LIKE "'.$keyword.'%" OR surname LIKE "'.$keyword.'%"';
    else
	$query = 'SELECT name FROM folks WHERE name = ""'; /* query return empty */

    $result = db_query($query);

    $output = '';
    switch($format) {
        case 'html':
	    $items = array();
	    while( $r = db_fetch_array($result) ) {
		// $items[] = li(a( uri_for('month/'.$r['month'].'/folk/'.$r['id']), $r['name']) );
		$items[] = li( $r['name'] );
	    }
	    $output .= ul(implode('',$items));
	    break;
        case 'xml':
	default:
	    $dom = new DOMDocument();
	    $root = $dom->createElement('response');

	    while( $r = db_fetch_array($result) ) {
		$folk     = $dom->createElement('folk');

		$id     = $dom->createElement('id');
		$id->appendChild($dom->createTextNode($r['id']));
		$folk->appendChild($id);

		$name     = $dom->createElement('name');
		$name->appendChild($dom->createTextNode($r['name']));
		$folk->appendChild($name);

		$birth     = $dom->createElement('birth');
		$birth->appendChild($dom->createTextNode($r['birth']));
		$folk->appendChild($birth);

		$root->appendChild($folk);
	    }

	    $dom->appendChild($root);
	    $output .= $dom->saveXML();
    }

    return $output;
}

exit(0);

/* // XML approach
 *

    $msg = $dom->createElement('message');
    $msg->appendChild( $dom->createTextNode('Bad try!') );
    $root->appendChild($msg);


// build the XML structure in a string variable
$xmlString = $dom->saveXML();

// Draw xml document
header('Content-Type: text/xml');
echo $xmlString;

exit(0);
*/
?>
