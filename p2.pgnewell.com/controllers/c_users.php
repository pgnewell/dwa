<?php
class users_controller extends base_controller {

  public function __construct() {
    parent::__construct();
  } 
  
  public function index() {
    $this->template->content = View::instance( "v_users_index" );
    $this->template->content->name = $this->user->first_name . " " . 
      $this->user->last_name;
    echo $this->template;
  }
  
  public function signup() {
    $this->template->content = View::instance( 'v_users_signup' );
    echo $this->template;
  }
  
  public function p_signup() {
    print_r( $_POST );
    $_POST['password'] = Users::hash_password($_POST['password'])	;
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
    echo "stored row in db";
  }
  
  public function login() {    
    $this->template->content = View::instance( 'v_users_login' );
    echo $this->template;
  }
  
  public function p_login() {
    $token = $this->userObj->login( $_POST['email'], $_POST['password'] );
    
    if (!$token)
      Router::redirect('/users/login');
    else
       Router::redirect('/users');
  }

  private function save_stuff () {
    $_POST['password'] = sha1(PASSWORD_SALT . $_POST['password']);
    $token = DB::instance(DB_NAME)->sanitize($_POST);
    $sql = 
      "select token from users where email = '" . $_POST['email'] . 
      "' and password = '" . $_POST['password'] . "'";
    $token = DB::instance(DB_NAME)->select_field($sql);

    if ($token)
      setcookie("token", $token, strtotime('+2 weeks'), '/' );
  }

  public function select_follow( $user_id = NULL ) {
    if ($user_id == NULL)
      $user_id = $this->user->user_id;
    $query = "
      SELECT u.user_id \"id\", CONCAT( first_name, ' ', last_name ) \"user\", 
         CASE WHEN ISNULL( uu.user_id ) 
           THEN 'follow'
           ELSE 'unfollow'
         END \"action\"
      FROM users u
      LEFT JOIN users_users uu ON u.user_id = uu.followed
           AND uu.user_id = " . $user_id . "
      WHERE u.user_id != " . $user_id;

    //echo $query . "<br>";
    $this->template->content = View::instance( 'v_users_list' );
    $users = DB::instance(DB_NAME)->select_rows( $query, 'object' );
    $this->template->content->users = $users;
    echo $this->template;
    //foreach ($users as $key => $user ) {
    //  echo Debug::dump( $user );
    //}
  }

  public function logout_test() {
    echo Debug::dump( $this->user );
  }

  public function logout() {
    $this->userObj->logout();
    Router::redirect("/");
  }
  
  public function save_some_stuff() {
	# Generate and save a new token for next login
	$new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());
	
	# Create the data array we'll use with the update method
	# In this case, we're only updating one field, so our array only has one entry
	$data = Array("token" => $new_token);
	
	# Do the update
	DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");
	
	# Delete their token cookie - effectively logging them out
	setcookie("token", "", strtotime('-1 year'), '/');
	
	# Send them back to the main landing page
  }
  public function profile($user_id = NULL) {
    $this->template->content = View::instance( 'v_users_profile' );
 
    $user = $this->user;
    
    if($user_id != NULL) {
      # Load user from DB
      $q = "SELECT *
	    FROM users
	    WHERE user_id = ".$user_id ;	
      
      $user = DB::instance(DB_NAME)->select_row($q, "object");
    }

    $this->template->content->user = $user;

    echo $this->template;

  }

  public function follow($user_id_followed = NULL) {
    DB::instance(DB_NAME)->insert("users_users", 
				  Array('created' => Time::now(),
					'user_id' => $this->user->user_id,
				        'followed' => $user_id_followed)
				  );
    Router::redirect("/users/select_follow");
  }

  public function unfollow($user_id_followed = NULL) {    
    $where_condition = "WHERE followed =".$user_id_followed." 
	       AND user_id= ".$this->user->id;

    DB::instance(DB_NAME)->delete("users_users", $where_condition);
    Router::redirect('/posts/users');
  }
  
  public function logged_in() {
  }

} # end of the class

