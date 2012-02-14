<?php

/* html_top draw html header */
function html_top($local_title = NULL, $css_array = array(), $js_array = array()) {
    $top = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">'."\n"
	."<html>\n"
	."<head>\n"
	."\t<title>$local_title</title>\n"
	."\t".hlink(uri_static('favicon.ico'), 'icon', 'image/x-icon')."\n";

    /* Create link to css files */
    foreach( $css_array as $css_file) {
	if( empty($css_file) ) continue;
	$top .= "\t".hlink(uri_static($css_file))."\n";
    }

    /* Create link to js files */
    foreach( $js_array as $js_file ) {
	if( empty($js_file) ) continue;
	$top .= "\t".script('',uri_static($js_file))."\n";
    }

    $top .= "</head>\n"
	."<body>\n";
    return $top;
}

function html_foot() {
    return "\n</body>\n"
	."</html>\n";
}

/* Lists */
function li($item) { return "\t<li>$item</li>\n"; } 
function ol($list, $class='', $id='') {
    return sprintf( "<ol%s%s>\n$list</ol>\n",
	$id    ? " id=\"$id\"" : '',
	$class ? " class=\"$class\"" : '');
}
function ul($list, $class='', $id='') {
    return sprintf( "<ul%s%s>\n$list</ul>\n",
	$id    ? " id=\"$id\"" : '',
	$class ? " class=\"$class\"" : '');
}

function div($content, $class = '', $id = '') {
    return sprintf("<div%s%s>%s</div>\n",
	!empty($id)    ? " id=\"$id\"" : '',
	!empty($class) ? " class=\"$class\"" : '',
	$content      ? "\n\t$content\n" : '' );
}

function span($content, $class = '', $id = '') {
    return sprintf("<span%s%s>%s</span>\n",
	!empty($id)    ? " id=\"$id\"" : '',
	!empty($class) ? " class=\"$class\"" : '',
	$content      ? "\n\t$content\n" : '' );
}

function h1($string) { return "<h1>$string</h1>\n"; }
function h2($string) { return "<h2>$string</h2>\n"; }
function h3($string) { return "<h3>$string</h3>\n"; }
function h4($string) { return "<h4>$string</h4>\n"; }
function h5($string) { return "<h5>$string</h5>\n"; }
function h6($string) { return "<h6>$string</h6>\n"; }

function p($string, $class='') {
    return sprintf("<p%s>$string</p>\n",
	$class ? " class=\"$class\"" : '');
}
function a($url, $text='', $class='') {
    return sprintf("<a%shref=\"$url\">%s</a>",
	$class ? " class=\"$class\" " : ' ',
	$text  ? $text : $url );
}

function hlink($href, $rel = 'stylesheet', $type = 'text/css' ) {
    return sprintf( "<link%s%s%s/>",
	!empty($rel)  ? ' rel="'.$rel.'"'   : '',
	!empty($type) ? ' type="'.$type.'"' : '',
	!empty($href) ? ' href="'.$href.'"' : ''	
    );
}

function script( $code='', $src='', $type='text/javascript' ) {
    return sprintf( "<script%s%s>%s</script>\n",
	!empty($type) ? ' type="'.$type.'"' : '',
	!empty($src)  ? ' src="'.$src.'"'   : '',
	!empty($code) ? "$code"             : ''
    );
}
function noscript($string) {
    return "<noscript>$string</noscript>\n";
}


/* Table */
function table($string) {
    return "<table>\n$string\n</table>\n";
}
function tr($string) {
    return "<tr>$string</tr>\n";
}
function th($string) { return "<th>$string</th>"; }
function td($string) { return "<td>$string</td>"; }


/* Form */
function input( $name, $type = 'text', $id = '', $value = '' ) {
    return sprintf("<input%s%s%s%s/>\n",
	!empty($name) ? " name=\"$name\"" : '',
	!empty($type) ? " type=\"$type\"" : '',
	!empty($id)   ? " id=\"$id\"" : '',
	!empty($value) ? " value=\"$value\"" : '' );
}
?>
