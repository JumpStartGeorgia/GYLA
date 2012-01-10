<div class="post_text">

    <?php
    $num = count($groups) - 1;

    foreach ($groups as $index => $group):
	$del_button = $allow_del ? '<a href="' . URL::site('groups/delete/' . $group['id']) . '" onclick="return confirm(\'Are you sure?\');" class="edit_button">წაშლა</a>' : NULL;
	$edit_button = $allow_edit ? '<a href="' . URL::site('groups/edit/' . $group['id']) . '" class="edit_button" style="margin-right: 5px">შეცვლა</a>' : NULL;
	$nbmp = ($index == $num) ? " style='border: 0; margin-bottom: 0; padding-bottom: 0;'" : NULL; ?>
	<div class='b-block group'<?php echo $nbmp ?>>
	    <div class='b-block-header group'>
		<span class="b-block-title" style="margin-bottom: 15px;"><?php echo $group['name'] ?></span>
		<?php echo $del_button . $edit_button; ?>
	    </div>
	</div>
    <?php endforeach; ?>

</div>
