<div class="post_text">
<? //print_r($person);die; ?>
    <?php
    (strrpos($person['member_of'], ',') == strlen($person['member_of']) - 1) AND $person['member_of'] = substr($person['member_of'], 0, -1);
    $member = explode(',', $person['member_of']);

    $edit_button = $allow_edit ? "<a href='" . URL::site('people/edit/' . $person['id']) . "' class='edit_button'>შეცვლა</a>" : NULL;
    $trans_button = $allow_transactions ? '<a href="' . URL::site('transactions/user/' . $person['id']) . '" style="margin-right: 15px;" class="edit_button">ტრანზაქციები</a>' : NULL;
    ?>
    <div class='b-block group' style='border:0; margin: 0;'>

        <div class="b-block-header group" style="text-align: left;">
            <div class='b-block-title' style="text-align: center;"><?php echo $person['first_name'] . " " . $person['last_name']; ?></div>
            <?php echo $edit_button . $trans_button; ?>
        </div>

	<?php /*
        <div class='b-block-left group'>
            <div class='small-spacer'></div>
	    მომხმარებელი
            <div class='small-spacer'></div>
	    სქესი
            <hr class='splitter-left' />
	    დაბადების თარიღი
            <hr class='splitter-left' />
	    სტატუსი
            <hr class='splitter-left' />
	    მისამართი
            <hr class='splitter-left' />
            <?php
            if (!empty($phones) AND is_array($phones))
                foreach ($phones as $phone):
                    switch ($phone['type']):
                        case "home":
                            echo "სახლის ტელეფონი";
                            break;
                        case "mobile":
                            echo "მობილური ტელეფონი";
                            break;
                        case "work":
                            echo "სამსახურის ტელეფონი";
                            break;
                    endswitch;
                    ?>
                    <hr class='splitter-left' />
                <?php endforeach; ?>
	    ელფოსტა
            <hr class='splitter-left' />
	    ოფისი
            <hr class='splitter-left' />
	    ოფისის მისამართი
            <hr class='splitter-left' />
	    პირადი ნომერი
            <hr class='splitter-left' /> 
	    ორგანიზაცია
            <hr class='splitter-left' />
	    თანამდებობა
            <hr class='splitter-left' />
	    ენები
            <hr class='splitter-left' /> 

            <?php
            $is_first_staff = $is_first_org = TRUE;
            if (!empty($affiliation) AND is_array($affiliation)):
                foreach ($affiliation as $aff):
                    if ($is_first_staff AND $aff['type'] == "staff"):
                        $is_first_staff = FALSE;
                        echo "წევრობის აქტივობის თარიღები";
                    endif;
                    if ($is_first_org AND $aff['type'] == "organisation"):
                        $is_first_org = FALSE;
                        echo "თანამშრომლობის აქტივობის თარიღები";
                    endif;
                    echo "<hr class='splitter-left' />&nbsp;";
                endforeach;
            endif;
            ?>

	    რეკომენდატორი
        </div> 

        <div class='b-block-right group'>
            <div class='small-spacer'></div>
            <?php echo empty($person['username']) ? ' ― ' : $person['username'] ?>
            <div class='splitter-right'></div>
            <?php echo empty($person['sex']) ? ' ― ' : strtr($person['sex'], array('female' => 'მდედრობითი', 'male' => 'მამრობითი')) ?>
            <hr class='splitter-right' />
            <?php echo empty($person['birth_date']) ? ' ― ' : $person['birth_date'] ?>
            <hr class='splitter-right' />
            <?php echo empty($person['member_of']) ? ' ― ' : str_replace(',', ', ', $person['member_of']) ?>
            <hr class='splitter-right' />
            <?php echo empty($person['address']) ? ' ― ' : $person['address'] ?>
            <hr class='splitter-right' />
            <?php
            if (!empty($phones) AND is_array($phones))
                foreach ($phones as $phone):
                    echo $phone['number'];
                    ?>
                    <hr class='splitter-left' />
                <?php endforeach; ?>
            <?php echo empty($person['email']) ? ' ― ' : $person['email'] ?>
            <hr class='splitter-right' />
            <?php echo empty($person['office_name']) ? ' ― ' : $person['office_name'] ?>
            <hr class='splitter-right' />
            <?php echo empty($person['office_address']) ? ' ― ' : $person['office_address'] ?>
            <hr class='splitter-right' />
            <?php echo empty($person['personal_number']) ? ' ― ' : $person['personal_number'] ?>
            <hr class='splitter-right' />
            <?php echo empty($person['organisation']) ? ' ― ' : $person['organisation'] ?>
            <hr class='splitter-right' />
            <?php echo empty($person['position']) ? ' ― ' : $person['position'] ?>
            <hr class='splitter-right' />
            <?php
		if (!is_array($person['languages'])):
		    echo ' ― ';
		else:
		    $lang = array();
		    foreach ($person['languages'] as $lng) 
			$lang[] = $lng['language'];            
		    echo implode(', ', $lang);
		endif;
            ?>
            <hr class='splitter-right' />

            <?php
            if (!empty($affiliation) AND is_array($affiliation))
                foreach ($affiliation as $aff):
                    echo $aff['from'] . " - " . $aff['to']
                    ?>
                    <hr class='splitter-right' />
            <?php
		endforeach;
            echo (empty($person['reference']) ? ' ― ' : $person['reference']);
            ?>
        </div>
        */ ?>

	<table class="info_list" id="testid">

	    <tr>
		<td left>მომხმარებელი</td>
		<td right><?php echo empty($person['username']) ? ' ― ' : $person['username'] ?></td>
	    </tr>

	    <tr>
		<td left>სქესი</td>
		<td right>
		    <?php echo empty($person['sex']) ? ' ― ' : strtr($person['sex'], array('female' => 'მდედრობითი', 'male' => 'მამრობითი')) ?>
		</td>
	    </tr>

	    <tr>
		<td left>დაბადების თარიღი</td>
		<td right><?php echo empty($person['birth_date']) ? ' ― ' : Controller_People::reformat_date($person['birth_date']) ?></td>
	    </tr>

	    <tr>
		<td left>სტატუსი</td>
		<td right><?php echo empty($person['member_of']) ? ' ― ' : strtr($person['member_of'], array(',' => ', ', 'staff' => 'წევრი', 'organisation' => 'თანამშრომელი'))
		 ?></td>
	    </tr>

	    <tr>
		<td left>დოკუმენტი</td>
		<td right>
		<?php
		if (!empty($docs))
		    foreach ($docs as $doc): ?>
			<a class="document_link" style="float: none; padding: 0px;" target="_blank" href="<?php echo URL::site($doc['url']); ?>">
			    <?php echo substr(basename($doc['url']), 0, 21); ?>
			</a><?php
		    endforeach;
		else
		    echo ' ― ';
		?>
		</td>
	    </tr>

	    <tr>
		<td left>მისამართი</td>
		<td right><?php echo empty($person['address']) ? ' ― ' : $person['address'] ?></td>
	    </tr>

	    <?php
	    if (!empty($phones) AND is_array($phones)):
		$types = array('home' => 'სახლის ტელეფონი', 'mobile' => 'მობილური ტელეფონი', 'work' => 'სამსახურის ტელეფონი');
		foreach ($phones as $phone): ?>
		    <tr>
			<td left><?php echo $types[$phone['type']]; ?></td>
			<td right><?php echo $phone['number']; ?></td>
		    </tr>
		<?php endforeach;
	    endif;
	    ?>

	    <tr>
		<td left>ელფოსტა</td>
		<td right><?php echo empty($person['email']) ? ' ― ' : $person['email'] ?></td>
	    </tr>

	    <tr>
		<td left>ოფისი</td>
		<td right><?php echo empty($person['office_name']) ? ' ― ' : $person['office_name'] ?></td>
	    </tr>

	    <tr>
		<td left>ოფისის მისამართი</td>
		<td right><?php echo empty($person['office_address']) ? ' ― ' : $person['office_address'] ?></td>
	    </tr>

	    <tr>
		<td left>პირადი ნომერი</td>
		<td right><?php echo empty($person['personal_number']) ? ' ― ' : $person['personal_number'] ?></td>
	    </tr>

	    <tr>
		<td left>ორგანიზაცია</td>
		<td right><?php echo empty($person['organisation']) ? ' ― ' : $person['organisation'] ?></td>
	    </tr>

	    <tr>
		<td left>თანამდებობა</td>
		<td right><?php echo empty($person['position']) ? ' ― ' : $person['position'] ?></td>
	    </tr>

	    <tr>
		<td left>ენები</td>
		<td right>
		<?php
		    if (!is_array($person['languages'])):
			echo ' ― ';
		    else:
			$lang = array();
			foreach ($person['languages'] as $lng) 
			    $lang[] = $lng['language'];            
			echo implode(', ', $lang);
		    endif;
		?>
		</td>
	    </tr>

	    <?php
		$printed_staff = $printed_org = FALSE;
		if (!empty($affiliation['staff']) and is_array($affiliation['staff'])):
		    foreach ($affiliation['staff'] as $aff): ?>
			<tr>
			    <td <?php $printed_staff and print 'noborder'; ?> left>
			    <?php
				if (!$printed_staff):
				    echo 'წევრობის აქტივობის თარიღები';
				    $printed_staff = TRUE;
				endif;
			    ?>
			    </td>
			    <td right><?php echo $aff['from'] . " - " . $aff['to']; ?></td>
			</tr>
			<?php endforeach;
		endif;

		if (!empty($affiliation['organisation']) and is_array($affiliation['organisation'])):
		    foreach ($affiliation['organisation'] as $aff): ?>
			<tr>
			    <td <?php $printed_org and print 'noborder'; ?> left>
			    <?php
				if (!$printed_org):
				    echo 'თანამშრომლობის აქტივობის თარიღები';
				    $printed_org = TRUE;
				endif;
			    ?>
			    </td>
			    <td right><?php echo $aff['from'] . " - " . $aff['to']; ?></td>
			</tr>
			<?php endforeach;
		endif;
	    ?>

	    <tr>
		<td left>რეკომენდატორი</td>
		<td right><?php echo (empty($person['reference']) ? ' ― ' : $person['reference']); ?></td>
	    </tr>

	    <tr>
		<td noborder left>კომენტარი</td>
		<td noborder right><?php echo (empty($person['comment']) ? ' ― ' : $person['comment']); ?></td>
	    </tr>

	</table>



    </div>

</div>
