<div class="post_text">
<?php
    $edit_button = $allow_edit ? "<a href='" . URL::site('events/edit/' . $event['id']) . "' class='edit_button'>შეცვლა</a>" : NULL;
    $del_button = $allow_delete ? "<a style='margin-left: 7px;' href='" . URL::site('events/delete/' . $event['id']) . "' class='edit_button confirmdel'>წაშლა</a>" : NULL;
?>
    <div class='b-block group' style='border:0; margin: 0;'>

        <div class="b-block-header group" style="text-align: left;">
            <div class='b-block-title' style="text-align: center;"><?php echo $event['name']; ?></div>
            <?php echo $del_button . $edit_button; ?>
        </div>

	<table class="info_list" id="testid">

	    <?php /*<tr>
		<td left>სახელი</td>
		<td right><?php echo empty($event['name']) ? ' ― ' : $event['name'] ?></td>
	    </tr>*/ ?>

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
		<td noborder left>საკონტაქტო ინფორმაცია</td>
		<td noborder right><?php echo (empty($event['contact_info']) ? ' ― ' : $event['contact_info']); ?></td>
	    </tr>

	</table>



    </div>

</div>
