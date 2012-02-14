/* Test prototype Simone 
 * 2011-03-06
 */

function call_folk(folk_id) {
    var url = '/agenda/ajax.php';
    var params = "folk=" + folk_id;
    var ajx = new Ajax.Updater(
	    'folk', url,
	    { method: 'get', parameters: params, onFailure: handleError, onComplete: draw_div }
	);
}
function handleError(request,hdr) {
    alert(hdr);
}
function draw_div() {
    var div = $('folk');
    div.setStyle({ display: 'none' });
    div.appear({ duration: 0.8 });
}

function event_on_link(link) {
    link.observe('click',accadde_domani);
}
function accadde_domani(event) {
    var folk_id = this.readAttribute('href').sub(/^.*folk\/([0-9]+)$/, function(match){
	return match[1];
    });
	// Perchè restituisce due matchate? (il link intero e il group)
    call_folk(folk_id);
    event.stop();
}

function prepare_subnav_links() {
    $("nav").select('ul').each( function(node) {
	node.select('a').each(event_on_link);
    });
}
function prepare_table_links() {
    $("birthdays").select('a').each(event_on_link);
}
// prepare_subnav_links();
// prepare_table_links();

function ingrandiscimi(event) {
    new Effect.Scale("folk", 200, {});
//  event.stop();
    return false;
}
function prepare_folk_title() {
    try {
	h1 = $("folk").down('h1');
	handler = h1.on('mouseover', function () { $('folk').setOpacity(0.9) });
	handler.stop;
	h1.observe('click',ingrandiscimi);
    } catch(error) {
    }
    return false;
}
// prepare_folk_title();
