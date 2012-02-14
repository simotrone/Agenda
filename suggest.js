function prepare_suggestion() {
    var url = '/agenda/ajax.php';
    new Ajax.Autocompleter(
	'search', 'suggestions', url,
	{ method: 'get', paramName: 's', parameters: 'format=html' }
    );
}

prepare_suggestion();
