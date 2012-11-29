$(document).ready(function() { // start doc ready; do not delete this!

	// first extract some static information from hidden divs 
	var edit_buttons = $('#icon-buttons').html();
	// only one of these buttons should be active at a time so it can have an id
	var new_edit_buttons = edit_buttons.replace( /class=\"class/g, 'id="id' );

	var after_buttons = $('#after-buttons').html();

	// When the user clicks on a step icon it should create a dialog in the recipe 
	// with the form included. Then turn off all the icon clickables
	$(".icon-click").live ('click', function() {
		var new_div = $(this).clone();
		new_div.addClass('recipe-step');
		new_div.removeClass('icon-block icon-click');
		new_div.find('.step-actions').html(new_edit_buttons);
		$("#recipe-footer").before( new_div );
		// remove before adding to avoid confusing the browser
		$('.icon-block').removeClass('icon-click');
		$('.icon-block').addClass('icon-error');
		new_div.find('.step-instructions').removeClass('hide');
		new_div.find('.step-actions').removeClass('hide');
	});	

	// clicking on an icon while a step is being filled should emit an error
	$(".icon-error").live ('click', function() {
		$('#message-block').html('Finish this step or cancel it before adding more');
		$('#message-block').removeClass('hide');
	});

	// activate the two action buttons they should turn the icons-click back on
	$('#id-done-button').live ('click', function() {
		debugger;
		var box = $(this).parent().parent();
		var step_type = box.find('img').attr('title');		
		var instructions = box.find('textarea').val();
		box.id = Recipe.next_id();
		if (instructions.length == 0) {
			$('#message-block').html('Cannot add without instructions');
			$('#message-block').removeClass('hide');
		} else {
			$('#message-block').html('');
			$('#message-block').addClass('hide');
			$('.icon-block').removeClass('icon-error');
			$('.icon-block').addClass('icon-click');
			$(this).parent().html(after_buttons);
			Recipe.add_step(step_type,box.id,instructions,[] ); 
		};
	});

	// cancel discards the step being entered
	$('#id-can-button').live ('click', function() {
		console.log('I am in cancel');
		$(this).parent().parent().remove();
		$('#message-block').html('');
		$('#message-block').addClass('hide');
	});
	
	// delete removes an already filled out step
	$('#id-del-button').live ('click', function() {
		console.log('I am in delete');
	});
	
	// execute the recipe
	$('#execute-button').click ( function () {
		Recipe.list_step();
	});
	
	//$(".icon-block").draggable({ containment: "#recipe-block" });
//   	$( ".draggable" ).draggable({ revert: "invalid" });
//     $( ".droppable" ).droppable({
// 		drop: function( event, ui ) {
// 			var newmarkup = '<div class="droppable"><textarea onfocus="this.value=\'\';">enter description here</textarea></div>';
// 			$( this )
// 				.addClass( "ui-state-highlight" )
// 				.before(newmarkup);
// 		}
// 	});
// 	$('.color-choice').click(function() {
// 	
// 		// Figure out which color we should use
// 		var color = $(this).css('background-color');
// 
// 		// Change the background color of the canvas
// 		$('#canvas').css('background-color', color);
// 		
// 		// Also change the texture choices
// 		$('.texture-choice').css('background-color', color);
// 
// 	});	
// 	
// 	$('.texture-choice').click(function() {
// 		var texture = $(this).css('background-image');
// 		$('#canvas').css('background-image', texture);
// 	});
// 
// 	
// 	$('.font-choice').click(function() {
// 		var font = $(this).css('font-family');
// 		$('#message-in-canvas').css('font-family', font);
// 		$('#recipient-in-canvas').css('font-family', font);
// 	});
// 
// 	$('input[name=message]').click(function() {
// 	
// 		var message = $(this).attr('value');
// 			
// 		$('#message-in-canvas').html(message);
// 		
// 	});
// 	
// 	$('#recipient').keyup(function() {
// 	
// 		var recipient = $(this).val();
// 		
// 		var length = recipient.length;
// 		
// 		if(length == 14) {
// 			$('#recipient-error').html("The max amount of characters is 14");
// 			$('#recipient-error').show();
// 		}
// 		else {
// 			$('#recipient-error').html("");
// 			$('#recipient-error').hide();
// 		}
// 		
// 		$('#recipient-in-canvas').html(recipient + "!");
// 	
// 	});
// 	
// 	$('#graphic-search-button').click(function() {
// 	
// 		var search_term = $('#graphic-search-input').val();
// 		
// 		var url = 'http://students.susanbuck.net/storage/code/_js/google_images.php?keyword=' + search_term;
// 				
// 		$.ajax({
// 			url: url,
// 			cache: false,
// 			beforeSend: function() {
// 				$('#graphic-search-results').html("Searching...");	
// 			},
// 			success: function(data) {
// 				
// 				$('#graphic-search-results').html(data);
// 				
// 			},
// 			dataType: "html"
// 		});
// 					
// 	});
// 
// 	$('.graphic-choice').live('click', function() {
// 	
// 		var image = $(this).attr('src');
// 		
// 		$('#canvas').prepend("<img class='draggable new-draggable' src='" + image + "'>");
// 		$(".draggable").draggable({ containment: "#canvas" });
// 	
// 	});
// 	
// 	
// 	$('#refresh-button').click(function() {
// 					
// 		$('#message-in-canvas').html("");
// 		$('#recipient-in-canvas').html("");
// 		$('.draggable').remove();
// 		$('#canvas').css('background-color', 'white');
// 		$('#canvas').css('background-image', '');
// 	
// 	});
// 	
// 	
// 	$('#print-button').click(function() {
// 		
// 		// Setup the window we're about to open	    
// 	    var print_window =  window.open('','_blank','');
// 	    
// 	    // Get the content we want to put in that window - this line is a little tricky to understand, but it gets the job done
// 	    var contents = $('<div>').html($('#canvas').clone()).html();
// 	    
// 	    // Build the HTML content for that window, including the contents
// 	    var html = '<html><head><link rel="stylesheet" href="card-generator.css" type="text/css"></head><body>' + contents + '</body></html>';
// 	    
// 	    // Write to our new window
// 	    print_window.document.open();
// 	    print_window.document.write(html);
// 	    print_window.document.close();
// 	    		
// 	});
// 	
// 
	
}); // end doc ready; do not delete this!
