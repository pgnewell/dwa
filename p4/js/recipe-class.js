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

function RecipeStep (t, i) {
	this.type = t;
	this.instructions = i;
};

function Recipe () {

	this.name = '';
	this.description = '';
	this.type = '';
	this.steps = {};
	this.last_id = 0;
	this.dependencies = {};

	this.next_id = function () { return 'recipe-step-' + this.last_id++; },
	
	this.add_step = function( id, step) {
		this.steps[id] = step; 	 
	};

	// this should remove a step from the list and then show any dependent object that
	// now has no dependencies
	this.delete_step = function (id) {
		delete this.steps[id];
		delete this.dependencies[id];
		for (var dep in this.dependencies) { 
			if (this.dependencies[dep] = id) { 
				delete this.depedencies[dep];
			}
		}
	};
	
	// add a dependency should also att a class that makes it dependent (not really used)
	this.add_dependency = function ( dependant, depended_upon ) {
		this.dependencies[dependant] = depended_upon;
	};
	
	this.is_empty = function () { is_empty( this.steps ) };

	this.list_step = function() {	
		
	};
	
	this.has_dependency = function (id) {
		return (id in this.dependencies);
	}
	this.clone = function () {
		return jQuery.extend({}, this);
//		var recipe = new Recipe();
//		recipe.name = this.name;
	} 
	
}; // eoc