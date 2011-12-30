<div class="post_text">

    <?php
    $num = count($groups) - 1;

    foreach ($groups as $index => $group):
	$del_button = $allow_del ? '<a href="' . URL::site('groups/delete/' . $group['id']) . '" onclick="return confirm(\'Are you sure?\');" class="edit_button" style="margin-right: 5px">წაშლა</a>' : NULL;
	$nbmp = ($index == $num) ? " style='border: 0; margin-bottom: 0; padding-bottom: 0;'" : NULL; ?>
	<div class='b-block group'<?php echo $nbmp ?>>
	    <div class='b-block-header group'>
		<a class="b-block-title" href="<?php echo URL::site('groups/edit/' . $group['id']) ?>"><?php echo $group['name'] ?></a>
		<?php echo $del_button; ?>
	    </div>
	</div>
    <?php endforeach; ?>

</div>
