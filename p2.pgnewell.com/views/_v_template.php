<!DOCTYPE html>
<html>
<head>
	<title><?=@$title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
	
	<!-- JS -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
				
	<!-- Controller Specific JS/CSS -->
	<link rel="stylesheet" type="text/css" href="/Users/pgn/Sites/dwa/css/class.css"/>
	<?php echo @$client_files; ?>
	
</head>

<body>
<div class='main-mini-blog'>
  <div>
    <? echo View::instance('v_index_index'); ?>
  </div>
  <div class='side-menu'>
    <? if ($user): ?>
    <ul>
      <li>
      <a href='/users/profile'>See profile</a>
      </li>
      <li>
      <a href='/posts/enter'>Enter Posts</a>
      </li>
      <li>
      <a href='/posts/followed_posts'>View Followed posts</a>
      </li>
      <li>
      <a href='/users/select_follow'>Follow Users</a>
      </li>
      <li>
      <a href='/users/logout'>Logout</a>
      </li>
    </ul>
    <? else: ?>
    <? echo View::instance('v_users_login'); ?>
    <ul>
      <li>
      <a href='/users/signup'>Sign up</a>
      </li>
    </ul>
    <? endif; ?>
  </div>

  <div class='content-block'>
	<?=$content;?> 
  </div>

</div>
</body>
</html>