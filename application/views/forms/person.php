<?php
$action = ($person['first_name'] === NULL) ? URL::site('people/create') : URL::site('people/update/' . $person['id']);
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : array();
?>
<form action="<?php echo $action ?>" method="post" id='form_person' enctype="multipart/form-data">

    <?php isset($_SESSION['message']) and print '<span class="error">' . $_SESSION['message'] . '</span>'; ?>

    <div class="block group <?php in_array('username', $errors) and print 'errorbox'; ?>">
        <div class="left_labels">
            <label for="username">მომხმარებელი: <span class='required'>*</span></label>
        </div>
        <div class="right_fields">
            <input type="text" name="username" class="text_field widefield" id="username" value="<?php echo $person['username']; ?>" />
        </div>
    </div>

    <div>
    <?php
    $newuser = empty($person['username']);
    ?>
    <div class="block group<?php $newuser OR print ' hidden'; in_array('password', $errors) and print ' errorbox'; ?>">
        <div class="left_labels">
            <label for="password">პაროლი:<?php empty($person['username']) AND print '<span class="required">*</span>' ?></label>
        </div>
        <div class="right_fields">
            <input type="password" name="password" class="text_field widefield" id="password" <?php $newuser or print 'style="width: 60%;"'; ?> value="" />
	    <?php if (!$newuser): ?><div class="switch" id="cancel_change_password_button">გაუქმება</div><?php endif; ?>
        </div>
    </div>
    <?php
    if (!$newuser): ?>
	<div class="block group">
	    <div class="switch group" id="change_password_button">პაროლის შეცვლა</div>
	</div>
    <?php endif; ?>
    </div>

    <?php if ($is_admin): ?>
    <div class="block group">
        <div class="left_labels">
            <label for="group_id">ჯგუფი: <span class='required'>*</span></label>
        </div>
        <div class="right_fields">
            <select name="group_id" id="group_id">
            <?php foreach ($groups as $group):
            	$selected = (!empty($person['group_id']) AND $group['id'] == $person['group_id']) ? 'selected="selected"': NULL; ?>
            	<option <?php echo $selected; ?> value="<? echo $group['id'] ?>"><?php empty($group['name']) OR print $group['name']; ?></option>
            <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="block group">
        <div class="left_labels">
            <label>დაბლოკილი:</label>
        </div>
        <div class="right_fields"><?php isset($person['blocked']) or $person['blocked'] = 0; ?>
            <label><input type="radio" name="blocked" <?php ($person['blocked'] == 1) AND print 'checked="checked"'; ?> value="1" />კი&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <label><input type="radio" name="blocked" <?php ($person['blocked'] == 0) AND print 'checked="checked"'; ?> value="0" />არა</label>
        </div>
    </div>

    <div class="block group">
        <div class="left_labels">
            <label for="payplan">გადასახადი:</label>
        </div>
        <div class="right_fields">
            <select name="pay_plan" id="payplan">
	    <?php foreach ($plans as $plan): isset($payplan) or $payplan = 0; ?>
		<option <?php ($plan == $payplan) AND print 'selected="selected"'; ?> value="<?php echo $plan; ?>"><?php echo $plan; ($plan == 0) AND print ' (უფასო)'; ?></option>
	    <?php endforeach; ?>
            </select>
        </div>
    </div>
    <?php endif; ?>

    <div class="block group">
        <div class="left_labels">
            <label>სტატუსი: </label>
        </div>

        <?php
        $member = explode(',', $person['member_of']);
        $s1 = $s2 = FALSE;
        if (!empty($member) && !empty($member[0])):
            if (in_array('staff', $member)):
                $s1 = 'checked';
            /* echo "<script>$(function(){ get_offices(".$person['office_id']."); });</script>"; */
            endif;

            $s2 = (in_array('organisation', $member)) ? "checked" : NULL;
        endif;
        ?>

        <div class="right_fields">
            <input type="checkbox" name="person_member_of[]" class="text_field" id="pmemberstaff" value="staff"
                   <?php echo $s1 ?> />
            <label for="pmemberstaff">წევრი </label>
            <?php /* <div style='display:none;margin:7px 0px 10px 25px;' id='officesdropdown'></div> */ ?>
            <input type="checkbox" name="person_member_of[]" class="text_field"
                   id="pmemberorg" value="organisation" <?php echo $s2 ?> />
            <label for="pmemberorg">თანამშრომელი </label>
        </div>
    </div>

    <div class="block group">
        <div class="left_labels">
            <label for="pdoc">დოკუმენტი: </label>
        </div>

        <div class="right_fields">
	    <?php if (!empty($documents)):
		foreach ($documents as $doc): ?>
		    <div class="document_box group">
			<a class="document_link" target="_blank" href="<?php echo URL::site($doc['url']) ?>">
			    <?php echo substr(basename($doc['url']), 0, 21); ?>
			</a>
			<div class="document_delete_button" doc_id="<?php echo $doc['id']; ?>">⨯</div>
		    </div>
		<?php endforeach;
	    endif; ?>
	    <div class="document_box group" style="border: 0px;">
		<input type="file" name="person_document[]" id="pdoc" />
		<div class="document_delete_button" style="display: none;">⨯</div>
	    </div>
        </div>
    </div>

    <div class="block group <?php in_array('person_first_name', $errors) and print 'errorbox'; ?>">
        <div class="left_labels">
            <label for="pname">სახელი: <span class='required'>*</span></label>
        </div>

        <div class="right_fields">
            <input type="text" name="person_first_name" class="text_field widefield"
                   id="pname" value="<?php echo $person['first_name']; ?>" />
        </div>
    </div>

    <div class="block group <?php in_array('person_last_name', $errors) and print 'errorbox'; ?>">
        <div class="left_labels">
            <label for="plast">გვარი: <span class='required'>*</span></label>
        </div>

        <div class="right_fields">
            <input type="text" name="person_last_name" class="text_field widefield"
                   id="plast" value="<?php echo $person['last_name']; ?>" />
        </div>
    </div>

    <div class="block group">
        <div class="left_labels">
            <label for="datepicker1">დაბადების თარიღი: </label>
        </div>

        <div class="right_fields">
            <input type="text" id="datepicker1" class="text_field widefield datepicker" name="person_birth_date"
                   value="<?php echo $person['birth_date']; ?>" style="width:98%" />
        </div>
    </div>

    <div class="block group">
        <div class="left_labels">
            <label for="ppnumber">პირადი ნომერი: </label>
        </div>

        <div class="right_fields">
            <input type="text" name="person_personal_number" class="text_field widefield"
                   id="ppnumber" value="<?php echo $person['personal_number']; ?>" />
        </div>
    </div>

    <div class="block group">
        <div class="left_labels">
            <label for="psex">სქესი: <span class='required'>*</span></label>
        </div>

        <div class="right_fields">
            <select name="person_sex" id="psex">
                <option selected='selected' value='male'>მამრობითი</option><?php echo ($person['sex']) ?>
                <option value='female' <?php echo ($person['sex'] == 'female') ? "selected='selected'" : NULL ?>>
						მდედრობითი
                </option>
            </select>
        </div>
    </div>

    <div class="block group">
        <div class="left_labels">
            <label for="paddress">მისამართი: </label>
        </div>

        <div class="right_fields">
            <input type="text" name="person_address" class="text_field widefield"
                   id="paddress" value="<?php echo $person['address']; ?>" />
        </div>
    </div>

    <div class="block group">
        <div class="left_labels">
            <label for="pphone">ტელეფონი: </label>
        </div>

        <div class="right_fields">
            <div style='text-align: right; margin-bottom: 13px;'>
                <?php
                if (!empty($phones) AND is_array($phones)):
                    foreach ($phones as $index => $phone):
                        $s = "selected='selected'";
                        ?>
                        <select name='person_phone_type[]'>
                            <option <?php ($phone['type'] == "home") AND print($s); ?> value='home'>სახლი</option>
                            <option <?php ($phone['type'] == "mobile") AND print($s); ?> value='mobile'>მობილური</option>
                            <option <?php ($phone['type'] == "work") AND print($s); ?> value='work'>სამსახური</option>
                        </select>
                        <input type="text" name="person_phone_number[]" class="text_field phonefield"
                               value="<?php echo $phone['number']; ?>" />
                           <?php endforeach;
                       else: ?>
                    <select name='person_phone_type[]'>
                        <option value='home'>სახლი</option>
                        <option value='mobile'>მობილური</option>
                        <option value='work'>სამსახური</option>
                    </select>
                    <input type="text" name="person_phone_number[]" class="text_field phonefield" />
                <?php endif; ?>
            </div>
            <span style='cursor:pointer;' id='another_phone'>+ტელეფონის დამატება</span>
        </div>
    </div>

    <div class="block group">
        <div class="left_labels">
            <label for="pemail">ელფოსტა: </label>
        </div>

        <div class="right_fields">
            <input type="text" name="person_email" class="text_field widefield"
                   id="pemail" value="<?php echo $person['email']; ?>" />
        </div>
    </div>

    <div class="block group">
        <div class="left_labels">
            <label for="peducation">განათლება: </label>
        </div>

        <div class="right_fields" style='width: 480px; text-align: right;'>
				<?php /* წლები სკოლაში:
            <input type="text" name="person_years_in_school" class="text_field" style='margin-left:30px;'
                   value="<?php echo $person['years_in_school']; ?>" id="peducation" /> */ ?>
            <br /><br />ხარისხი: <br /><br />
            <div id='fromto' style="display: inline;">
                <?php
                if (!empty($degrees) AND is_array($degrees) AND count($degrees) > 0):
                    foreach ($degrees as $index => $degree):
                        ($index == 0) OR print("<br />");
                        $ds1 = ($degree['degree'] == 'bachelor') ? "selected='selected'" : NULL;
                        $ds2 = ($degree['degree'] == 'llm') ? "selected='selected'" : NULL;
                        $ds3 = ($degree['degree'] == 'phd') ? "selected='selected'" : NULL;
                        echo "
				<select name='person_education_degree[]'>
					<option value='null' selected='selected' disabled>None</option>
					<option " . $ds1 . " value='bachelor'>ბაკალავრი  (B.A.)</option>
					<option " . $ds2 . " value='llm'>მაგისტრი     (LL.M.)</option>
					<option " . $ds3 . " value='phd'>დოქტორი    (Ph.D.)</option>
				</select> &nbsp;&nbsp;&nbsp;

				საიდან:
				<input type='text' class='text_field datepicker' name='person_education_degree_from[]'
					style='width:73px;' value='" . $degree['from'] . "' />&nbsp;&nbsp;
				სადამდე:
				<input type='text' class='text_field datepicker' name='person_education_degree_to[]'
				       style='width:73px;' value='" . $degree['to'] . "' /><br/>
			    ";
                    endforeach;
                endif; ?>
            </div>
            <br /><br />
            <span style='cursor:pointer;' onclick='another_degree();'>+ხარისხის დამატება</span>
        </div>
    </div>

    <div class="block group no-border ">
        <div class="left_labels">
            <label for="pposition">თანამდებობა: </label>
        </div>

        <div class="right_fields">
            <input type="text" name="person_position" class="text_field widefield"
                   id="pposition" value="<?php echo $person['position']; ?>" />

            
        </div>
    </div>
    
    
    <div class="block group">
        <div class="left_labels">
            <label for="porg">ორგანიზაცია: </label>
        </div>
        <div class="right_fields">
            <input type="text" name="person_organisation" class="text_field widefield"
                   id="porg" value="<?php echo $person['organisation']; ?>" />            
        </div>
    </div>

    <div class="block group" style="border-bottom:0px;">
        <div class="left_labels">
            <label>ენები: <span class='required'>*</span></label>
        </div>
        <?php
        /*$langs = unserialize($person['languages']);
        $langs = empty($langs) ? array() : $langs;
        $c1 = in_array("Georgian", $langs) ? "checked" : NULL;
        $c2 = in_array("English", $langs) ? "checked" : NULL;
        $c3 = in_array("Russian", $langs) ? "checked" : NULL;*/
        ?>
        <div class="right_fields">
        	<?php 	        		       		        		        						
        		foreach ( $default_languages as $language ): 
        			if ( $person['languages'] != null )        			
        				$checked = Controller_People::in_array_rec($language['id'],$person['languages']) ? 'checked="checked"' : null;
        			else $checked = null;
        	?>
        		
        		<input type="checkbox" name="person_languages[]" class="text_field"
                   id="p<?php echo $language['language'] ?>" <?php echo $checked ?> value="<?php echo $language['id'] ?>" />
            	<label class="personLangLabel" for="p<?php echo $language['language'] ?>"><?php echo $language['language'] ?></label>      	
        	<?php endforeach;
    	        	if ( is_array($person['languages']) ):
						foreach ($person['languages'] as $index => $value):
							if ( $index%3 == 0 )
								echo "<br />";
							if ( Controller_People::in_array_rec($value['language'],$default_languages) )
								unset($person['languages'][$index]);					
							else{ 						
								?>					
								<input type="checkbox" name="person_languages[]" class="text_field"
				           id="p<?php echo $value['language'] ?>" checked="checked" value="<?php echo $value['id'] ?>" />
				    			<label class="personLangLabel" for="p<?php echo $value['language'] ?>"><?php echo $value['language'] ?></label>      							
							<?
							}
						endforeach;
					endif;
				
				?>
            
            <label id="show_other_languages" style="cursor: pointer; margin-top: 13px; display: block;"
                   onclick="$('#otherlanguagediv').toggle();$('#potherlanguage').attr('name', 'person_languages[]');$($('#form_person div.group')[15]).css('border-bottom',0);">
                &nbsp;&nbsp;&nbsp;სხვა
            </label>
        </div>
        
    </div>

    <div class="block group" style="display:none;border:0px;" id="otherlanguagediv">
        <div class="left_labels">
            <label></label>
        </div>

        <div class="right_fields">
			    გთხოვთ მიუთითოთ: <input type="text" class="text_field" id="potherlanguage" />
			    <button id="other-lang">შენახვა</button>
        </div>
    </div>		

    <?php /* <div class="block group">
        <div class="left_labels">
            <label for="datepicker2">გაწევრიანების თარიღი: </label>
        </div>

        <div class="right_fields">
            <input type="text" id="datepicker2" class="text_field widefield" name="person_becoming_member_date"
                   value="<?php echo $person['becoming_member_date']; ?>" style="width:98%" />
        </div>
    </div> */ ?>

    <div class="block group">
        <div class="left_labels">
            <label for="datepicker2">ოფისი: </label>
        </div>

        <div class="right_fields">
            <select name='person_office' class='widefield'>
                <?php
                foreach ($offices as $office):
                    $s = (isset($person['office_id']) AND !empty($person['office_id']) AND $person['office_id'] == $office['id']) ? "selected='selected'" : NULL;
                    ?>
                    <option <?php echo $s ?> value='<?php echo $office['id'] ?>'>
                        <?php echo $office['name'] . " (" . $office['address'] . ")" ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>
    </div>


    <div class="block group">
        <div class="left_labels">
            <label for="pphone">აქტივობის თარიღები: </label>
        </div>

        <div class="right_fields" style='width: 500px; text-align: center;'>
            <div style='text-align: right; margin-bottom: 13px;'>
                <?php
                if (!empty($affiliation) AND is_array($affiliation)):
                    foreach ($affiliation as $index => $aff):
                        $s = "selected='selected'";
                        ?>
                        <select name='person_affiliation_type[]'>
                            <option <?php ($aff['type'] == "staff") AND print($s); ?> value='staff'>წევრი</option>
                            <option <?php ($aff['type'] == "organisation") AND print($s); ?> value='organisation'>თანამშრომელი</option>
                        </select>&nbsp;&nbsp;&nbsp;
                				საიდან:
                        <input type="text" name="person_affiliation_from[]" class="text_field datepicker_max"
                               style='width:75px;margin-right:11px;margin-bottom:7px;' value='<?php echo $aff['from'] ?>' />
                				სადამდე:
                        <input type="text" name="person_affiliation_to[]" class="text_field datepicker_max" style="width: 75px"
                               value='<?php echo $aff['to'] ?>' />
                           <?php endforeach;
                       else: ?>
                    <select name='person_affiliation_type[]'>
                        <option value='staff'>წევრი</option>
                        <option value='organisation'>თანამშრომელი</option>
                    </select>&nbsp;&nbsp;&nbsp;
        				საიდან:
                    <input type="text" name="person_affiliation_from[]" class="text_field datepicker_max"
                           style='width: 75px; margin-right: 11px; margin-bottom: 7px;' />
        				სადამდე:
                    <input type="text" name="person_affiliation_to[]" class="text_field datepicker_max" style="width: 75px;" />
                <?php endif; ?>
            </div>
            <span style='cursor: pointer; display: inline-block; float:right;' id='another_affiliation'>
			    	+დამატება&nbsp;
            </span>
        </div>
    </div>

    <div class="block group">
        <div class="left_labels">
            <label for="pref">რეკომენდატორი: </label>
        </div>

        <div class="right_fields">
            <input type="text" id="pref" class="text_field widefield" name="person_reference"
                   value="<?php echo $person['reference']; ?>" />
        </div>
    </div>

    <?php /* <div class="block group">
        <div class="left_labels">
            <label for="pinterested">ინტერესები: </label>
        </div>

        <div class="right_fields">
            <?php
            $person_interests = unserialize($person['interested_in']);
            $person_interests = (!$person_interests) ? array() : $person_interests;
            foreach ($interests as $interest):
                $c = in_array($interest, $person_interests) ? "checked" : NULL;
                echo "
				<input type='checkbox' value='" . $interest . "' name='person_interested[]' id='" . $interest . "' " . $c . ">
					<label for='" . $interest . "'>" . $interest . "</label>
					<br />
				";
            endforeach;
            foreach ($person_interests as $interest):
                if (!in_array($interest, $interests) && $interest != "")
                    echo "
				<input type='checkbox' value='" . $interest . "' name='person_interested[]' id='" . $interest . "' checked>
					<label for='" . $interest . "'>" . $interest . "</label>
					<br />
				";
            endforeach;
            ?>
            </select>
            <br />
            <label style="cursor:pointer"
                   onclick="$('#otherinteresteddiv').toggle();$('#potherinterest').attr('name', 'person_interested[]')">
                &nbsp;&nbsp;&nbsp;სხვა
            </label>
        </div>
    </div> */ ?>

    <div class="block group" style="display:none;" id="otherinteresteddiv">
        <div class="left_labels">
            <label></label>
        </div>

        <div class="right_fields">
		გთხოვთ მიუთითოთ: <input type="text" class="text_field" id='potherinterest' />
        </div>
    </div>


    <div class="block group" id="otherinteresteddiv">
        <div class="left_labels">
            <label for='pcomment'>კომენტარი</label>
        </div>

        <div class="right_fields">
            <textarea style='height: 70px; color: black;' class="text_field widefield" id='pcomment' name='person_comment'><?php empty($person['comment']) OR print($person['comment']); ?></textarea>
        </div>
    </div>






    <div class="block last">
        <input type="submit" value="შენახვა" class="text_field" id="new_post_submit" />
    </div>

</form>

<?php unset($_SESSION['message'], $_SESSION['errors']); ?>
