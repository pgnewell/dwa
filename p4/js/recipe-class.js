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
function RecipeStep (data) {
	this.data = data;
	this.id = '';
	this.instructions = {};
	this.save = function (html) {
		ajax_call = "/recipe_step/save/" + html;
	};
	this.html = function () {
		html = '<div class="icon-block icon-click">' +
		  this.data.html + '</div>';
		return html;
		
	};
};

function Recipe () {

	this.name = '';
	this.description = '';
	this.type = '';
	this.steps = {};
	this.last_id = 0;
	this.dependencies = {};

	this.next_id = function () { return 'recipe-step-' + this.last_id++; },
	
	this.add_step = function(step) {
		steps[next_id] = step; 	 
	};

	// this should remove a step from the list and then show any dependent object that
	// now has no dependencies
	this.delete_step = function (box) {
					
	};
	
	// add a dependency should also att a class that makes it dependent (not really used)
	this.add_dependency = function ( dependant, depended_upon ) {

	};
	
	this.is_empty = function () { is_empty( steps ) };

	this.list_step = function() {	

	};
	
}; // eoc