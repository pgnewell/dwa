<? if(!$user): ?>
<div>
  <ul>
		<li>
			Login:
			<form method='POST' action='/users/p_login'>
			  Email:<br>
			  <input type='text' name='email'><br>
			  Password:<br>
			  <input type='password' name='password'><br>
			  <input type='submit' value='Login'>
			</form>
		</li>
    <li>
      <a href='#' id='user-signup'>Sign up</a>
    </li>
  </ul>

</div>

<? else: ?>
<div>
  <ul>
    <li>
      <a href='/users/profile'>See profile</a>
    </li>
    <li>
      <a href='/recipes/enter'>Enter Posts</a>
    </li>
    <li>
      <a href='/recipes/search'>Search</a>
    </li>
    <li>
      <a href='/users/select_follow'>Follow Users</a>
    </li>
    <li>
      <a href='/users/logout'>Logout</a>
    </li>
  </ul>
</div>

<? endif; ?>
