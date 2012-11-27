$(document).ready(function() { // start doc ready; do not delete this!

	$(".icon-block").click ( function() {
		debugger;
		var new_div = $(this).clone();
		new_div.find('form').removeClass('hide');
		new_div.addClass('recipe-step');
		new_div.removeClass('icon-block');
		$("#recipe-step-list").prepend( new_div );
	});
	//$(".icon-block").draggable({ containment: "#recipe-block" });
   	$( ".draggable" ).draggable({ revert: "invalid" });
    $( ".droppable" ).droppable({
		drop: function( event, ui ) {
			var newmarkup = '<div class="droppable"><textarea onfocus="this.value=\'\';">enter description here</textarea></div>';
			$( this )
				.addClass( "ui-state-highlight" )
				.before(newmarkup);
		}
	});
	$('.color-choice').click(function() {
	
		// Figure out which color we should use
		var color = $(this).css('background-color');

		// Change the background color of the canvas
		$('#canvas').css('background-color', color);
		
		// Also change the texture choices
		$('.texture-choice').css('background-color', color);

	});	
	
	$('.texture-choice').click(function() {
		var texture = $(this).css('background-image');
		$('#canvas').css('background-image', texture);
	});

	
	$('.font-choice').click(function() {
		var font = $(this).css('font-family');
		$('#message-in-canvas').css('font-family', font);
		$('#recipient-in-canvas').css('font-family', font);
	});

	$('input[name=message]').click(function() {
	
		var message = $(this).attr('value');
			
		$('#message-in-canvas').html(message);
		
	});
	
	$('#recipient').keyup(function() {
	
		var recipient = $(this).val();
		
		var length = recipient.length;
		
		if(length == 14) {
			$('#recipient-error').html("The max amount of characters is 14");
			$('#recipient-error').show();
		}
		else {
			$('#recipient-error').html("");
			$('#recipient-error').hide();
		}
		
		$('#recipient-in-canvas').html(recipient + "!");
	
	});
	
	$('#graphic-search-button').click(function() {
	
		var search_term = $('#graphic-search-input').val();
		
		var url = 'http://students.susanbuck.net/storage/code/_js/google_images.php?keyword=' + search_term;
				
		$.ajax({
			url: url,
			cache: false,
			beforeSend: function() {
				$('#graphic-search-results').html("Searching...");	
			},
			success: function(data) {
				
				$('#graphic-search-results').html(data);
				
			},
			dataType: "html"
		});
					
	});

	$('.graphic-choice').live('click', function() {
	
		var image = $(this).attr('src');
		
		$('#canvas').prepend("<img class='draggable new-draggable' src='" + image + "'>");
		$(".draggable").draggable({ containment: "#canvas" });
	
	});
	
	
	$('#refresh-button').click(function() {
					
		$('#message-in-canvas').html("");
		$('#recipient-in-canvas').html("");
		$('.draggable').remove();
		$('#canvas').css('background-color', 'white');
		$('#canvas').css('background-image', '');
	
	});
	
	
	$('#print-button').click(function() {
		
		// Setup the window we're about to open	    
	    var print_window =  window.open('','_blank','');
	    
	    // Get the content we want to put in that window - this line is a little tricky to understand, but it gets the job done
	    var contents = $('<div>').html($('#canvas').clone()).html();
	    
	    // Build the HTML content for that window, including the contents
	    var html = '<html><head><link rel="stylesheet" href="card-generator.css" type="text/css"></head><body>' + contents + '</body></html>';
	    
	    // Write to our new window
	    print_window.document.open();
	    print_window.document.write(html);
	    print_window.document.close();
	    		
	});
	

	
}); // end doc ready; do not delete this!
