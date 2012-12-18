<?php
class recipe_controller extends base_controller {

  public function __construct() {
    parent::__construct();
  } 

	public function save_step( $html ) {
		
	}

	public static function format_recipe( $sql ) {
		$response = '';
		$rows = DB::instance(DB_NAME)->select_rows( $sql );
		foreach ($rows as $row) {
			$view = View::instance( 'v_recipe_display' );
			$view->name = $row['name'];
			$view->description = $row['description'];
			$response .= $view;
		}
		echo $response;
	}
	
	public function retrieve_all() {
		$sql = "SELECT * FROM recipes";
		self::format_recipe( $sql );
	}

	public function retrieve_user( $user ) {
		$sql = "SELECT * FROM recipes ORDER BY ";
		self::format_recipe( $sql );
	}
	
	public function retrieve_recipe( $id ) {
		$sql = "SELECT * FROM recipes WHERE id = " . $id;
		$row = DB::instance(DB_NAME)->select_row( $sql );
		$sql = "SELECT * FROM recipe_steps WHERE recipe = " . $id;
		$steps = DB::instance(DB_NAME)->select_rows( $sql );
		$recipe = $row;
		$recipe->steps = $steps;
		echo encode_json( $recipe );
		
	}

} # end of the class
