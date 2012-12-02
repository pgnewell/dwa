/**
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
	add_step: function(box) {

		var this_step = {};
		
		var step_type = box.find('img').attr('title');
		var step_id = box.attr( 'id' );		
		var instructions = box.find('textarea').val();
		$('.icon-block').toggleClass('icon-error icon-click');
		box.find('label').text('');
		box.find('textarea').attr('disabled','disabled'	);
		var exec_box = box.clone();
		exec_box.attr('id','exec-'+box.id);
		exec_box.find('.step-actions').html(done_button);
		$('#recipe-execution').append( exec_box );

		this_step.type= step_type;
		this_step.desc = instructions;
		this_step.dependency = {};
		this.steps[step_id] = this_step;

	},	

	// this should remove a step from the list and then show any dependent object that
	// now has no dependencies
	delete_step: function (box) {
		var step_id = box.attr('id');
		$('.depends-on-'+step_id).removeClass( 'depends-on-'+step_id );

		// doesn't work from some reason - istep doesn't the get objects in steps
		for (var step in this.steps) {
			var istep = this.steps[step];
			if (istep.dependency.hasOwnProperty(step_id)) {
				delete istep.dependency[step_id];
				if (is_empty( istep.dependency )) {
					$('.exec-'+step_id).removeGroup( 'hide' );
				}
			}
		}				
		box.remove();
		delete this.steps[step_id];
					
	},
	
	// add a dependency should also att a class that makes it dependent (not really used)
	add_dependency: function ( dependant, depended_upon ) {
		this.steps[dependant].dependency = depended_upon;
	},	
	
	is_empty: function () { is_empty( steps ) },

	list_step: function() {	
		console.log( this.steps ); 
	},
	
}; // eoc