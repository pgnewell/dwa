<?php
class users_controller extends base_controller {

  public function __construct() {
    parent::__construct();
  } 
  
  # seems appropriate that this should be the profile
  public function index() {
    Router::redirect("/posts/my_posts");
  }

  # this redirects to post since that is where all the queries are done on posts
  public function profile($user_id = NULL) {
    $this->base = "/posts/my_posts";
    Router::redirect( "/posts/my_posts" );
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
    echo "stored row in db";
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

  # just so I don't lose this
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

  # use an outer join and build action links from that
  # probably should follow the posts method for this
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

  # sure hope this works
  public function logout() {
    $this->userObj->logout($this->user->email);
    Router::redirect("/");
  }

  # not used
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

  # adds to user_user table
  public function follow($user_id_followed = NULL) {
    DB::instance(DB_NAME)->insert("users_users", 
				  Array('created' => Time::now(),
					'user_id' => $this->user->user_id,
				        'followed' => $user_id_followed)
				  );
    Router::redirect("/users/select_follow");
  }

  # removes from  user_user table
  public function unfollow($user_id_followed = NULL) {    
    $where_condition = "WHERE followed =".$user_id_followed." 
	       AND user_id= ".$this->user->id;

    DB::instance(DB_NAME)->delete("users_users", $where_condition);
    Router::redirect('/posts/users');
  }

  # not sure what I was thinking
  public function logged_in() {
  }

} # end of the class

