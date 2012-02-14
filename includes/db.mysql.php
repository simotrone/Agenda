<?php
/* Inspired by Drupal code */

$dbh = '';

function db_connect($url) {
    global $dbh;

    $url = parse_url($url);

    function_exists('mysql_connect')
	or die('Unable to use the MySQL database because the MySQL extension for PHP is not installed.');

    // Decode url-encoded information in the db connection string
    $url['user'] = urldecode($url['user']);
    $url['pass'] = isset($url['pass']) ? urldecode($url['pass']) : '';
    $url['host'] = urldecode($url['host']);
    $url['path'] = urldecode($url['path']);

    // Allow for non-standard MySQL port.
    isset($url['port']) and $url['host'] = $url['host'] .':'. $url['port'];

    $connection = @mysql_connect($url['host'], $url['user'], $url['pass'], TRUE, 2);
    if (!$connection || !mysql_select_db(substr($url['path'], 1))) {
	die(mysql_error());
    }

    $dbh = $connection;

    return $connection;
}

function db_query($query, $debug = 0) {
    global $dbh;
    $result = mysql_query($query, $dbh);

    if ($debug)
	print '<p>query: '. $query .'<br />error:'. mysql_error($dbh) .'</p>';

    return $result;

/*
    if (!mysql_errno($dbh)) {
	return $result;
    } else {
	trigger_error(check_plain(mysql_error($dbh) ."\nquery: ". $query), E_USER_WARNING);
	return FALSE;
    }
 */
}

function db_num_rows($result) {
    if ($result)
	return mysql_num_rows($result);
}

/**
 * Fetch one result row from the previous query as an array.
 *
 * @param $result
 *   A database query result resource, as returned from db_query().
 * @return
 *   An associative array representing the next row of the result, or FALSE.
 *   The keys of this object are the names of the table fields selected by the
 *   query, and the values are the field values for this result row.
 */
function db_fetch_array($result) {
  if ($result)
    return mysql_fetch_array($result, MYSQL_ASSOC);
}

/**
 * Return an individual result field from the previous query.
 *
 * Only use this function if exactly one field is being selected; otherwise,
 * use db_fetch_object() or db_fetch_array().
 *
 * @param $result
 *   A database query result resource, as returned from db_query().
 * 
 * @return
 *   The resulting field or FALSE.
 */
function db_result($result) {
  if ($result && mysql_num_rows($result) > 0) {
    // The mysql_fetch_row function has an optional second parameter $row
    // but that can't be used for compatibility with Oracle, DB2, etc.
    $array = mysql_fetch_row($result);
    return $array[0];
  }
  return FALSE;
}

/**
 * Determine whether the previous query caused an error.
 */
function db_error() {
  global $dbh;
  return mysql_errno($dbh);
}

/**
 * Determine the number of rows changed by the preceding query.
 */
function db_affected_rows() {
  global $dbh;
  return mysql_affected_rows($dbh);
}


/**
 * Returns a properly formatted Binary Large OBject value.
 *
 * @param $data
 *   Data to encode.
 * @return
 *  Encoded data.
 */
function db_encode_blob($data) {
  global $dbh;
  return "'". mysql_real_escape_string($data, $dbh) ."'";
}


// Prepare user input for use in a database query, preventing SQL injection attacks.
function db_escape_string($text) {
  global $dbh;
  return mysql_real_escape_string($text, $dbh);
}

/**
 * Fetch one result row from the previous query as an object.
 *
 * @param $result
 *   A database query result resource, as returned from db_query().
 * @return
 *   An object representing the next row of the result, or FALSE. The attributes
 *   of this object are the table fields selected by the query.
 */
/*
 * function db_fetch_object($result) {
  if ($result)
    return mysql_fetch_object($result);
}
 */

