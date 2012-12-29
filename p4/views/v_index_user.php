<? if(!$user): ?>
<div>
  <ul>
		<li>
			Login:
			<form method='POST' action='/users/p_login'>
			  Email:<br>
			  <input type='text' name='email'><br>
			  Password::<br>
			  <input type='password' name='password'><br>
			  <input type='submit' value='Login'>
			</form>
		</li>
    <li>
      <a href='#' id='user-signup'>Sign up</a>
    </li>
  </ul>
	<p id='user-login-message'><?=$message?></p>

</div>

<? else: ?>
<div>
  <ul>
    <li>
      <a href='#' id='users-profile-button'>See profile</a>
    </li>
    <li>
      <a href='#' id='recipe-build'>Enter Recipes</a>
    </li>
    <li>
      <a href='/users/logout'>Logout</a>
    </li>
  </ul>
</div>

<? endif; ?>
