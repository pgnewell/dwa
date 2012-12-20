<?php
class recipe_controller extends base_controller {

  public function __construct() {
    parent::__construct();
  }

	public function load_builder () {
		$view = View::instance( 'v_build_recipe' );
		echo $view;
	}

	// save recipe and the associated steps and dependencies
	public function save() {
		$recipe = json_decode( $_POST['recipe'] );
		$dependencies = $recipe->dependencies;
		//print_r( $recipe );
		//echo $recipe->name . " has " . count($steps) . " steps!";
		
		// insert the recipe and retain the id
		$r['name'] = $recipe->name;
		$r['description'] = $recipe->description;
		$r['user'] = $this->user->id;
		//$r['picture_url'] = $_POST['picture_url'];
		$id = DB::instance(DB_NAME)->insert('recipes', $r);
		//echo "recipe " . $recipe->name . " now has id: " . $id;
		//$response = '';
		$seq_map = [];
		$seq = 1;

		// inserting the corresponding steps in the steps file
		foreach ($recipe->steps as $step_id => $step) {
			$t = DB::instance(DB_NAME)->sanitize( $step->type );
			$type_id = DB::instance(DB_NAME)->select_field( 
				"SELECT id FROM step_types WHERE name = '" . $t . "'");
			//$response .= $step->type . " is " . $type_id . "\n";
			$seq_map[$step_id] = $seq;
			$s['seq'] = $seq++;
			$s['recipe'] = $id;
			$s['type'] = $t;
			$s['instructions'] = $step->instructions;
			DB::instance(DB_NAME)->insert('steps', $s);
		}

		// insert the dependencies using the map to remember what
		// the step is called in the table
		foreach ($recipe->dependencies as $dependant => $depended_upon) {
			$d['recipe'] = $id;
			$d['dependant'] = $seq_map[$dependant];
			$d['depended_upon'] = $seq_map[$depended_upon];
			DB::instance(DB_NAME)->insert('dependencies', $d);
		}
		echo $id;

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
		echo json_encode( $recipe );
		
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
