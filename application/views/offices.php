<div class="post_text">

<?php

    $num = count($offices) - 1;

    foreach($offices as $index => $office):

	$edit_button = $allow_edit ? "<a href='" . URL::site('offices/edit/' . $office['id']) . "' class='edit_button'>შეცვლა</a>" : NULL;
	$del_button = $allow_delete ? "<a style='margin-left: 7px;' href='" . URL::site('offices/delete/' . $office['id']) . "' class='edit_button confirmdel'>წაშლა</a>" : NULL;

	$nbmp = ($index == $num) ? ' style="border: 0; margin: 0;"' : NULL;
?>
	<div class="b-block group"<?php echo $nbmp ?> style="border-bottom: 0px; margin-bottom: 37px;">

	    <div class="b-block-header group" style="text-align: left;">
		<div class="b-block-title"><?php echo $office['office_name'] ?></div>
		   <?php echo $del_button . $edit_button; ?>
	    </div>

		
		
	<table class="info_list" id="testid" style="margin: 0px;">

    <?php if (!empty($office['manager'])): ?>
	    <tr>
		<td left>ხელმძღვანელი</td>
		<td right><?php echo $office['manager']; ?></td>
	    </tr>
	  <?php endif; ?>

	    <tr>
		<td left>რაიონი</td>
		<td right><?php echo empty($office['district_name']) ? ' ― ' : $office['district_name'] ?></td>
	    </tr>

	    <tr>
		<td left>მისამართი</td>
		<td right><?php echo empty($office['address']) ? ' ― ' : $office['address'] ?></td>
	    </tr>

	    <tr>
		<td left>ტელეფონი</td>
		<td right><?php echo empty($office['phone']) ? ' ― ' : $office['phone'] ?></td>
	    </tr>

	    <tr>
		<td left>ფაქსი</td>
		<td right><?php echo empty($office['fax']) ? ' ― ' : $office['fax'] ?></td>
	    </tr>

	    <tr>
		<td left>ელფოსტა</td>
		<td right><?php echo empty($office['email']) ? ' ― ' : $office['email'] ?></td>
	    </tr>

	</table>

    </div>

<?php
    endforeach;
?>

</div>
