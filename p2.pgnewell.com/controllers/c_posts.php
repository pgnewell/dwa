<?php
class posts_controller extends base_controller {
  
  // general query
  const STD_SELECT = '
    SELECT p.post_id "id", p.created "date", CONCAT(u.first_name," ",u.last_name) "author", 
           p.content "message", p.user_id "user" ';
  const STD_FROM = ' FROM posts p JOIN users u ON u.user_id = p.user_id ';

  public function __construct() {
    parent::__construct();
  } 

  # this function takes the query and uses v_post_list to display it
  # it needs to set up $posts and $users to do that
  public function _display( $query ) {
    $this->template->content = View::instance( "v_posts_list");
    $posts = DB::instance(DB_NAME)->select_rows($query);
    $this->template->content->posts = $posts;
    // ->user is potentially NULL
    $this->template->content->user = $this->user;
    echo $this->template;
  }

  # this is the landing page show all posts with the most liked at the top
  public function index() {
    self::$base = "/posts";
    $this->_display( $this->_all_posts_by_liked() );
  }

  # this just shows the posts the user us following. 
  # here the user is presented with the option to like or unlike (remove the like, not dislike)
  public function followed_posts() {
    self::$base = "/posts/followed_posts";
    $this->_display( $this->_followed_posts_by_date() );
  }

  # this is really the user profile page. since we want to display posts and the 
  # post selects are all here it seems easier.
  public function my_posts() {
    self::$base = "/posts/my_posts";
    // this got shifted from users so the conventions are a bit off
    $this->template->content = View::instance( "v_users_profile" );
    if($this->user) {
      # Load user from DB
      $q = "SELECT *
	    FROM users
	    WHERE user_id = ".$this->user->user_id ;
      $user = DB::instance(DB_NAME)->select_row($q, "object");
      $this->template->content->user = $user;

      $query = $this->_my_posts_by_date();
      // echo $query;
      $posts = DB::instance( DB_NAME )->select_rows($query);
      $this->template->content->posts = $posts;
    }
    echo $this->template;
  }
  
  # for all posts no actions - no likes or deletes
  #
  public function _all_posts_by_liked () {
    $q = self::STD_SELECT . ', count(l.user_id) as likes ' . 
      self::STD_FROM . 
      ' LEFT JOIN likes l on p.post_id = l.post_id ' . 
      // ' LEFT JOIN likes ll on p.post_id = ll.post_id AND u.user_id = ' .$this->user->user_id . 
      ' GROUP BY id, date, author, message' . 
      ' ORDER BY likes desc, date desc';
    return $q;
  }

  # for followed posts allow like
  #
  public function _followed_posts_by_date ($user_id = NULL) {
    if ($user_id == NULL)
      $user_id = $this->user->user_id;

    // create the links for like and unlike
    $likes = "CONCAT( '<a href=''/posts/like/', p.post_id, '/', uu.user_id, '''>Like<a>')";
    $unlikes = "CONCAT( '<a href=''/posts/unlike/', p.post_id, '/', uu.user_id, '''>Unlike<a>')";

    // the like links will use an outer join so l.post_id will be null where no like is done
    $query = 
      self::STD_SELECT . ',
         CASE WHEN l.post_id IS NULL
         THEN ' . $likes . '
         ELSE ' . $unlikes . '
         END AS action ' .
      self::STD_FROM. '
         JOIN users_users uu ON p.user_id = uu.followed AND uu.user_id = ' . $this->user->user_id . '
         LEFT JOIN likes l ON p.post_id = l.post_id AND l.user_id = ' . $this->user->user_id;

    return $query;
  }

  # my posts allows deletes
  # this is done with links as with "likes"
  public function _my_posts_by_date ($user_id = NULL) {
    if ($user_id == NULL)
      $user_id = $this->user->user_id;

    // create link for likes
    $action = "CONCAT( '<a href=''/posts/delete/', p.post_id, '''>Delete<a>')";

    $query = 
      self::STD_SELECT.", ".$action." AS action".self::STD_FROM.'
         WHERE p.user_id = ' . $this->user->user_id;
    return $query;
  }
      
  # bring up the little form to add a new link
  public function enter() {
    $this->template->content = View::instance( "v_posts_enter");
    echo $this->template;
  }

  # executed by the v_posts_enter form
  public function p_enter() {
    $_POST['created'] = Time::now();
    $_POST['user_id'] = $this->user->user_id;
    DB::instance(DB_NAME)->insert('posts', $_POST);
    Router::redirect('/');
  }

  # no longer used
  public function list_followed($user_id = NULL) { 
    $this->template->content = View::instance( "v_posts_list");
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

  # this does some funny stuff with errors, 
  # it isn't strictly necessary after I added the "Unlike" stuff
  public function like ($post_id, $user_id) {
    // I don't really care if this fails on duplicates and that's the only error that can possibly 
    // happen ... Umm ... right? I added this nasty function to DB, by the way.
    //DB::ignore_errors( true );
    DB::instance(DB_NAME)->insert('likes',Array('user_id' => $user_id, 'post_id' => $post_id));
    //DB::ignore_errors( false );
    Router::redirect( "/posts/followed_posts" );
  }

  # unlike just deletes the like
  public function unlike ($post_id, $user_id) {
    DB::instance(DB_NAME)->delete('likes','WHERE user_id = '. $user_id . ' AND post_id = '. $post_id);
    Router::redirect( "/posts/followed_posts" );
  }

  #simple - delete any likes and the post
  public function delete ($post_id) {
    DB::instance(DB_NAME)->delete('likes','WHERE post_id = '. $post_id);
    DB::instance(DB_NAME)->delete('posts','WHERE post_id = '. $post_id);
    Router::redirect( "/posts/my_posts" );
  }

  # not used
  public function test () {
    $this->template->content = View::instance( "v_posts_test" );
    echo $this->template;
  }

} # end of the class

