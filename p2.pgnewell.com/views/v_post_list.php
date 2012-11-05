<table border="1" style="background-color:#FFFFCC" width="100%" cellpadding="0" cellspacing="2">
	<tr>
	  <th>Date</th>
	  <th>Author</th>
	  <th>Message</th>
	</tr>
	<? foreach($posts as $key => $post): ?>
	  <tr>	
	    <td><?=Time::display($post['date'])  ?></td>
	    <td><?=$post['author'] ?></td>
	    <td><?=$post['message'] ?></td>
	    <? if ($user_id && $user_id != $post['user']): ?>
	      <td><? echo "<a href='/posts/like/".$post['id']."/".$user_id."'>Like</a>" ?></td>
	    <? endif; ?>
	    <? if ($user_id && $post['user'] == $user_id): ?>
	      <td><? echo "<a href='/posts/delete/".$post['id']."'>Delete</a>" ?></td>
	    <? endif; ?>
	  </tr>

	<? endforeach; ?>	
</table>


