ß<?php
class step_type_controller extends base_controller {

	static $step_map = [];
	
  public function __construct() {
    parent::__construct();

  }

	public function load_window ($elementid) {
		$view  = View::instance('v_index_loadform');
		$view->url = '/step_type/retrieve';
		$view->element = $elementid;
	}
	
	#
	public function retrieve() {
		$response = '';
		$view = View::instance('v_recipe_step');
    $steps = DB::instance(DB_NAME)->select_rows("SELECT * FROM step_types");
		foreach ($steps as $step) {
			$view->name = $step['name'];
			$view->icon = $step['icon_url'];
			$view->html = $step['html'];
			$step_map[$step['name']] = '' . $view;
			$response .= $view;
		}

		echo $response;

  }

} # end of the class