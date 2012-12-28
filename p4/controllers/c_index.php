<?php

class index_controller extends base_controller {

	public function __construct() {
		parent::__construct();
	} 
	
	/*-------------------------------------------------------------------------------------------------
	Access via http://yourapp.com/index/index/
	-------------------------------------------------------------------------------------------------*/
	public function index($login_message = null) {
		# Set up main window and initial displays for each part
		$this->template->content = View::instance('v_index_index');
		$this->template->content->lsb = View::instance('v_index_user');
		$this->template->content->lsb->message = $login_message;

		//$this->template->content->main_display = View::instance('v_build_recipe');

		//$this->template->content->main_display = View::instance('v_index_loadform');
		//$this->template->content->main_display->url = '/recipe/retrieve_all';
		//$this->template->content->main_display->element = '#main-display';

		//$this->template->content->main_display = View::instance('v_index_loadform');
		//$this->template->content->main_display->url = '/recipe/load_builder';
		//$this->template->content->main_display->element = '#recipe-builder';

		//$this->template->content->main_display = View::instance('v_index_loadform');
		//$this->template->content->main_display->url = '/step_type/retrieve';
		//$this->template->content->main_display->element = '#step-type-list';

		$this->template->content->rsb = View::instance('v_instructions');
		
		# set the <title> tag
		$this->template->title = "Active Cookbook";
	
		# If this view needs any JS or CSS files, add their paths to this 
		# array so they will get loaded in the head
		$client_files = Array(
				"/css/class.css",
				"/css/recipe.css",
				"/css/recipe-builder.css",
				"/js/recipe-class.js",
				"/js/jquery.form.js",
				"/js/functions.js",
				"/js/scripts.js"
		);

	  $this->template->client_files = Utils::load_client_files($client_files);   

		# Render the view
		echo $this->template;
	}

	public function loadform( $name ) {
		$file = 'v_' . $name;
		echo View::instance( $file );
	}
	
	public function test_json () {
		$data = $_POST['object'];
		echo $_POST['object'];
		if (get_magic_quotes_gpc())
			$data = stripslashes($data);
		$obj = json_decode($data);
		echo Debug::dump($obj);
	}
	
		
} // end class
