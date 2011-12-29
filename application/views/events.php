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
	<div class='b-block group'<?php echo $nbmp ?>>
	    <div class='b-block-header group'>
		    <div class='b-block-title'><?php echo $event['name']; ?></div>
		    <?php echo $edit_button; /*?>
		    <a class='edit_button' href='<?php echo URL::site() ?>' onclick='return confirm("დარწმუნებული ხართ?")'>წაშლა</a>*/ ?>
	    </div>


	    <div class='b-block-left group'>
	    	<div class='small-spacer'></div>
	        მოვლენის სახეობა
	        <hr class='splitter-left' />
	        მისამართი
	        <hr class='splitter-left' />
	        რაიონი
	        <hr class='splitter-left' />
	     	  დასაწყისი   
	        <hr class='splitter-left' />
	        დასასრული
	        <hr class='splitter-left' />
	        საკონტაქტო ინფორმაცია
	    </div>

	    <div class='b-block-right group'>
	        <div class='small-spacer'></div>
		<?php echo ($event['type'] == "members") ? "წევრებისთვის" : "თანამშრომლებისთვის" ?>
		<hr class='splitter-right' />
		<?php echo $event['address'] ?>
		<hr class='splitter-right' />
		<?php echo $event['district'] ?>
		<hr class='splitter-right' />
		<?php echo substr($event['start_at'], 0, -3) ?>
		<hr class='splitter-right' />
		<?php echo substr($event['end_at'], 0, -3) ?>
		<hr class='splitter-right' />
		<?php echo $event['contact_info'] ?>
	    </div>

	</div>

<?php
    endforeach;
?>

</div>
