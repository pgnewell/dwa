<?php

class base_controller {
	
  public $user;
  public $userObj;
  public $template;
  public $email_template;

  #to display - not sure how right now
  public $content_title;

  # this is where the site should redirect back when it gets lost
  public static $base = "/posts";

  private $menu = "v_index_guest";

  /*-------------------------------------------------------------------------------------------------

    -------------------------------------------------------------------------------------------------*/
  public function __construct() {

    # Instantiate User class
    $this->userObj = new User();
			
    # Authenticate / load user
    $this->user = $this->userObj->authenticate();			
							
    # Set up templates
    $this->template 	  = View::instance('_v_template');
    $this->email_template = View::instance('_v_email');			
								
    # So we can use $user in views			
    $this->template->set_global('user', $this->user);

    if ($this->user)
      $this->menu = "v_index_user";
    else
      $this->menu = "v_index_quest";
			
  }

} # eoc
