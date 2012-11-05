<h1>A Micro-Blog</h1>
<? if(!$user): ?>
  You are not logged in<br>
<? else: ?>
  You are <?=$user->first_name." ".$user->last_name?><br>
<? endif; ?>
