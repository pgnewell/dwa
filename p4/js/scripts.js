$(document).ready(function() { // start doc ready; do not delete this!

	// first extract some static information from hidden divs 
	var edit_buttons = $('#icon-buttons').html();
	// only one of these buttons should be active at a time so it can have an id
	var new_edit_buttons = edit_buttons.replace( /class=\"class/g, 'id="id' );
	var after_buttons = $('#after-buttons').html();
	var dependant = '';
	//var subview_options = { 
	//	type: 'POST',
	//	url: '/step_type/retrieve/',
	//	beforeSubmit: function() {
	//		$('#results').html("Working...");
	//	},
	//	success: function(response) {
	//		step_types = jQuery.parseJSON( response );
	//		
	//		for( i=0; i< step_types.length; i++ ){
	//			var step = new RecipeStep (step_types[i]);
	//			html = step.html();
	//			$('#step-type-list').append(html);
	//		}
	//	} 
	//};

	$('#recipe-build').click( function () {
		loadform( '/recipe/load_builder', '#main-display');
		loadform( '/step_type/retrieve', '#step-type-list' );
	});

	$('#user-signup').click( function () {
		loadform( '/index/loadform/users_signup', '#main-display');
	});

	$('#save-step').click( function () {
		var steps = $("#recipe-palette .icon-block").find('form');
		for (var i=0; i<steps.length; i++ ) {
			var step = steps[i];
			var thisForm = step.find('form');
			var recipeStep = new RecipeStep();
			recipeStep.save(json);
		}
	});
	
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
	$('#id-done-button').live ('click', function() {
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
	$('#id-can-button').live ('click', function() {
		$(this).parent().parent().remove();
		$('#message-block').html('');
		$('#message-block').addClass('hide');
		$('.icon-block').toggleClass('icon-error icon-click');
	});
	
	// delete removes an already filled out step - I'm not giving any warning or
	// giving any option to change your mind
	$('.class-del-button').live ('click', function() {
		var box = $(this).parent().parent();
		Recipe.delete_step( box );		
	});

	// depends disables itself and makes all other depends buttons "depends on"
	$('.class-depends-button').live ('click', function() {
		dependant = $( this ).parent().parent().attr('id');
		$( this ).removeClass( 'class-depends-button');
		$( this ).addClass( 'dependant' );
		$('.class-depends-button').toggleClass( 'class-depends-button depends-on' );
		$('.depends-on')
			.attr( 'value', 'Depends on' )
			.click( function () {
				var this_step = $( this ).parent().parent().attr('id');
				Recipe.add_dependency( dependant, this_step );
				$('.depends-on').addClass( 'class-depends-button' );
				$('.depends-on').removeClass( 'depends-on' );
				$('.class-depends-button').attr('value', 'Depends');
				dependant = '';
			});
	});

	// execute the recipe
	$('#execute-recipe').click ( function () {
		$('recipe-content').addClass( 'hide' );
		$('recipe-palette').addClass( 'hide' );
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
