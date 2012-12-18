<?php
class step_type_controller extends base_controller {

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
			$view->icon_url = $step['icon_url'];
			$view->description = $step['description'];
			$response .= $view;
		//	"<div class='icon-block icon-click'><img src='../images/" . $step['icon_url'] . "' alt='" . $step['name'] . 
		//	"' title='" . $step['name'] . "'/>" . 
		//		"<div class='caption'>" . $step['name'] . "</div>" . 
		//		"<div class='step-instructions hide'>" . 
		//		"</div>" . 
		//		$step['html'] . 
		//		"<div class='step-actions hide'></div>" . 
		//	"</div>";
		}
		
		echo $response;

  }

} # end of the class