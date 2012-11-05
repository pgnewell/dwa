<?php

class index_controller extends base_controller {

  public function __construct() {
    parent::__construct();
  } 
	
  /*-------------------------------------------------------------------------------------------------
    Access via http://yourapp.com/index/index/
    -------------------------------------------------------------------------------------------------*/
  public function index() {
    Router::redirect( $this->base );
    # Any method that loads a view will commonly start with this
    # First, set the content of the template with a view file

    //$this->template->content = View::instance('v_index_index');
    
    # Now set the <title> tag
    //$this->template->title = "A Micro Blog";
    
    # Render the view
    //echo $this->template;
    
  }

} // end class
