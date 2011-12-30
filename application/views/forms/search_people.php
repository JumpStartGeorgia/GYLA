<?php 
	print_r($the_search);
	$_person = array(
		'status_state' => (isset($the_search['person_status_state']) and !empty($the_search['person_status_state'])) ? 'checked="checked"' : null,
		'status_organization' => (isset($the_search['person_status_organization']) and !empty($the_search['person_status_organization'])) ? 'checked="checked"' : null,
		'name' => (isset($the_search['person_name']) and !empty($the_search['person_name'])) ? 'value="'.$the_search['person_name'].'"' : null,
		'date_start' => (isset($the_search['person_date_start']) and !empty($the_search['person_date_start'])) ? 'value="'.$the_search['person_date_start'].'"' : null,
		'date_end' => (isset($the_search['person_date_end']) and !empty($the_search['person_date_end'])) ? 'value="'.$the_search['person_date_end'].'"' : null,
		'private_number' => (isset($the_search['person_private_number']) and !empty($the_search['person_private_number'])) ? 'value="'.$the_search['person_private_number'].'"' : null,
		'gender_male' => ( (isset($the_search['person_gender']) and !empty($the_search['person_gender']) and $the_search['person_gender'] === 'male') or (!isset($the_search['peson_gender']) and empty($the_search['person-gender'])) ) ? 'checked="checked"' : null,
		'gender_female' => (isset($the_search['person_gender']) and !empty($the_search['person_gender']) and $the_search['person_gender'] === 'female') ? 'checked="chcked"' : null,
		'tel' => (isset($the_search['person_tel']) and !empty($the_search['person_tel'])) ? 'value="'.$the_search['person_tel'].'"' : null,
		'email' => (isset($the_search['person_email']) and !empty($the_search['person_email'])) ? 'value="'.$the_search['person_email'].'"' : null,
		'languages' => (isset($the_search['person_languages']) and !empty($the_search['person_languages'])) ? 'value="'.$the_search['person_languages'].'"'
	);
?>
<div id="seach-main-box" class="thebox  search-main-box" >
	<form action="<?php echo URL::site('people/search') ?>" method="post">
		<div class="left-box">
			<div class="search-child-box">
				სტატუსი:<br />
					<input type="checkbox" name="person_status_state" id="person_status_state" <?php echo $_person['status_state'] ?>/>
					<label for="person_status_state">შტატი</label> 
					<input type="checkbox" name="person_status_organization" id="person_status_organization" <?php echo $_person['status_organization'] ?>/>
					<label for="person_status_organization">ორგანიზაცია</label>			
			</div><br />
			<div class="search-child-box">
				<label for="person_name">სახელი:</label><br />
					<input type="text" name="person_name" id="person_name"<?php echo $_person['name'] ?>/>
			</div><br />
			<div class="search-child-box" style="margin-top:10px;">
				<label for="person_date_start">დაბადების თარიღი:</label><br />
					<input type="text" name="person_date_start" id="person_date_start" <?php echo $_person['date_start'] ?>/> - დან
					<input type="text" name="person_date_end" id="person_date_end" <?php echo $_person['date_end'] ?>/> - მდე
			</div>
			<div class="search-child-box" style="margin-top:20px;">
				<label for="person_private_number">პირადი ნომერი:</label>
					<input type="text" name="person_private_number" id="person_private_number" <?php echo $_person['private_number'] ?>/>
			</div>
			<div class="search-child-box" style="margin-top:30px;">
				სქესი: <br />
					<input type="radio" name="person_gender" value="male" id="person_gender_male" <?php echo $_person['gender_male'] ?>/>
					<label for="person_gender_male">მამრობითი</label><br />
					<input type="radio" name="person_gender" value="female" id="person_gender_female" <?php echo $_person['gender_female'] ?>/>
					<label for="person_gender_female">მდედრობითი</label>								
			</div>			
		</div>
		<div class="right-box">	
			<div class="search-child-box">
				<label for="person_tel">ტელეფონი:</label><br />
					<input type="text" name="person_tel" id="person_tel" <?php echo $_person['languages'] ?>/>
			</div>
			<div class="search-child-box" style="margin-top:30px;">
				<label for="person_email">ელფოსტა:</label><br />
					<input type="text" name="person_email" id="person_email" />
			</div>
			<div class="search-child-box" style="margin-top:30px;height:auto;">
				ენები:<br />					
					<input type="text" name="person_languages" id="person_languages" />
			</div>
			<div class="search-child-box">
				ოფისი:<br />
					<select id="person_office" name="person_office">
						<?php foreach ( $offices as $office ): ?>
							<option value="<?php echo $office['id'] ?>"><?php echo $office['name'] ?></option>
						<?php endforeach; ?>
					</select>
			</div>
		</div>
		<div class="box-devider"></div>
		<input type="submit" value="ძებნა" id="person_search" <?php if ( (isset($_GET['id']) and !empty($_GET['id'])) or (isset($_POST) and !empty($_POST) and count($_POST)>0) ): ?> class="person_search_made" />			
				<button id="person_search_save">შენახვა</button>
			<?php else: ?>
				class="person_search" />
			<?php endif; ?>
		<select id="person_saved_search"></select>
	</form>
</div>

