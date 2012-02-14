    <?php $url = ($status == 'new') ? 'groups/create' : 'groups/update/' . $group['id'];  ?>
	<form action="<?php echo URL::site($url) ?>" method="post">

		<?php empty($message) OR print $message; ?>

		<div class="block group">
			<div class="left_labels">
				<label>ჯგუფი</label>
			</div>

			<div class="right_fields">
			    <label>
				<input type="text" class="text_field widefield" value="<?php empty($group['name']) OR print $group['name']; ?>" name="group_name" />
			    </label>
			</div>
		</div>

		<div class="block group">
			<div class="left_labels">
				<label>აღწერა</label>
			</div>

			<div class="right_fields">
			    <label>
				<textarea name="group_description" class="text_field widefield" style="color: #202020;"><?php 
				    empty($group['description']) OR print $group['description'];
				 ?></textarea>
			    </label>
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

			    <div style="line-height: 22px; color: #980000;">(იგულისხმება ჯგუფების, ტრანზაქციებისა და დავალიანებების გვერდების ნახვა, ჯგუფების დამატება და შეცვლა, მომხმარებლისთვის ჯგუფისა და გადასახადის რაოდენობის შეცვლა, მომხმარებლის დაბლოკვა)</div>
			</div>
		</div>

		<div class="block last">
			<input type="submit" value="შენახვა" class="text_field" id="new_post_submit" />
		</div>

	</form>
