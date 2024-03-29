<?php 
	$_person = array(
		'status_state' => (isset($the_search['person_status_state']) and !empty($the_search['person_status_state'])) ? 'checked="checked"' : '',
		'status_organization' => (isset($the_search['person_status_organization']) and !empty($the_search['person_status_organization'])) ? 'checked="checked"' : '',
		'name' => (isset($the_search['person_name']) and !empty($the_search['person_name'])) ? 'value="'.$the_search['person_name'].'"' : '',
		'date_start' => (isset($the_search['person_date_start']) and !empty($the_search['person_date_start'])) ? 'value="'.$the_search['person_date_start'].'"' : '',
		'date_end' => (isset($the_search['person_date_end']) and !empty($the_search['person_date_end'])) ? 'value="'.$the_search['person_date_end'].'"' : '',
		'private_number' => (isset($the_search['person_private_number']) and !empty($the_search['person_private_number'])) ? 'value="'.$the_search['person_private_number'].'"' : null,
		'gender_male' => ( isset($the_search['person_gender']) and !empty($the_search['person_gender']) and $the_search['person_gender'] === 'male' ) ? 'checked="checked"' : '',
		'gender_female' => (isset($the_search['person_gender']) and !empty($the_search['person_gender']) and $the_search['person_gender'] === 'female') ? 'checked="chcked"' : '',
		'gender_all' => ( (isset($the_search['person_gender']) and !empty($the_search['person_gender']) and $the_search['person_gender'] === 'all') or (!isset($the_search['person_gender']) and empty($the_search['person-gender'])) ) ? 'checked="checked"' : '',
		'tel' => (isset($the_search['person_tel']) and !empty($the_search['person_tel'])) ? 'value="'.$the_search['person_tel'].'"' : '',
		'email' => (isset($the_search['person_email']) and !empty($the_search['person_email'])) ? 'value="'.$the_search['person_email'].'"' : '',
		'languages' => (isset($the_search['person_languages']) and !empty($the_search['person_languages'])) ? 'value="'.implode(', ',$the_search['person_languages']).'"' : ''
	);
?>
<div id="seach-main-box" class="thebox search-main-box" >
	<form action="<?php echo URL::site('people/search') ?>" method="post">
		<div class="left-box">
			<div class="search-child-box">
				სტატუსი:<br />
					<input type="checkbox" name="person_status_state" id="person_status_state" <?php echo $_person['status_state'] ?>/>
					<label for="person_status_state">წევრი</label> 
					<input type="checkbox" name="person_status_organization" id="person_status_organization" <?php echo $_person['status_organization'] ?>/>
					<label for="person_status_organization">თანამშრომელი</label>			
			</div>
			<div class="search-child-box">
				<label for="person_name">სახელი:</label><br />
					<input type="text" class="text_field" name="person_name" id="person_name"<?php echo $_person['name'] ?>/>
			</div>
			<div class="search-child-box">
				<label for="person_date_start">დაბადების თარიღი:</label><br />
					<input type="text" class="text_field datepicker" name="person_date_start" id="person_date_start" <?php echo $_person['date_start'] ?>/> - დან
					<input type="text" class="text_field datepicker" name="person_date_end" id="person_date_end" <?php echo $_person['date_end'] ?>/> - მდე
			</div>
			<div class="search-child-box">
				<label for="person_private_number">პირადი ნომერი:</label>
					<input type="text" class="text_field" name="person_private_number" id="person_private_number" <?php echo $_person['private_number'] ?>/>
			</div>
			<div class="search-child-box">
				სქესი: <br />
					<input type="radio" name="person_gender" value="male" id="person_gender_male" <?php echo $_person['gender_male'] ?>/>
					<label for="person_gender_male">მამრობითი</label><br />
					<input type="radio" name="person_gender" value="female" id="person_gender_female" <?php echo $_person['gender_female'] ?>/>
					<label for="person_gender_female">მდედრობითი</label><br />	
					<input type="radio" name="person_gender" value="all" id="person_gender_all" <?php echo $_person['gender_all'] ?>/>
					<label for="person_gender_all">ყველა</label>							
			</div>			
		</div>
		<div class="right-box">	
			<div class="search-child-box">
				<label for="person_tel">ტელეფონი:</label><br />
					<input type="text" class="text_field" name="person_tel" id="person_tel" <?php echo $_person['tel'] ?>/>
			</div>
			<div class="search-child-box">
				<label for="person_email">ელფოსტა:</label><br />
					<input type="text" class="text_field" name="person_email" id="person_email" <?php echo $_person['email'] ?>/>
			</div>
			<div class="search-child-box" style="height:auto;">
				ენები:<br />					
					<input type="text" class="text_field" name="person_languages" id="person_languages" <?php echo $_person['languages'] ?>/>
			</div>
			<div class="search-child-box">
				ოფისი:<br />
					<select id="person_office" name="person_office">
						<option value="0">ყველა</option>
						<?php foreach ( $offices as $office ): ?>
							<option value="<?php echo $office['id'] ?>" <?php echo (isset($the_search['person_office']) and !empty($the_search['person_office']) and $office['id']===$the_search['person_office']) ? 'selected="selected"' : null ?>><?php echo $office['name'] ?></option>
						<?php endforeach; ?>						
					</select>
			</div>
		</div>
		<div class="box-devider group"></div>
		<?php $made = (!empty($_POST) and count($_POST) > 0); ?>
		<div id="search_buttons" <?php $made and print 'style="margin-left: 110px;"'; ?>>
		<input type="submit" value="ძებნა" id="person_search" class="group person_search" />
		<?php if ($made): ?>
		    <button class="group" id="person_search_save">შენახვა</button>
		<?php endif; ?>
		<?php if ( !empty($saved_search) ): ?>
		    <select id="person_saved_search"></select>
		<?php endif; ?>
		</div>
	</form>
</div>
<?php if ( isset($_GET['id']) and !empty($_GET['id']) and !empty($saved_search) ): ?>
	<script>
		var theSavedSearch = <?php echo $_GET['id'] ?>;
	</script>
<?php endif; ?>

