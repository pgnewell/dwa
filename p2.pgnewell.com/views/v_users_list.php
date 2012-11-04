<? foreach($users as $key => $user): ?>
    <?=$user->user ?> 
    <? echo "<a href='/users/".$user->action."/".$user->id."'>".$user->action."</a>"; ?> 
    <br>
<? endforeach; ?>	
