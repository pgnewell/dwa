<?php

class index_controller extends base_controller {

	public function __construct() {
		parent::__construct();
	} 
	
	/*-------------------------------------------------------------------------------------------------
	Access via http://yourapp.com/index/index/
	-------------------------------------------------------------------------------------------------*/
	public function index() {
		
		# Set up main window and initial displays for each part
		$this->template->content = View::instance('v_index_index');
		$this->template->content->lsb = View::instance('v_index_user');
		$this->template->content->main_display = View::instance('v_build_recipe');
		$this->template->content->rsb = View::instance('v_instructions');
		
		# set the <title> tag
		$this->template->title = "Active Recipe";
	
		# If this view needs any JS or CSS files, add their paths to this 
		# array so they will get loaded in the head
		$client_files = Array(
				"./css/class.css",
				"./css/recipe.css",
				"./css/recipe-builder.css",
				"./js/recipe-class.js",
				"./js/scripts.js",
				"./js/jquery.form.js"
		);

	  $this->template->client_files = Utils::load_client_files($client_files);   

		# Render the view
		echo $this->template;
	}

	public function loadform( $name ) {
		$file = 'v_' . $name;
		echo View::instance( $file );
	}
	
		
} // end class
