<div class="post_text">

<?php
    $edit_button = $allow_edit ? "<a href='" . URL::site('user/edit_profile') . "' class='edit_button'>შეცვლა</a>" : NULL;
?>
    <div class='b-block group' style='border:0; margin: 0;'>

	<div class='b-block-header group'>
	    <div class='b-block-title'><?php echo $user['username'] ?></div>
		<?php echo $edit_button; ?>
	</div>

	<div class='b-block-left group'>
	    <div class='small-spacer'></div>
	    სახელი
	    <hr class='splitter-left' />
	    გვარი
	    <hr class='splitter-left' />
	    ელფოსტა
	</div>

	<div class='b-block-right group'>
	    <div class='small-spacer'></div>
	    <?php echo empty($user['first_name']) ? ' ― ' : $user['first_name'] ?>
	    <hr class='splitter-right' />
	    <?php echo empty($user['last_name']) ? ' ― ' : $user['last_name'] ?>
	    <hr class='splitter-right' />
	    <?php echo empty($user['email']) ? ' ― ' : $user['email'] ?>
	</div>

    </div>

</div>
