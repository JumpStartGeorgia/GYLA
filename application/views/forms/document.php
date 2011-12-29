	<form action="<?php echo URL::site('post/new/document/') ?>" method="post" enctype="multipart/form-data" id="document_form">

		<div class="block group">
			<div class="left_labels">
				<label for="new_post_title">სათაური: </label>
			</div>

			<div class="right_fields">
				<input type="text" name="document_title" class="text_field" id="new_post_title" />
			</div>
		</div>

		<div class="block group">
			<div class="left_labels">
				<label for="new_post_attachment">დოკუმენტი: </label>
			</div>

			<div class="right_fields">
				<input type="file" name="document_attachment" size="16" id="new_post_attachment" />
			</div>
		</div>

		<div class="block group">
			<div class="left_labels">
				<label for="new_post_body">ტექსტი: </label>
			</div>

			<div class="right_fields">
				<textarea name="document_body" class="text_field" id="new_post_body"></textarea>
			</div>
		</div>

		<div class="block last">
			<input type="submit" value="დამატება" class="text_field" id="new_post_submit" />
		</div>

	</form>
