<?php
class step_type_controller extends base_controller {

  public function __construct() {
    parent::__construct();

  } 

	#
	public function retrieve() {
    $steps = DB::instance(DB_NAME)->select_rows("SELECT * FROM step_types");

		$response = json_encode($steps);
		
		echo $response;

  }

} # end of the class