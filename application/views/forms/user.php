	<form action="<?php echo URL::site('user/create') ?>" method="post" id="user_form">

		<div class="block group">
			<div class="left_labels">
				<label for="new_user_title">სახელი: </label>
			</div>

			<div class="right_fields">
				<input type="text" name="user_firstname" class="text_field widefield" id="new_user_title"
					<?php empty($_POST['user_firstname']) OR print("value='" . $_POST['user_firstname'] . "'"); ?> />
			</div>
		</div>

		<div class="block group">
			<div class="left_labels">
				<label for="new_user_lastname">გვარი: </label>
			</div>

			<div class="right_fields">
				<input type="text" name="user_lastname" class="text_field widefield" id="new_user_lastname"
					<?php empty($_POST['user_lastname']) OR print("value='" . $_POST['user_lastname'] . "'"); ?> />
			</div>
		</div>


		<div class="block group">
			<div class="left_labels">
				<label for="new_user_username">მომხმარებლის სახელი: <span class='required'>*</span></label>
			</div>

			<div class="right_fields">
				<input type="text" name="user_username" class="text_field widefield" id="new_user_username"
					<?php empty($_POST['user_username']) OR print("value='" . $_POST['user_username'] . "'"); ?> />
			</div>
		</div>

		<div class="block group">
			<div class="left_labels">
				<label for="new_user_password">პაროლი: <span class='required'>*</span></label>
			</div>

			<div class="right_fields">
				<input type="password" name="user_password" class="text_field widefield" id="new_user_password" />
			</div>
		</div>

		<div class="block group">
			<div class="left_labels">
				<label for="new_user_confirm">გაიმეორეთ პაროლი: <span class='required'>*</span></label>
			</div>

			<div class="right_fields">
				<input type="password" name="user_confirm" class="text_field widefield" id="new_user_confirm" />
			</div>
		</div>

		<div class="block group">
			<div class="left_labels">
				<label for="new_user_email">ელფოსტა: <span class='required'>*</span></label>
			</div>

			<div class="right_fields">
				<input type="text" name="user_email" class="text_field widefield" id="new_user_email"
					<?php empty($_POST['user_email']) OR print("value='" . $_POST['user_email'] . "'"); ?> />
			</div>
		</div>

		<div class="block last">
			<input type="submit" value="დამატება" class="text_field" id="new_post_submit" />
		</div>

		<?php
			if(!empty($error)) 
			    foreach($error as $message)
			    	echo "<div class='error'>".$message."</div>";
		?>

	</form>
