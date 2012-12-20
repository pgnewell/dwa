<? if ($user): ?>
  Profile for user <h4> <?=$user->first_name?> <?=$user->last_name?></h4> <br>
  Email:   <?=$user->email?><br>
<? else: ?>
  <h2>You are not a user!</h2>
<? endif; ?>