<?php
class posts_controller extends base_controller {
  
  // general query
  const STD_SELECT = '
    SELECT p.post_id "id", p.created "date", CONCAT(u.first_name," ",u.last_name) "author", 
           p.content "message", p.user_id "user" ';
  const STD_FROM = ' FROM posts p JOIN users u ON u.user_id = p.user_id ';

  static $comeback = NULL;

  public function __construct() {
    parent::__construct();
  } 
	
  public function index() {
    $this->display(
		   ', count(l.user_id) "likes"', 
		   'LEFT JOIN likes l on p.post_id = l.post_id' . 
		   ' GROUP BY 1, 2, 3, 4 ' . 
		   'ORDER BY 6 desc, 2 desc'
		   );
  }

  public function display( $select = "", $from = "" ) {
    $this->template->content = View::instance( "v_post_list");
    $query = self::STD_SELECT . $select . self::STD_FROM . $from;
    //echo $query."<br>";
    $posts = DB::instance(DB_NAME)->select_rows($query);
    $this->template->content->posts = $posts;
    //echo Debug::dump( $this->user );
    $this->template->content->user_id = $this->user ? $this->user->user_id : NULL;
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
    $this->comeback = $_SERVER['REQUEST_URI'];
    $query = 
      self::STD_SELECT.self::STD_FROM.'
         JOIN users_users uu ON p.user_id = uu.followed AND uu.user_id = ' . $this->user->user_id;
    //echo $query;
    DB::instance(DB_NAME)->query($query);
    $posts = DB::instance(DB_NAME)->select_rows($query);
    $this->template->content->posts = $posts;
    $this->template->content->user_id = $this->user->user_id;
    echo $this->template;
  }

  public function like ($post_id, $user_id) {
    // I don't really care if there are duplicates and that the only error that can possibly 
    // happen ... Umm ... right? I added this nasty function to DB, by the way.
    DB::ignore_errors( true );
    DB::instance(DB_NAME)->insert('likes',Array('user_id' => $user_id, 'post_id' => $post_id));
    DB::ignore_errors( false );
    Router::redirect( "/" );

  }

  public function my_posts ($user_id = NULL) { }
    

} # end of the class

