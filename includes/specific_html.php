<?php

function draw_html_layout($content = '') {
    global $conf;

    $layout = html_top( $conf['title'], $conf['css'], $conf['js'] )
	.p(
	    /* title */
	    a(uri_static(''), 'Agenda').' - '.date("j F Y")
	    /* ricerca con auto-suggest */
	    .'<form class="right" action="/agenda/search.php">'
	    .input( 's', 'text', 'search' ).input('','submit','','Go')
	    .div( '', '', 'suggestions' )
	    .script( '', uri_static('suggest.js') )
	    .'</form>'
	)
	.draw_month_menu();					    // Main menu (unordered list)

    $layout .= $content;

    $layout .= p('Agenda Interna - Copyright &copy; 2011 Simone Tampieri')
	.html_foot();

    return $layout;
}

/* Draw menu based on month in db.
 *
 * <ul>
 *  <li><a href="uri">month</a></li>
 *  ...
 * </ul>
 */
function draw_month_menu() {
    $months = months_in_db();

    // <li> month name and links
    foreach($months as $mm_number)
	$items[] = li(a(uri_for("month/$mm_number"),month_name($mm_number)));

    $items[]= div('','clearer');
    return ul(implode('',$items), '', 'nav');
}


/* Draw menu. Version 2.
 *  Based on monthes in db AND people in monthes.
 *
 * <ul>
 *  <li><a href="uri">month</a>
 *	<ul>
 *	    <li><a href="uri">folk</a></li>
 *	    <li>...
 *	</ul>
 *  </li>
 *  ...
 */
function draw_month_menu_2() {
    $months = months_in_db();

    // Crea i <li> coi nomi dei mesi e i link
    foreach($months as $mm_number) {
	$menu_item = a(uri_for("month/$mm_number"),month_name($mm_number));
	if( count($folks = birthdays_in_month($mm_number,'name')) > 0 ) {
	    foreach($folks as $f) {
		$sub_items[] = li(a(uri_for("month/$mm_number/folk/".$f['id']),$f['name'].' '.$f['surname']));
	    }
	    $menu_item .= ul(implode('',$sub_items));
	    unset($sub_items);
	}

	$items[] = li($menu_item);
    }

    $items[]= div('','clearer');
    return ul(implode('',$items), '', 'nav');
}

/* Draw birthdates table (of month)
 *
 * <div class="birthday">
 *  <h1>Mese</h1>
 *  <table>
 *	<tr><td>Name</td><td>Birth</td></tr>
 *	...
 *  </table>
 * </div>
 */
function draw_birthdays_table($month) {
    if( (!is_numeric($month)) || ($month < 1) || ($month > 12) )
	return p("ERROR: Wrong data input.",'error');

    $birthdays = birthdays_in_month($month);

    if( empty($birthdays) ) {
	return div( h1(month_name($month)).p("No birthdays this month.") );
    }

    $table = '';
    foreach($birthdays as $folk)
	$table .= tr(
	    td( a(uri_for("month/$month/folk/".$folk['id']),$folk['name'].' '.$folk['surname']) ).
	    td( date("d F (Y)",strtotime($folk['birth'])) )
	);
    return h1(month_name($month)).table($table);
}

/* Draw data for single folk
 *
 * <div id="folk">
 *  <h1>Folk name</h1>
 *  <table>
 *	<tr><td>Attribute</td><td>Value</td></tr>
 *	...
 *  </table>
 * </div>
 */
function draw_folk_data($folk_id) {
    if( !is_numeric($folk_id) )
	return p("ERROR: Wrong data input.",'error');
    
    $folk_data = folk_data($folk_id);
    if( empty($folk_data) )
	return p("ERROR: Data doesn't exists.",'error');
    
    $folk_html = '';
    foreach($folk_data as $field => $value) {
	if(empty($value)) continue;

	switch($field) {
	    case 'birth':
		$value = date( "d F Y", strtotime($value) );
		break;
	    case 'email':
		$value = a("mailto:$value", $value);
		break;
	    case 'gender':
		$value = ($value == 'm') ? 'male' : 'female';
		break;
	}
	$folk_html .= tr( td($field).td($value) );
    }
    return h1($folk_data['name'].' '.$folk_data['surname']).table($folk_html);
}

?>
