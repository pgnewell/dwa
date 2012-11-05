<h1>A Micro-Blog</h1>
<? if(!$user): ?>
  <? echo View::instance('v_users_login'); ?>
  <a href='/users/signup'>Signup</a><br>
  <a href='/posts'>Posts</a>
<? else: ?>
  You are <?=$name?><br>
  <ul>
    <li>
      <a href='/users/profile'>See profile</a>
    </li>
    <li>
      <a href='/posts/enter'>Enter Posts</a>
    </li>
    <li>
      <a href='/posts/list_followed'>View Followed posts</a>
    </li>
    <li>
      <a href='/users/select_follow'>Follow Users</a>
    </li>
    <li>
      <a href='/users/logout'>Logout</a>
    </li>
  </ul>
<? endif; ?>
