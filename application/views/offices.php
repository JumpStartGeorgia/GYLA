<div class="post_text">

<?php

    $num = count($offices) - 1;

    foreach($offices as $index => $office):

	$edit_button = $allow_edit ? "<a href='" . URL::site('offices/edit/' . $office['id']) . "' class='edit_button'>შეცვლა</a>" : NULL;

	$nbmp = ($index == $num) ? ' style="border: 0; margin: 0;"' : NULL;
?>
	<div class='b-block group'<?php echo $nbmp ?>>

	    <div class='b-block-header group'>
		<div class='b-block-title'><?php echo $office['office_name'] ?></div>
		   <?php echo $edit_button; ?>
	    </div>

	    <div class='b-block-left group'>
		<div class='small-spacer'></div>
		რაიონი
		<hr class='splitter-left' />
		მისამართი
		<hr class='splitter-left' />
		ტელეფონი
		<hr class='splitter-left' />
		ფაქსი
		<hr class='splitter-left' />
		ელფოსტა
		<hr class='splitter-left' />
	    </div>

	    <div class='b-block-right group'>
		<div class='small-spacer'></div>
		<?php echo empty($office['district_name']) ? ' ― ' : $office['district_name'] ?>
		<hr class='splitter-left' />
		<?php echo empty($office['address']) ? ' ― ' : $office['address'] ?>
		<hr class='splitter-left' />
		<?php echo empty($office['phone']) ? ' ― ' : $office['phone'] ?>
		<hr class='splitter-left' />
		<?php echo empty($office['fax']) ? ' ― ' : $office['fax'] ?>
		<hr class='splitter-left' />
		<?php echo empty($office['email']) ? ' ― ' : $office['email'] ?>
		<hr class='splitter-left' />
		<?php /* echo $office['manager_first_name'] . " " . $office['manager_last_name'] */ ?>
	    </div>

	</div>

<?php
    endforeach;
?>

</div>
