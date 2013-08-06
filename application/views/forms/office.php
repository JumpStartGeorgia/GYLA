<?php
	$action = empty($office['id']) ? URL::site('offices/create') : URL::site('offices/update/' . $office['id']);

?>
	<form action="<?php echo $action ?>" method="post" id='form_office'>

		<div class="block group">
			<div class="left_labels">
				<label for="ofname">ოფისის სახელი: <span class='required'>*</span></label>
			</div>

			<div class="right_fields">
				<input type="text" name="office_name" class="text_field widefield"
					id="ofname" value="<?php echo $office['name']; ?>" />
			</div>
		</div>

		<?php /* <div class="block group">
			<div class="left_labels">
				<label for="fname">მენეჯერის სახელი: </label>
			</div>

			<div class="right_fields">
				<input type="text" name="office_first_name" class="text_field widefield"
					id="fname" value="<?php echo $office['manager_first_name']; ?>" />
			</div>
		</div>

		<div class="block group">
			<div class="left_labels">
				<label for="flast">მენეჯერის გვარი: </label>
			</div>

			<div class="right_fields">
				<input type="text" name="office_last_name" class="text_field widefield"
					id="flast" value="<?php echo $office['manager_last_name']; ?>" />
			</div>
		</div> */ ?>

		<div class="block group">
			<div class="left_labels">
				<label for="flast">ოფისის ხელმძღვანელი: </label>
			</div>

			<div class="right_fields">
				<input type="text" name="office_manager" class="text_field widefield"
					id="flast" value="<?php echo $office['manager']; ?>" />
			</div>
		</div>

		<div class="block group">
			<div class="left_labels">
				<label for="fdistrict">რაიონი: <span class='required'>*</span></label>
			</div>

			<div class="right_fields">
				<select name="office_district" id="fdistrict">
				  <?php foreach($districts as $district)
				  	{
				  	    $s = ($district['id'] == $office['district_id']) ? "selected='selected'" : NULL;
				  	    echo $office['district_id'];
				  	    echo "<option ".$s." value='".$district['id']."'>".$district['name']."</option>";

					    if (!empty($district['districts']))
					    {
						foreach($district['districts'] as $indis)
						{
						    $s = ($indis['id'] == $office['district_id'] ) ? "selected='selected'" : NULL;
						    echo "<option " . $s . " value='" . $indis['id'] . "'> – " . $indis['name']."</option>";
						}
					    }
				  	}
				  ?>
				</select>
			</div>
		</div>

		<div class="block group">
			<div class="left_labels">
				<label for="faddress">მისამართი: <span class='required'>*</span></label>
			</div>

			<div class="right_fields">
				<input type="text" name="office_address" class="text_field widefield"	
					id="faddress" value="<?php echo $office['address']; ?>" />
			</div>
		</div>

		<div class="block group">
			<div class="left_labels">
				<label for="fphone">ტელეფონი: </label>
			</div>

			<div class="right_fields">
				<input type="text" name="office_phone" class="text_field widefield"
					id="fphone" value="<?php echo $office['phone']; ?>" />
			</div>
		</div>

		<div class="block group">
			<div class="left_labels">
				<label for="ffax">ფაქსი: </label>
			</div>

			<div class="right_fields">
				<input type="text" name="office_fax" class="text_field widefield"
					id="ffax" value="<?php echo $office['fax']; ?>" />
			</div>
		</div>

		<div class="block group">
			<div class="left_labels">
				<label for="femail">ელფოსტა: </label>
			</div>

			<div class="right_fields">
				<input type="text" name="office_email" class="text_field widefield"
					id="femail" value="<?php echo $office['email']; ?>" />
			</div>
		</div>


		<div class="block last">
			<input type="submit" value="შენახვა" class="text_field" id="new_post_submit" />
		</div>

	</form>
