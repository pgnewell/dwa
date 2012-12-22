$(document).ready(function() { // start doc ready; do not delete this!

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

	// -----------------------------------------------------------------
	// the actions related to a new recipe should be here
	
	$('#recipe-build').click( function () {
		show_build();
	});

	$('#user-signup').click( function () {
		loadform( '/index/loadform/users_signup', '#main-display');
	});

	$('#users-profile').click( function () {
		loadform( '/users/profile', '#main-display');
	});

	$('.display-recipe-exec').live ( 'click', function (){
		var id = $(this).attr('id').replace('exec-', '');
		var options = { 
			type: 'POST',
			url: '/recipe/retrieve_recipe/' + id,
			beforeSubmit: function() {
				$('#message-block').html("Loading recipe...");
			},
			success: function(response) {
				var load_recipe = JSON.parse(response);
				this_recipe = new Recipe(load_recipe);
				show_exec(this_recipe);
				
			} 
		}; 
		$.ajax(options);
		
	});
	var this_recipe = new Recipe();

	// -----------------------------------------------------------------

	// When the user clicks on a step icon it should create a dialog in the 
	// recipe with the form included. visibility is determined by css - turn 
	// off step icons
	$("#recipe-palette .recipe-step").live ('click', function() {
		var new_box = new_step_from_type(this_recipe,$(this));
		new_box.addClass( 'current-step' );
		$('#recipe-palette .recipe-step').toggleClass('icon-error recipe-step');
	});	

	// activate the two action buttons turn the icons-click back on
	$('.current-step .build-done-button').live ('click', function() {
		var box = $(this).parent().parent();
		var instruct = box.find('textarea').attr('value');
		if (box.find('textarea').val().length == 0) {
			$('#message-block').html('Cannot add without instructions');
		} else {
			$('#message-block').html('');
			this_recipe.add_step( box );
			box.toggleClass( 'current-step completed-step' );
			$('#recipe-palette .icon-error').toggleClass('icon-error recipe-step');
		};
	});

	$('#save-recipe').live( 'click', function () {
		this_recipe.name = $('#recipe-name').val();
		this_recipe.description = $('#recipe-description').val();
		var options = { 
			type: 'POST',
			url: '/recipe/save/',
			data: { recipe: JSON.stringify(this_recipe) },
			beforeSubmit: function() {
				$('#message-block').html("Saving recipe...");
			},
			success: function(response) {
				$('#message-block').html("Your recipe was added with id: " + response);
				this_recipe.id = response;
			} 
		}; 
		$.ajax(options);
	});

	$('#main-header h1').click( function () {
		loadform( '/recipe/retrieve_all', '#main-display');
	})
	// clicking on an icon while a step is being filled should emit an error
	$(".icon-error").live ('click', function() {
		$('#message-block').html('Finish this step or cancel it before adding more');
	});

	// cancel discards the step being entered
	$('.current-step .del-button').live ('click', function() {
		$(this).parent().parent().remove();
		$('#message-block').html('');
		$('#recipe-palette .icon-error').toggleClass('icon-error recipe-step');
	});
	
	// delete removes an already filled out step - I'm not giving any warning or
	// giving any option to change your mind
	$('.completed-step .del-button').live ('click', function() {
		var box = $(this).parent().parent();
		var id = box.attr('id');
		this_recipe.delete_step(id);		
	});

	// depends disables itself and makes all other depends buttons "depends on"
	$('.depends-button').live ('click', function() {
		dependant = $( this ).parent().parent().attr('id');
		$( this ).removeClass( 'depends-button');
		$( this ).addClass( 'dependant' );
		$('.depends-button').toggleClass( 'depends-button depends-on' );
		$('.depends-on')
			.attr( 'value', 'Depends on' )
			.click( function () {
				var this_step = $( this ).parent().parent().attr('id');
				this_recipe.add_dependency( dependant, this_step );
				$('.depends-on').toggleClass( 'depends-button depends-on' );
				$('.depends-button').attr('value', 'Depends');
				dependant = '';
			});
	});

	// execute the recipe
	$('#execute-recipe').click ( function () {
		$('#recipe-execution textarea').prop('disabled', true);
		show_exec(this_recipe);
	});

loadform( '/recipe/retrieve_all','#recipe-display-list' );
loadform( '/recipe/load_builder', '#recipe-builder' );
loadform( '/step_type/retrieve', '#step-type-list' );

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
