// A javascript to allow loading html via php or js so initial load (from 
// php) and subsequent ajax loads can be done from the same source. means 
// that URLs can be used to load html which moves the php out of the views.

function loadform ( url, windowdiv ) {
	var loadform_options = { 
		type: 'POST',
		url:  url,
		beforeSubmit: function() {
			$('#results').html("Working...");
		},
		success: function(response) {
			$(windowdiv).html(response);
		}
	};
	$.ajax( loadform_options );
};
