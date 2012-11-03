<? if(!$user): ?>
  <!-- 
  <a href='/users/login'>Login</a> | 
    -->
  <? echo View::instance('v_users_login'); ?>
  <a href='/users/signup'>Signup</a><br>
  <a href='/posts'>Posts</a>
<? else: ?>
  Welcome back <?=$user->first_name?><br>
  <a href='/users/logout'>Logout</a>

	  
<? endif; ?>
