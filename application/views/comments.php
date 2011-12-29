<?php
	  	foreach($comments as $comment):

			$delete_button = $allow_delete_comment ? "<a id='comment_" . $comment['id'] . "' class='edit_button delete_comment' style='color: #fff;padding-bottom:3px;'>წაშლა</a>" : NULL;

			$width = "width: 310px";
			empty($delete_button) AND $width = "width: 365px";

	  		echo "
			<div class='group comments_box'>

				<div class='leftbox group' style=\"width: 120px\">
					<img src='" . URL::base() . "/images/images/user.png' />

					<a href='" . URL::site('user/profile/' . $comment['user_id']) . "' class='userprofilelink'>
						" . $comment['first_name'] . " " . $comment['last_name'] . "
					</a><br />

					<img class='fiximage' src='" . URL::base() . "/images/images/data_time.png' />

					<abbr class='cdatetime' title=\"{$comment['published_at']}\">
						" . fuzzy_span_geo($comment['published_at']) . "
					</abbr>
				</div>

				<div class='rightbox' style='float:left;" . $width . "'>" . Text::auto_link($comment['body']) . "</div>

				<div stlye='float:right'>" . $delete_button . "</div>

			</div>
			";
	  	endforeach;
?>
			<form action="<?php echo URL::site('comment/new/'.$post_id) ?>"
			      onsubmit="submit_comment(<?php echo $post_id ?>); return false;"
			      method="post" id="comment_form<?php echo $post_id?>" class="comment_form">
					<textarea name="comment_body" id="comment_form_input<?php echo $post_id ?>" class="text_field"
						  onkeydown="keydownhandler(event,<?php echo $post_id ?>);"></textarea>
				<input type="submit" value="Submit" class="comment_submit text_field" />
			</form>
