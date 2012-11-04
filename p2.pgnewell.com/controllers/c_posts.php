<?php
class posts_controller extends base_controller {
  
  // general query
  const STD_SELECT = '
    SELECT p.post_id "id", p.created "date", CONCAT(u.first_name," ",u.last_name) "author", 
           p.content "message" ';
  const STD_FROM = ' FROM posts p JOIN users u ON u.user_id = p.user_id ';

  public function __construct() {
    parent::__construct();
  } 
	
  public function index() {
    $this->template->content = View::instance( "v_post_list");
    $query = 
           self::STD_SELECT.
	  ', count(l.user_id) "likes"'.
           self::STD_FROM.
	  'LEFT JOIN likes l on p.post_id = l.post_id
           GROUP BY 1, 2, 3, 4
           ORDER BY 5 desc, 2 desc';
    echo $query."<br>";
    $posts = DB::instance(DB_NAME)->select_rows($query);
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

  public function list_followed($user_id = NULL) { 
    $this->template->content = View::instance( "v_post_list");
    $query = 
      'SELECT p.post_id "id", p.created "date", CONCAT(u.first_name, " ", u.last_name) "author",
                 p.message "message"
         FROM posts p 
         JOIN users u ON p.user_id = u.user_id
         JOIN users_users uu ON uu.user_id = ' . $user_id;
    DB::instance(DB_NAME)->query($query);
    $posts = DB::instance(DB_NAME)->select_rows($q);
    $this->template->content->posts = $posts;
    echo "here we are";
    echo $this->template;
  }

  public function like ($user_id, $post_id) {
    DB::instance(DB_NAME)->insert(Array('likes','user_id' => $user_id, 'post_id' => $post_id));
  }

} # end of the class

