<div id='event_switcher'>
    <a class='switch switched' href='<?php echo URL::site('events/index') ?>'>სია</a>
    <a class='switch' href='<?php echo URL::site('events/map') ?>'>რუკა</a>
    <a class='switch' href='<?php echo URL::site('events/calendar') ?>'>კალენდარი</a>
</div>



<div class="post_text">

<?php

    $num = count($events) - 1;

    foreach($events as $index => $event):
	$edit_button = $allow_edit ? "<a href='" . URL::site('events/edit/' . $event['id']) . "' class='edit_button'>შეცვლა</a>" : NULL;

	$nbmp = ($index == $num) ? " style='border: 0; margin-bottom: 0; padding-bottom: 0;'" : NULL;
?>
	<a name='event<?php echo $event['id'] ?>'></a>
	<div class="b-block group"<?php echo $nbmp ?> style="border-bottom: 0px; margin-bottom: 35px;">
	    <div class="b-block-header group">
		    <a class='b-block-title' href="<?php echo URL::site('events/view/' . $event['id']); ?>"><?php echo $event['name']; ?></a>
		    <?php echo $edit_button; /*?>
		    <a class='edit_button' href='<?php echo URL::site() ?>' onclick='return confirm("დარწმუნებული ხართ?")'>წაშლა</a>*/ ?>
	    </div>


	<table class="info_list" id="testid" style="margin: 0px;">

	    <tr>
		<td left>მოვლენის სახეობა</td>
		<td right>
		    <?php echo empty($event['type']) ? ' ― ' : strtr($event['type'], array('members' => 'წევრებისთვის', 'staff' => 'თანამშრომლებისთვის')) ?>
		</td>
	    </tr>

	    <tr>
		<td left>რაიონი</td>
		<td right><?php echo empty($event['district']) ? ' ― ' : $event['district'] ?></td>
	    </tr>

	    <tr>
		<td left>მისამართი</td>
		<td right><?php echo empty($event['address']) ? ' ― ' : $event['address'];?></td>
	    </tr>

	    <tr>
		<td left>დასაწყისი</td>
		<td right><?php echo empty($event['start_at']) ? ' ― ' : Controller_People::reformat_date($event['start_at']) ?></td>
	    </tr>

	    <tr>
		<td left>დასასრული</td>
		<td right><?php echo empty($event['end_at']) ? ' ― ' : Controller_People::reformat_date($event['end_at']) ?></td>
	    </tr>

	    <tr>
		<td left>საკონტაქტო ინფორმაცია</td>
		<td right><?php echo (empty($event['contact_info']) ? ' ― ' : $event['contact_info']); ?></td>
	    </tr>

	</table>

	</div>

<?php
    endforeach;
?>

</div>
