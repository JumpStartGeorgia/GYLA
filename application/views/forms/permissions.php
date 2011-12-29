	<form action="<?php echo URL::site('user/update_permissions/'.$user['id']) ?>" method="post">

		<div class="block group">
			<div class="left_labels">
				<label><?php echo $user['first_name']." ".$user['last_name'] ?></label>
			</div>

			<div class="right_fields">
				<label><?php echo $user['username'] ?></label>
			</div>
		</div>


		<div class="block group">
			<div class="left_labels">
				<label>უფლებები: </label>
			</div>

			<div class="right_fields">
<?php
		foreach ($permissions AS $resource => $privilege)
		{
			echo '<fieldset style="display: block; margin: 1em 0; clear: both">';
			echo '<legend style="font-weight: bold">' . $geo_perms[$resource] . '</legend>';
			foreach ($privilege AS $priv):
				$value = base64_encode(serialize(array(
					'resource' => $resource,
					'privilege' => $priv
				)));
				$checked = (array_key_exists($resource, $current_permissions)
						AND in_array($priv, $current_permissions[$resource]));
?>
				<label style="cursor: pointer">
					<input type="checkbox" name="permissions[]"
						<?php $checked AND print ' checked="checked"' ?> value="<?php echo $value ?>" />
					<?php echo $geo_perms[$priv] ?> 
				</label>
				<br />
<?php
			endforeach;
			echo '</fieldset>';
		}
?>
			</div>
		</div>


		<div class="block last">
			<input type="submit" value="შენახვა" class="text_field" id="new_post_submit" />
		</div>

	</form>
