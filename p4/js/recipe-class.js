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

function RecipeStep (t, i) {
	this.type = t;
	this.instructions = i;
};

function Recipe (input) {
	this.last_id = 0;

	this.name = '';
	this.description = '';
	this.type = '';
	this.steps = {};
	this.dependencies = {};

	this.next_id = function () { return 'recipe-step-' + this.last_id++; },
	
	this.add_step = function( box ) {
		var type = box.find('img').attr('title');
		var instruct = box.find('textarea').attr('value');
		var id = box.attr('id');
		var step = new RecipeStep(type, instruct);

		this.steps[id] = step;
		// or css
		box.find('label').text('');
		box.find('textarea').attr('disabled','disabled'	);
		var exec_box = box.clone();
		exec_box.attr('id','exec-'+id);
		exec_box.find('textarea').val(step.instructions);
		$('#recipe-execution').append( exec_box );
	};

	// this should remove a step from the list and then show any dependent object that
	// now has no dependencies
	this.delete_step = function (id) {
		if (id in this.steps) {
			delete this.steps[id];
		}
		if (id in this.dependencies) {
			delete this.dependencies[id];
		}
		for (var dep in this.dependencies) { 
			if (this.dependencies[dep] == id) { 
				delete this.dependencies[dep];
			}
		}
		$('#' + id).remove();
		$('#' + 'exec-' + id).remove();
	};
	
	// add a dependency should also att a class that makes it dependent (not really used)
	this.add_dependency = function ( dependant, depended_upon ) {
		this.dependencies[dependant] = depended_upon;
	};
	
	this.is_empty = function () { is_empty( this.steps ) };

	this.list_step = function() {	
		
	};
	
	this.remove_dependent = function (id) {
		for (idx=0; idx<this.dependencies.length; idx++) {
			dep = this.dependencies[idx];
			if (dep.dependent == id) {
				delete dep;
			}
		}
	}
	this.has_dependency = function (id) {
		return (id in this.dependencies);
	}
	this.clone = function () {
		return jQuery.extend({}, this);
//		var recipe = new Recipe();
//		recipe.name = this.name;
	} 

	if (typeof(input) !== 'undefined') {
		//var recipe = JSON.parse( input );
		this.id = input.id;
		this.name = input.name;
		this.description = input.description;
		this.picture_url = input.picture_url;
		$('#recipe-name').val(this.name);
		$('#recipe-description').val(this.description);
		var steps = input.steps.sort(function (a,b) {return a['seq']-b['seq'];});
		var step_ids = {};
		for(var idx=0; idx<steps.length; idx++) {
			var this_step = steps[idx];
			var step_box = find_step_type( this_step['type_name'] );
			var box = new_step_from_type( this, step_box );
			var step = new RecipeStep( this_step['type'], this_step['instructions'] );
			box.find('textarea').attr('value', this_step['instructions']);
			box.addClass('completed-step');
			this.add_step( box );
			step_ids[this_step['seq']] = box.attr('id');
		}
		var dep = input.dependencies;
		for(var idx=0; idx<dep.length; idx++) {
			var d = dep[idx];
			this.add_dependency(step_ids[d['dependant']], step_ids[d['dependent']]);
		}
	}

}; // eoc