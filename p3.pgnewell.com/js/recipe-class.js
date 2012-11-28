/**
*/

var Recipe = {

	steps: [],
	last_id: 0,
	
	next_id: function () { return 'recipe-step-' + this.last_id++; },
	
	/*-------------------------------------------------------------------------------------------------
	@param {string} step_type
	@param {string} step_id
	@param {string} description
	@return void
	-------------------------------------------------------------------------------------------------*/
	add_step: function(step_type, step_id, description, deps) {

		var this_step = [];
		
		this_step['type'] = step_type;
		this_step['id'] = step_id;
		this_step['desc'] = description;
		this_step['dependents'] = deps;
		this.steps[this.steps.length] = this_step;

	},	

	/*-------------------------------------------------------------------------------------------------
	@return void
	-------------------------------------------------------------------------------------------------*/
	execute: function() {
	},
	
	/*-------------------------------------------------------------------------------------------------
	@param {string} step - step id of function depended upon
	@return void
	-------------------------------------------------------------------------------------------------*/
	turn_on_dependents: function (step) {
	},
	
	is_done: function () {
	},
	
	list_step: function() {	
		debugger; 
		console.log( this.steps ); 
	},
	
}; // eoc