<?php
class users_controller extends base_controller {

	public function __construct() {
		parent::__construct();
		echo "users_controller construct called<br><br>";
	} 
	
	public function index() {
		echo "Welcome to the users's department";
	}
	
	public function signup() {
		echo "This is the signup page";
		$this->template->content = View::instance( 'v_users_signup' );
		echo $this->template;
	}
	
	public function p_signup() {
		$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password'])	;
		$_POST['token'] = sha1(
			TOKEN_SALT.
			$_POST['email'].
			Utils::generate_random_string()
		);
		$_POST['created'] = Time::now();
		$_POST['modified'] = Time::now();
		DB::instance(DB_NAME)->insert('users', $_POST);
		print_r( $_POST );
		echo "stored row in db";
	}
	
	public function login() {
		echo "This is the login page";
		
		$this->template->content = View::instance( 'v_users_login' );
		echo $this->template;
	}
	
	public function p_login() {
		print_r( $_POST );
		$_POST['password'] = sha1(PASSWORD_SALT . $_POST['password']);
		$sql = 
			"select token from users where email = '" . 
				$_POST['email'] . "' and password = '" . $_POST['password'] . "'";
		$token = DB::instance(DB_NAME)->select_field($sql);
		
		if (!$token) {
			Router::redirect('users/login');
		} else {
			setcookie("token", $token, strtotime('+2 weeks'), '/' );
			Router::redirect('/signed_in');
		}
	}
	
	public function logout() {
		echo "This is the logout page";
	}
	
	public function profile($user_name = NULL) {
		
		if($user_name == NULL) {
			echo "No user specified";
		}
		else {
			echo "This is the profile for ".$user_name;
		}
	}
		
} # end of the class

