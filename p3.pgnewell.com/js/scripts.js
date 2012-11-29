$(document).ready(function() { // start doc ready; do not delete this!

	// first extract some static information from hidden divs 
	var edit_buttons = $('#icon-buttons').html();
	// only one of these buttons should be active at a time so it can have an id
	var new_edit_buttons = edit_buttons.replace( /class=\"class/g, 'id="id' );

	var after_buttons = $('#after-buttons').html();
	var done_button = $('#exec-done-button').html();

	// When the user clicks on a step icon it should create a dialog in the recipe 
	// with the form included. Then turn off all the icon clickables
	$(".icon-click").live ('click', function() {
		var new_box = $(this).clone();
		new_box.addClass('recipe-step');
		new_box.removeClass('icon-block icon-click');
		new_box.find('.step-actions').html(new_edit_buttons);
		new_box.id = Recipe.next_id();
		$("#recipe-footer").before( new_box );
		// remove before adding to avoid confusing the browser
		$('.icon-block').removeClass('icon-click');
		$('.icon-block').addClass('icon-error');
		new_box.find('.step-instructions').removeClass('hide');
		new_box.find('.step-actions').removeClass('hide');
	});	

	// clicking on an icon while a step is being filled should emit an error
	$(".icon-error").live ('click', function() {
		$('#message-block').html('Finish this step or cancel it before adding more');
		$('#message-block').removeClass('hide');
	});

	// activate the two action buttons they should turn the icons-click back on
	$('#id-done-button').live ('click', function() {
		var box = $(this).parent().parent();
		var step_type = box.find('img').attr('title');		
		var instructions = box.find('textarea').val();
		if (instructions.length == 0) {
			$('#message-block').html('Cannot add without instructions');
			$('#message-block').removeClass('hide');
		} else {
			$('#message-block').html('');
			$('#message-block').addClass('hide');
			$('.icon-block').toggleClass('icon-error icon-click');
			$(this).parent().html(after_buttons);
			box.find('label').text('');
			Recipe.add_step(step_type,box.id,instructions,[] );
			box.find('textarea').attr('disabled','disabled'	);
			var exec_box = box.clone();
			exec_box.id = 'exec-'+box.id;
			$('#recipe-execution').append( exec_box );
		};
	});

	// cancel discards the step being entered
	$('#id-can-button').live ('click', function() {
		$(this).parent().parent().remove();
		$('#message-block').html('');
		$('#message-block').addClass('hide');
		$('.icon-block').toggleClass('icon-error icon-click');
	});
	
	// delete removes an already filled out step - I'm not giving any warning or
	// giving any option to change your mind
	$('.class-del-button').live ('click', function() {
		var some_id = $(this).parent().parent().id();
		var box = $(this).parent().parent();
		var this_id = box.id().replace( /exec-/, '' );
		Recipe.delete( this_id );
		box.remove();
		
	});
	
	// execute the recipe
	$('#execute-recipe	').click ( function () {
		Recipe.list_step();
		$('#recipe-execution').removeClass('hide');
	});

//	$(".icon-block").draggable({ containment: "#recipe-block" });
//   	$( ".draggable" ).draggable({ revert: "invalid" });
//     $( ".droppable" ).droppable({
// 		drop: function( event, ui ) {
// 			var newmarkup = '<div class="droppable"><textarea onfocus="this.value=\'\';">enter description here</textarea></div>';
// 			$( this )
// 				.addClass( "ui-state-highlight" )
// 				.before(newmarkup);
// 		}
// 	});
	
}); // end doc ready; do not delete this!
