<div id="panel" class="post_text">

  	<p class="post_title">მომხმარებლების სია</p>

	<br />

	<table id='userlist'>
		<tr>
			<th>სახელი</th>
			<th>გვარი</th>
			<th>Username</th>
			<th>ელ-ფოსტა</th>
			<th colspan='2'></th>
		</tr>
<?php
	foreach ($users as $user)
	{
?>
		<tr>
			<td><?php echo $user['first_name'] ?></td>
			<td><?php echo $user['last_name'] ?></td>
			<td><?php echo $user['username'] ?></td>
			<td><?php echo $user['email'] ?></td>
			<td><a href="<?php echo URL::site('user/edit_profile/' . $user['id']) ?>">შეცვლა</a></td>
			<?php /*<td><a href="<?php echo URL::site('user/permissions/' . $user['id']) ?>">უფლებები</a></td>*/ ?>
		</tr>
<?php
	}
?>
		<tr>
			<td colspan='6' align='center'>
				<a href="<?php echo URL::site('user/new/') ?>" id="showpeopleform">
					ახალი მომხმარებელი
				</a>
			</td>
		</tyr>
	</table>

</div>
