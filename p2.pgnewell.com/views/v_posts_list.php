<? if (0): ?>
  <? foreach($posts as $key => $post): ?>
    <div class='post-line'>	
      <div class='post-date'>
	Date: <?=Time::display($post['date'])  ?>
      </div>
      <div class='post-author'>
	By: <?=$post['author'] ?>
      </div>
      <? if ($user && $user->user_id != $post['user']): ?>
      <div class='post-like'>
	<? echo "<a href='/posts/like/".$post['id']."/".$user_id."'>Like</a>" ?></td>
      </div>
      <? endif; ?>
      <? if ($user && $post['user'] == $user_id): ?>
      <div class='post-del'>
	<? echo "<a href='/posts/delete/".$post['id']."'>Delete</a>" ?>
      </div>
      <? endif; ?>
      <div class='post-content'>
	<?=$post['message'] ?>
      </div>
    </div>
  <? endforeach; ?>	
<? else: ?>
<table border="0" style="background-color:#FFFFCC" width="700" cellpadding="0" cellspacing="2">
  <? foreach($posts as $key => $post): ?>
  <tr>	
    <td width='30%'>Date: <?=Time::display($post['date'])  ?></td>
    <td width='50%'>By: <?=$post['author'] ?></td>
    <td width='20%'>
      <? if (array_key_exists('action', $post)): ?>
        <?=$post['action'] ?>
      <? endif; ?>
    </td>
  </tr>
  <tr>	
    <td colspan='4'><?=$post['message'] ?></td>
  </tr>
  <? endforeach ; ?>	
</table>
<? endif; ?>


