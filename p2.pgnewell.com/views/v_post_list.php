<table border="1" bordercolor="#FFCC00" style="background-color:#FFFFCC" width="100%" cellpadding="0" cellspacing="2">
	<tr>
		<th>Date</th>
		<th>Author</th>
		<th>Message</th>
	</tr>
	<? foreach($posts as $key => $post): ?>
		<tr>	
			<td><?=$post['date']  ?></td>
			<td><?=$post['author'] ?></td>
			<td><?=$post['message'] ?></td>
		</tr>

	<? endforeach; ?>	
</table>


