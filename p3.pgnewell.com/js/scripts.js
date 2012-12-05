$(document).ready(function() { // start doc ready; do not delete this!

	// first extract some static information from hidden divs 
	var edit_buttons = $('#icon-buttons').html();
	// only one of these buttons should be active at a time so it can have an id
	var new_edit_buttons = edit_buttons.replace( /class=\"class/g, 'id="id' );
	var after_buttons = $('#after-buttons').html();
	var dependant = '';
	
	// When the user clicks on a step icon it should create a dialog in the recipe 
	// with the form included. Then turn off all the icon clickables
	$(".icon-click").live ('click', function() {
		var new_box = $(this).clone();
		new_box.addClass('recipe-step');
		new_box.removeClass('icon-block icon-click');
		new_box.find('.step-actions').html(new_edit_buttons);
		new_box.attr('id',Recipe.next_id());
		$("#recipe-footer").before( new_box );
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
	$('.done-button').live ('click', function() {
		var box = $(this).parent().parent();
		if (box.find('textarea').val().length == 0) {
			$('#message-block').html('Cannot add without instructions');
			$('#message-block').removeClass('hide');
		} else {
			$('#message-block').html('');
			$('#message-block').addClass('hide');
			Recipe.add_step( box );
			$(this).parent().html(after_buttons);
		};
	});

	// cancel discards the step being entered
	$('.can-button').live ('click', function() {
		$(this).parent().parent().remove();
		$('#message-block').html('');
		$('#message-block').addClass('hide');
		$('.icon-block').toggleClass('icon-error icon-click');
	});
	
	// delete removes an already filled out step - I'm not giving any warning or
	// giving any option to change your mind
	$('.del-button').live ('click', function() {
		var box = $(this).parent().parent();
		Recipe.delete_step( box );		
	});

	// depends disables itself and makes all other depends buttons "depends on"
	$('.depends-button').live ('click', function() {
		dependant = $( this ).parent().parent().attr('id');
		$( this ).removeClass( 'depends-button');
		$( this ).addClass( 'dependant' );
		$('.depends-button')
			.attr( 'value', 'Depends on' )
			.toggleClass( 'depends-button depends-on' );
	});

	// 
	$('.depends-on').live ( 'click', function () {
		var this_step = $( this ).parent().parent().attr('id');
		Recipe.add_dependency( dependant, this_step );
		$('.depends-on')
			.attr('value', 'Depends')
			.toggleClass( 'depends-button depends-on' );
		$('.dependant').toggleClass( 'dependant depends-button' );
		dependant = '';
	});
	
	// execute the recipe
	$('#execute-recipe').click ( function () {
		$('#recipe-content').addClass( 'hide' );
		$('#recipe-palette').addClass( 'hide' );
		$('#recipe-execution').removeClass('hide');
	});

	// This should do more than this but I have to figure out object references in
	// Javascript before I can make it dependencies work.
	$('.exec-done-button').live ('click', function() {
		$( this ).parent().parent().remove();
		if ($('.exec-done-button').length == 1) {
			alert('recipe is done. Page will reload');
			window.location.reload();
		}
	});
	
	// provide a way back even if it is real cheap
	$('#exec-clear').click( function () {
		$(document).reload();
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
