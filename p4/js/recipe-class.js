/**
 * 
 * 
 * 
 */

function is_empty(obj) {
	for (var item in obj) {
   		if (obj.hasOwnProperty.call(item)) {
   			return false;
   		}
   	}
 	return true;
}

var done_button = $('#exec-done-button').html();
var RecipeStep = {
	id: '',
	instructions: {}
};

var Recipe = {

	name: '',
	description: '',
	type: '',
	steps: {},
	last_id: 0,

	next_id: function () { return 'recipe-step-' + this.last_id++; },
	
	add_step: function(step) {
		steps[next_id] = step; 	 
	},	

	// this should remove a step from the list and then show any dependent object that
	// now has no dependencies
	delete_step: function (box) {
					
	},
	
	// add a dependency should also att a class that makes it dependent (not really used)
	add_dependency: function ( dependant, depended_upon ) {

	},	
	
	is_empty: function () { is_empty( steps ) },

	list_step: function() {	

	},
	
}; // eoc