	<form action="<?php echo URL::site('user/update_profile') ?>" method="post" id="user_form">

		<div class="block group">
			<div class="left_labels">
				<label for="username">მომხმარებელი: </label>
			</div>

			<div class="right_fields">
				<input type="text" name="username" disabled="disabled" class="text_field widefield" id="username" 
					value='<?php echo $user['username'] ?>' />
			</div>
		</div>

		<div class="block group">
			<div class="left_labels">
				<label for="firstname">სახელი: </label>
			</div>

			<div class="right_fields">
				<input type="text" name="first_name" class="text_field widefield" id="firstname" 
					value='<?php echo $user['first_name'] ?>' />
			</div>
		</div>

		<div class="block group">
			<div class="left_labels">
				<label for="user_lastname">გვარი: </label>
			</div>

			<div class="right_fields">
				<input type="text" name="last_name" class="text_field widefield" id="user_lastname"
					value='<?php echo $user['last_name'] ?>' />
			</div>
		</div>


		<div class="block group">
			<div class="left_labels">
				<label for="user_username">ელფოსტა: <span class='required'>*</span></label>
			</div>

			<div class="right_fields">
				<input type="text" name="email" class="text_field widefield" id="user_username"
					value='<?php echo $user['email'] ?>' />
			</div>
		</div>

		<div class="block group">
			<div class="left_labels">
				<label for="user_password">ახალი პაროლი: </label>
			</div>

			<div class="right_fields">
				<input type="password" name="password" class="text_field widefield" id="user_password" />
			</div>
		</div>

		<div class="block group">
			<div class="left_labels">
				<label for="user_confirm">გაიმეორეთ პაროლი: </label>
			</div>

			<div class="right_fields">
				<input type="password" name="confirm" class="text_field widefield" id="user_confirm" />
			</div>
		</div>


		<div class="block last">
			<input type="submit" value="შენახვა" class="text_field" id="new_post_submit" />
		</div>

		<?php
			if(!empty($error)) 
			    foreach($error as $message)
			    	echo "<div class='error'>".$message."</div>";
		?>

	</form>
