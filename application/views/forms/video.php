	<form action="<?php echo URL::site('post/new/video/') ?>" method="post" enctype="multipart/form-data" id="video_form">

		<div class="block group">
			<div class="left_labels">
				<label for="new_post_title">სათაური: </label>
			</div>

			<div class="right_fields">
				<input type="text" name="video_title" class="text_field" id="new_post_title" />
			</div>
		</div>

		<div class="block group">
			<div class="left_labels">
				<label for="new_post_attachment">ვიდეოს Embed კოდი: </label>
			</div>

			<div class="right_fields">
				<textarea name="video_embed_code" class="text_field" id="new_post_body" style='height:50px;'></textarea>
			</div>
		</div>

		<div class="block group">
			<div class="left_labels">
				<label for="new_post_body">ტექსტი: </label>
			</div>

			<div class="right_fields">
				<textarea name="video_body" class="text_field" id="new_post_body"></textarea>
			</div>
		</div>

		<div class="block last">
			<input type="submit" value="დამატება" class="text_field" id="new_post_submit" />
		</div>

	</form>
