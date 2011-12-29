	<div id="login" class="group">
		<form action="<?php echo URL::site('user/login') ?>" method="post">
			<p align='center'>გთხოვთ გაიაროთ ავტორიზაცია</p>
			<div class="block group">
				<div class="left_labels">
					<label for="usernamefield">მომხმარებელი</label>
				</div>

				<div class="right_fields">
					<input type="text" name="username" class="text_field" id="usernamefield" />
				</div>
			</div>
			<div class="block group">
				<div class="left_labels">
					<label for="passwordfield">პაროლი </label>
				</div>
				<div class="right_fields">
					<input type="password" name="password" class="text_field" id="passwordfield" />
				</div>
			</div>
			<div class="block last">
				<input type="submit" value="შესვლა" class="text_field" id="new_post_submit" />
			</div>
		</form>
	</div>
