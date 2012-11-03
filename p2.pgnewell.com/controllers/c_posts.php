<?php
class posts_controller extends base_controller {
  
  // general query
  const STD_QUERY = 'select p.created "date", concat(u.first_name," ",u.last_name) "author", p.content "message" 
    from posts p join users u on u.id = p.user_id';

  public function __construct() {
    parent::__construct();
    echo "users_controller construct called<br><br>";
  } 
	
  public function index() {
    $this->template->content = View::instance( "v_post_list");

    $posts = DB::instance(DB_NAME)->select_rows(self::STD_QUERY);
    $this->template->content->posts = $posts;

    echo $this->template;
  }

  public function enter() {
    $this->template->content = View::instance( "v_post_enter");
    echo $this->template;
  }

  public function p_enter() {
    $_POST['date'] = Time::now();
    DB::instance(DB_NAME)->insert($_POST);
  }

  public function list_all($query = self::STD_QUERY) { 

  }

  public function list_followed($user_id = NULL) { 
    $this->template->content = View::instance( "v_post_list");
    $query = 
      'SELECT p.created "date", concat(u.first_name, " ", u.last_name) "author",
                 p.message "message"
         FROM posts p 
         JOIN users u ON p.user_id = u.id
         JOIN users_users uu ON uu.user_id = ' . $user_id;
    DB::instance(DB_NAME)->query($query);
    $posts = DB::instance(DB_NAME)->select_rows($q);
    $this->template->content->posts = $posts;
    echo "here we are";
    echo $this->template;
  }

  
		
} # end of the class

