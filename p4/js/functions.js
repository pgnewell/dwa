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
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert("status " + xhr.status + thrownError);
    }
	};
	$.ajax( loadform_options );
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
	$('#recipe-content .completed-step').remove();
	$('#recipe-name').val('');
	$('#recipe-description').val('');
}