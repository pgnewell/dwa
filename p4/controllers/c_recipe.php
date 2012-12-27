<?php
class recipe_controller extends base_controller {

  public function __construct() {
    parent::__construct();
  }

	public function load_builder () {
		$view = View::instance( 'v_build_recipe' );
		$view->name = '';
		$view->description = '';
		echo $view;
	}

	// save recipe and the associated steps and dependencies
	public function save() {
		$response = '';
		$recipe = json_decode($_POST['recipe'] );
		if (trim($recipe->name) == '') {
			header("HTTP/1.1 500 Recipe needs a name");
			die("Can't save recipe without a name");
		} else {
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
			$seq_map = array();
			$seq = 1;

			// inserting the corresponding steps in the steps file
			foreach ($recipe->steps as $step_id => $step) {
				$type_id = DB::instance(DB_NAME)->select_field( 
					"SELECT id FROM step_types WHERE name = '" . $step->type . "'");
				//$response .= $step->type . " is " . $type_id . "\n";
				$seq_map[$step_id] = $seq;
				$s['seq'] = $seq++;
				$s['recipe'] = $id;
				$s['type'] = $type_id;
				$s['instructions'] = $step->instructions;
				DB::instance(DB_NAME)->insert('steps', $s);
			}

			// insert the dependencies using the map to remember what
			// the step is called in the table
			foreach ($recipe->dependencies as $dependant => $depended_upon) {
				$d['recipe'] = $id;
				$d['dependant'] = $seq_map[$dependant];
				$d['dependent'] = $seq_map[$depended_upon];
				DB::instance(DB_NAME)->insert('dependent_steps', $d);
			}
			$response = $id;
			if (property_exists($recipe, 'id') && $recipe->id > 0) {
				//self::delete( $old_recipe );
			}
		}
		echo $response;

	}

	public static function format_recipe( $sql ) {
		$response = '';
		$rows = DB::instance(DB_NAME)->select_rows( $sql );
		foreach ($rows as $row) {
			$view = View::instance( 'v_recipe_display' );
			$view->name = $row['name'];
			$view->description = $row['description'];
			$view->recipe_id = $row['id'];
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
		$recipe = $row;

		// get related steps
		$sql = "SELECT s.*,t.name AS type_name FROM steps s JOIN step_types t ON s.type = t.id WHERE recipe = " . $id;
		$steps = DB::instance(DB_NAME)->select_rows( $sql );
		$recipe['steps'] = $steps;

		// get dependencies
		$sql = "SELECT * FROM dependent_steps WHERE recipe = " . $id;
		$dependencies = DB::instance(DB_NAME)->select_rows( $sql );
		$recipe['dependencies'] = $dependencies;

		// return the object as a JSON string
		echo json_encode( $recipe, JSON_PRETTY_PRINT );

	}
	
	public function load_recipe( $recipe_id ) {
		$view = View::instance( 'v_build_recipe' );
		$step_view = View::instance('v_recipe_step');
		$step_id = 0;
		$response = '';
    $recipe = DB::instance(DB_NAME)->select_row("SELECT * FROM recipes WHERE id = " . $recipe_id );
		$view->name = $recipe['name'];
		$view->description = $recipe['description'];
		// deal with error
		$steps = DB::instance(DB_NAME)->select_rows(
			"SELECT s.*,t.* FROM steps s JOIN step_types t ON s.type = t.id WHERE recipe = " . $recipe_id );
		foreach ($steps as $step) {
			print_r( $step );
			$view->name = $step_type['name'];
			$view->icon = $step_type['icon_url'];
			$view->html = $step_type['html'];
			$response .= $step_view;
		}

		echo $response;

  }

	public function exec_load( $recipe_id) {
		self::retrieve( $recipe_id );
	}
	
	public function delete( $recipe_id ) {
		if (is_null($recipe_id)) {
			echo "No id supplied for delete recipe";
		}
		DB::instance(DB_NAME)->delete('recipes','WHERE id = '. $recipe_id);
		DB::instance(DB_NAME)->delete('steps','WHERE recipe = '. $recipe_id);
		DB::instance(DB_NAME)->delete('dependent_steps','WHERE recipe = '. $recipe_id);
		echo $recipe_id;
	}

} # end of the class
