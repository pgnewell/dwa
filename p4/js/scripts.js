$(document).ready(function() { // start doc ready; do not delete this!

	var dependant = '';

	loadform( '/recipe/retrieve_all','#recipe-display-list' );
	loadform( '/recipe/load_builder', '#recipe-builder' );
	loadform( '/step_type/retrieve', '#step-type-list' );
	loadform( '/recipe/load_execute', '#recipe-execution')

	$('#recipe-build').click( function () {
		this_recipe = new Recipe();
		clear_recipe();
		show_build();
	});

	$('#user-signup').click( function () {
		loadform( '/index/loadform/users_signup', '#main-display');
	});

	$('#users-profile-button').click( function () {
		loadform( '/users/profile', '#user-profile');
		show_form( '#user-profile' );
		$('#profile-return').click( return_to_main );
	});

	$('.display-recipe-edit').live ( 'click', function () {
		var id = $(this).attr('id').replace('edit-', '');
		var options = { 
			type: 'POST',
			url: '/recipe/retrieve_recipe/' + id,
			beforeSubmit: function() {
				$('#message-block').html("retrieving recipe " + id);
			},
			success: function(response) {
				var load_recipe = JSON.parse(response);
				this_recipe = new Recipe( load_recipe );
				show_build();
			}
		}; 
		$.ajax(options);
	});

	$('.display-recipe-del').live ( 'click', function () {
		var row = $(this).parent().parent();
		var id = $(this).attr('id').replace('del-', '');
		var options = { 
			type: 'POST',
			url: '/recipe/delete/' + id,
			beforeSubmit: function() {
				$('#message-block').html("deleting recipe " + id);
			},
			success: function(response) {
				var load_recipe = JSON.parse(response);
				$('#exec-' + id).parent().parent().hide();;
				$('#message-block').html("deleted recipe " + response);
			}
		}; 
		$.ajax(options);
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
	$("#recipe-palette .recipe-step").live( 'click', function() {
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
		if (this_recipe.name == '') {
			$('#message-block').html("You must enter a name to save a recipe");
		} else {
			this_recipe.description = $('#recipe-description').val();
			var options = { 
				type: 'POST',
				url: '/recipe/save/',
				data: { recipe: JSON.stringify(this_recipe) },
				beforeSubmit: function() {
					$('#message-block').html("Saving recipe...");
				},
				success: function(response) {
					if (!isNaN(response)) {
						$('#message-block').html("Your recipe was added with id: " + response);
						this_recipe = new Recipe();
						clear_recipe();
						loadform( '/recipe/retrieve_all', '#recipe-display-list');
						show_display();
					} else {
						$('#message-block').html("Save failed with " + response);
					}
					this_recipe.id = response;
				},
				error: function(xhr, tStatus, err) {
					$('#message-block').html('save failed with:');
				}
			}; 
			$.ajax(options);
		}
	});

	$('#main-header h1').click( return_to_main );
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
	$('#recipe-content .depends-button').live ('click', function() {
		dependant = $( this ).parent().parent().attr('id');
		$( this ).toggleClass( 'depends-button dependant' );
		$('#recipe-content .depends-button').toggleClass( 'depends-button depends-on' );
		$('#recipe-content .depends-on').attr('value', 'Depends on');
	});

	$('#recipe-content .depends-on').live ('click', function() {
		var this_step = $( this ).parent().parent().attr('id');
		this_recipe.add_dependency( dependant, this_step );
		$('#recipe-content .depends-on').toggleClass( 'depends-button depends-on' );
		$('#recipe-content .dependant').toggleClass( 'depends-button dependant' );
		$('#recipe-content .depends-button').attr('value', 'Depends');
		dependant = '';
	});

	// execute the recipe
	$('#execute-recipe').click ( function () {
		$('#recipe-execution textarea').prop('disabled', true);
		show_exec(this_recipe);
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
