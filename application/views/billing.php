<div class="post_text">

    <div style="width: 100%; text-align: center; font-size: 17px; margin-bottom: 25px;">
	დავალიანების მქონე მომხმარებლები
    </div>

    <?php
    $num = count($users) - 1;
    $_SESSION['billings'] = array();
    foreach ($users as $index => $user):
	$_SESSION['billings'][$user['id']] = $user['diff'];
	$nbmp = ($index == $num) ? " style='border: 0; margin-bottom: 0; padding-bottom: 0;'" : NULL; ?>
	<div class='b-block group'<?php echo $nbmp ?>>
	    <div class='b-block-header group'>
		<span class="b-block-title" style="float: left; margin-bottom: 15px;"><?php echo $user['fullname'] ?></span>
		<span class="b-block-title am_red" style="padding: 1px 3px;min-width: 0px; font-size: 12px; margin-left: 2px;">
		    <?php echo $user['diff'];  ?> ლ.
		</span>
		<a href="<?php echo URL::site('people/block/' . $user['id']); ?>" class="edit_button">დაბლოკვა</a>
		<?php if (!empty($user['email'])): ?>
		    <a href="<?php echo URL::site('transactions/email/' . $user['id']); ?>" style="margin-right: 10px;" class="edit_button">
			იმეილის მიწერა
		    </a>
		<?php else: ?>
		    <span title="მომხმარებლის ელფოსტა ცარიელია" style="margin-right: 15px;" class="disabled_button">იმეილის მიწერა</span>
		<?php endif; ?>
	    </div>
	</div>
    <?php endforeach; ?>

</div>
