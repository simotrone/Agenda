<?php

/* Convert month number in Italian name string.
 */
function month_name($i) {
    if ($i < 1 && $i > 12)
	return 'Wat? [Error]';
    $month[1] = 'Gennaio';
    $month[2] = 'Febbraio';
    $month[3] = 'Marzo';
    $month[4] = 'Aprile';
    $month[5] = 'Maggio';
    $month[6] = 'Giugno';
    $month[7] = 'Luglio';
    $month[8] = 'Agosto';
    $month[9] = 'Settembre';
    $month[10] = 'Ottobre';
    $month[11] = 'Novembre';
    $month[12] = 'Dicembre';
    return $month[$i];
}

/* Return array with month in db.
 */
function months_in_db() {
    $query = "SELECT DISTINCT MONTH(birth) AS m FROM folks ORDER BY MONTH(birth)";
    $res = db_query($query);
    while( $r = db_fetch_array($res) ) 
	$mon[] = $r['m'];
    return $mon;
}

/* Return an array with all the month's birthdays
 *  or an empty array if there is no result.
 *
 * $birhdays => array(
 *  [0] = array(
 *	id      => ...
 *	name    => ...
 *	surname => ...
 *	birth   => ...
 *  ),
 *  [1] = array( ... ),
 *  ...
 * );
 */
function birthdays_in_month($month, $order = 'day') {
    $query = "SELECT id,name,surname,birth FROM folks WHERE MONTH(birth) = $month ";

    switch($order) {
	case 'name':
	    $query .= ' ORDER BY name,surname ASC';
	    break;
	case 'day':
	default:
	    $query .= ' ORDER BY DAY(birth), surname, name ASC';
    }

    $result = db_query($query);
    $birthdays = array();
    while( $r = db_fetch_array($result) ) {
	$birthdays[] = array(
	    'id'      => $r['id'],
	    'name'    => $r['name'],
	    'surname' => $r['surname'],
	    'birth'   => $r['birth']
	);
    }
    return $birthdays;
}

/* Return full folk data.
 *
 * Folk's data (db fields):
 *  name, surname, birth, gender, address, zip, city, country, email, phone, note
 */
function folk_data($folk_id) {
    $query = "SELECT f.name, f.surname, f.birth, f.gender, ".
	"a.address, a.zip, a.city, a.country, ".
	"e.email, ".
	"p.phone, ".
	"i.note ".
	"FROM folks AS f ".
	"LEFT JOIN addresses AS a ON a.id=f.id ".
	"LEFT JOIN emails    AS e ON e.id=f.id ".
	"LEFT JOIN phones    AS p ON p.id=f.id ".
	"LEFT JOIN info      AS i ON i.id=f.id ".
	"WHERE f.id = $folk_id";
    $result = db_query($query);
    return db_fetch_array($result);
}

?>
