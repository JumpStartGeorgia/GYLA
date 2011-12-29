<div id="seach-main-box" class="thebox  search-main-box" >
	<form action="<?php echo URL::site('people/search') ?>" method="post">
		<div class="left-box">
			<div class="search-child-box">
				სტატუსი:<br />
					<input type="checkbox" name="person_status_state" id="person_status_state" />
					<label for="person_status_state">შტატი</label> 
					<input type="checkbox" name="person_status_organization" id="person_status_organization" />
					<label for="person_status_organization">ორგანიზაცია</label>			
			</div><br />
			<div class="search-child-box">
				<label for="person_name">სახელი:</label><br />
					<input type="text" name="person_name" id="person_name"/>
			</div><br />
			<div class="search-child-box" style="margin-top:10px;">
				<label for="person_date_start">დაბადების თარიღი:</label><br />
					<input type="text" name="person_date_start" id="person_date_start" /> - დან
					<input type="text" name="person_date_end" id="person_date_end" /> - მდე
			</div>
			<div class="search-child-box" style="margin-top:20px;">
				<label for="person_private_number">პირადი ნომერი:</label>
					<input type="text" name="person_private_number" id="person_private_number" />
			</div>
			<div class="search-child-box" style="margin-top:30px;">
				სქესი: <br />
					<input type="radio" name="person_gender" value="male" id="person_gender_male" checked/>
					<label for="person_gender_male">მამრობითი</label><br />
					<input type="radio" name="person_gender" value="female" id="person_gender_female" />
					<label for="person_gender_female">მდედრობითი</label>								
			</div>			
		</div>
		<div class="right-box">	
			<div class="search-child-box">
				<label for="person_tel">ტელეფონი:</label><br />
					<input type="text" name="person_tel" id="person_tel" />
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
		<input type="submit" value="ძებნა" id="person_search" />
		<!--<button id="person_search_save">შენახვა</button>-->
		<select id="person_saved_search"></select>
	</form>
</div>

