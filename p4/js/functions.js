// A javascript to allow loading html via php or js (ajax) so initial load 
// (from php) and subsequent ajax loads can be done from the same source. means 
// that URLs can be used to load html via ajax which moves the php out of 
// the views.

function loadform ( url, windowdiv ) {
	var loadform_options = { 
		type: 'POST',
		url:  url,
		beforeSubmit: function() {
			$('#results').html("Working...");
		},
		success: function(response) {
			$(windowdiv).html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert("status " + xhr.status + thrownError);
    }
	};
	$.ajax( loadform_options );
};

function test_json ( o ) {
	var test_json_options = { 
		type: 'POST',
		url:  '/index/test_json',
		data: { object: JSON.stringify(o) },
		beforeSubmit: function() {
			$('#results').html("Working...");
		},
		success: function(response) {
			$('body').html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert("status " + xhr.status + thrownError);
    }
	};
	$.ajax( test_json_options );
};

//find the box in recipe-palette for the step type
function find_step_type (type ) {
	var box = $('#recipe-palette .recipe-step').find("img[title='"+type+"']");
	return box.parent();
}

// from the step box make a new builder box
function new_step_from_type ( recipe, type_box ) {
	var id = recipe.next_id();
	var new_box = type_box.clone();
	new_box.attr('id',id);
	$("#recipe-footer").before( new_box );
	return new_box;
}

// for execution find out which steps still are dependent and hide them, 
// show the others
function hide_dependants(recipe) {
	for (var step in recipe.steps) {
		if (step in recipe.dependencies) {
			$('#exec-' + step).hide();
		} else {
			$('#exec-' + step).show();
		}
	}
}

function show_build() {
	$('#recipe-display-list').hide();
	$('#recipe-execution').hide();
	$('#recipe-builder').show();
}

function show_display() {
	$('#recipe-execution').hide();
	$('#recipe-builder').hide();
	$('#recipe-display-list').show();
}

function show_exec(recipe) {
	var exec_recipe = recipe.clone();
	$('#recipe-display-list').hide();
	$('#recipe-builder').hide();
	$('#recipe-execution').show();
	hide_dependants(recipe);
	$('#recipe-execution .exec-done-button').click( function () {
		var step = $(this).parent().parent();
		var id = step.attr('id').replace('exec-', '');
		recipe.delete_step(id);
		hide_dependants(recipe);
	})

}

function clear_recipe() {
	loadform( '/recipe/load_builder', '#recipe-builder' );
	loadform( '/recipe/load_execute', '#recipe-execution')
	loadform( '/step_type/retrieve', '#step-type-list' );
}

function set_depends_button (element) {
	element.click ( function() {
		$('#recipe-content .depends-button').toggleClass( 'depends-on depends-button' );
		// turn both back on
		dependant = element.parent().parent().attr('id');
		element
			.toggleClass( 'dependant depends-on' )
			.attr('value', 'Cancel depends')
			.click ( function () {
				$('#recipe-content .depends-on').toggleClass( 'depends-on depends-button' );
				element.attr('value', 'Depends');
				$('#recipe-content .depends-button').attr('value', 'Depends')
				dependant = '';
			});
		$('#recipe-content .depends-on')
			.attr( 'value', 'Depends on' )
			.click( function () {
				var this_step = $( this ).parent().parent().attr('id');
				this_recipe.add_dependency( dependant, this_step );
				$('#recipe-content .depends-on').toggleClass( 'depends-on depends-button' );
				$('#recipe-content .dependant').toggleClass('dependant depends-button')
				$('#recipe-content .depends-button').attr('value', 'Depends');
				dependant = '';
			});
	});
}