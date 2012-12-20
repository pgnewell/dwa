<?php
class users_controller extends base_controller {

  public function __construct() {
    parent::__construct();
  } 
  
  # seems appropriate that this should be the profile
  public function index() {
    Router::redirect("/");
  }

  # this redirects to post since that is where all the queries are done on posts
  public function profile($user_id = NULL) {
		$view = View::instance( 'v_users_profile' );
		$view->user = $this->user;
		echo $view;
  }

  public function signup() {
    $this->template->content = View::instance( 'v_users_signup' );
    echo $this->template;
  }
  
  public function p_signup() {
    $_POST['password'] = User::hash_password($_POST['password'])	;
    $_POST['token'] = sha1(
			   TOKEN_SALT.
			   $_POST['email'].
			   Utils::generate_random_string()
			   );
    $_POST['created'] = Time::now();
    $_POST['modified'] = Time::now();
    DB::instance(DB_NAME)->insert('users', $_POST);
    // print_r( $_POST );
    Router::redirect("/");
  }
  
  // this is not really happening.
  public function p_change_profile() {
    print_r( $_POST );
    $_POST['token'] = sha1(
			   TOKEN_SALT.
			   $_POST['email'].
			   Utils::generate_random_string()
			   );
    $_POST['modified'] = Time::now();
    DB::instance(DB_NAME)->update("users", $data, "WHERE id = '".$this->user->user_id."'");
    print_r( $_POST );
    // echo "stored row in db";
  }

  # not used
  public function login() {    
    $this->template->content = View::instance( 'v_users_login' );
    echo $this->template;
  }

  # called from v_users_login
  public function p_login() {
    $token = $this->userObj->login( $_POST['email'], $_POST['password'] );
    Router::redirect('/');
  }

  public function logout_test() {
    echo Debug::dump( $this->user );
  }

  # sure hope this works
  public function logout() {
    $this->userObj->logout($this->user->email);
    Router::redirect("/");
  }


} # end of the class

