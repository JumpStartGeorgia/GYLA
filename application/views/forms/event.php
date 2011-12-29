<?php
	$action = empty($event['name']) ? URL::site('events/create') : URL::site('events/update/'.$event['id']);
?>
	<form action="<?php echo $action; ?>" method="post" id='form_event'>

		<div class="block group">
			<div class="left_labels">
				<label for="etitle">სახელი: <span class='required'>*</span></label>
			</div>

			<div class="right_fields">
				<input type="text" name="event_name" class="text_field widefield"
					id="etitle" value="<?php echo $event['name']; ?>" />
			</div>
		</div>

		<div class="block group">
			<div class="left_labels">
				<label for="etype">მოვლენის სახეობა: <span class='required'>*</span></label>
			</div>

			<div class="right_fields">
				<select name="event_type" id="etype">
					<option	<?php echo ($event['type'] == "member") ? "selected='selected'" : NULL ?>
						value="members">წევრებისთვის</option>
					<option <?php echo ($event['type'] == "staff") ? "selected='selected'" : NULL ?>
						value="staff">თანამშრომლებისთვის</option>
				</select>
			</div>
		</div>

		<div class="block group">
			<div class="left_labels">
				<label for="edistrict">რაიონი: <span class='required'>*</span></label>
			</div>

			<div class="right_fields">
				<select name="event_district" id="edistrict">
				  <?php foreach($districts as $district)
				  	{
				  	    $s = ($district['id'] == $event['district_id'] ) ? "selected='selected'" : NULL;
				  	    echo "<option ".$s." value='".$district['id']."'>".$district['name']."</option>";
				  	}
				  ?>
				</select>
			</div>
		</div>

		<div class="block group">
			<div class="left_labels">
				<label for="eaddress">მისამართი: <span class='required'>*</span></label>
			</div>

			<div class="right_fields">
				<input type="text" name="event_address" class="text_field widefield"
					id="eaddress" value="<?php echo $event['address']; ?>" />
			</div>
		</div>

		<div class="block group">
			<div class="left_labels">
				<label for="">დასაწყისი: <span class='required'>*</span></label>
			</div>

			<div class="right_fields">
				<input type="text" id="datepicker1" class="text_field datepicker" name="event_start_at_date"
				      value="<?php echo substr($event['start_at'], 0, 10); ?>" style='width: 150px;margin-right:85px;' />
				<select name="event_start_at_hour">
				<?php
				    $j = 0;
				    for($i = 1; $i < 48; $i ++)
				    {
				    	$j = ($i % 2 == 0) ? ($j+1) : ($j);
				    	$m = ($i % 2 == 0 || $i == 1) ? "00" : "30";
				    	$j = ($j < 10 AND strlen($j) == 1) ? "0".$j : $j;
							if($event['start_at'] == NULL)
								$s = ($j == "12" && $m == "00") ? "selected='selected'" : NULL;
							else
								$s = (substr($event['start_at'], 11, 5) == ($j.":".$m)) ? "selected='selected'" : NULL;
				        echo "<option ".$s." value='".$j.":".$m."'>".$j.":".$m."</option>";
				    }
				?>
				</select>
			</div>
		</div>

		<div class="block group">
			<div class="left_labels">
				<label for="">დასასრული: </label>
			</div>

			<div class="right_fields">
				<input type="text" id="datepicker2" class="text_field datepicker" name="event_end_at_date"
					value="<?php echo substr($event['end_at'], 0, 10); ?>" style='width: 150px;margin-right:85px;' />
				<select name="event_end_at_hour">
				<?php
				    $j = 0;
				    for($i = 1; $i < 48; $i ++)
				    {
				    	$j = ($i % 2 == 0) ? ($j+1) : ($j);
				    	$m = ($i % 2 == 0 || $i==1) ? "00" : "30";
				    	$j = ($j < 10 AND strlen($j) == 1) ? "0".$j : $j;
				    	if($event['end_at'] == NULL)
					    $s = ($j == "12" && $m == "00") ? "selected='selected'" : NULL;
					else
					    $s = (substr($event['end_at'], 11, 5) == ($j.":".$m)) ? "selected='selected'" : NULL;
				        echo "<option ".$s." value='".$j.":".$m."'>".$j.":".$m."</option>";
				    }
				?>
				</select>
			</div>
		</div>

		<div class="block group">
			<div class="left_labels">
				<label for="einfo">საკონტაქტო ინფორმაცია: </label>
			</div>

			<div class="right_fields">
				<input type="text" name="event_contact_info" class="text_field widefield"
					id="einfo" value="<?php echo $event['contact_info']; ?>" />
			</div>
		</div>

		<div class="block last">
			<input type="submit" value="შენახვა" class="text_field" id="new_post_submit" />
		</div>

	</form>
