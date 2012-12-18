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
