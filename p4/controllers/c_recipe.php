<?php
class recipe_controller extends base_controller {

  public function __construct() {
    parent::__construct();
  }

	public function load_builder () {
		$view = View::instance( 'v_build_recipe' );
		echo $view;
	}

	public function save_steps( $steps ) {
		
	}
	
	public function save() {
		$recipe = decode_json( $_POST['recipe'] );
		$steps = $recipe['steps'];
		echo $recipe['name'] . " has " . count($steps) . " steps!";

		//$recipe['name'] = $_POST['name'];
		//$recipe['description'] = $_POST['description'];
		//$recipe['user'] = $this->user->user_id;
		//$recipe['picture_url'] = $_POST['picture_url'];
		//$id = DB::instance(DB_NAME)->insert('recipes', $recipe);
		//$steps = $recipe->steps;

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
	
	public function retrieve( $recipe_id ) {
		$response = '';
		$view = View::instance('v_recipe_step');
    $recipe = DB::instance(DB_NAME)->select_row("SELECT * FROM recipes WHERE id = " . id );
		// deal with error
		$steps = DB::instance(DB_NAME)->select_rows("SELECT * FROM steps WHERE id = " . id );
		foreach ($steps as $step) {
			$view->name = $step['name'];
			$view->icon = $step['icon_url'];
			$view->html = $step['html'];
			$response .= $view;
		}

		echo $response;

  }
	
	

} # end of the class
