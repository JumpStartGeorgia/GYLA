<div class="post_text">
<? //print_r($person);die; ?>
    <?php
    (strrpos($person['member_of'], ',') == strlen($person['member_of']) - 1) AND $person['member_of'] = substr($person['member_of'], 0, -1);
    $member = explode(',', $person['member_of']);

    $edit_button = $allow_edit ? "<a href='" . URL::site('people/edit/' . $person['id']) . "' class='edit_button'>შეცვლა</a>" : NULL;
    ?>
    <div class='b-block group' style='border:0; margin: 0;'>

        <div class='b-block-header group'>
            <div class='b-block-title'><?php echo $person['first_name'] . " " . $person['last_name']; ?></div>
            <?php echo $edit_button; ?>
        </div>

        <div class='b-block-left group'>
            <div class='small-spacer'></div>
	    მომსმარებელი
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
        <?php /*    <hr class='splitter-left' />
		წლები სკოლაში  */ ?>
            <hr class='splitter-left' /> 
	    ორგანიზაცია
            <hr class='splitter-left' />
	    თანამდებობა
            <hr class='splitter-left' />
	    ენები
        <?php /*    <hr class='splitter-left' />
		გაწევრიანების თარიღი  */ ?>
            <hr class='splitter-left' /> 

            <?php
            $is_first_staff = $is_first_org = TRUE;
            if (!empty($affiliation) AND is_array($affiliation))
                foreach ($affiliation as $aff):
                    if ($is_first_staff AND $aff['type'] == "staff"):
                        $is_first_staff = FALSE;
                        echo "შტატის აქტივობის თარიღები";
                    endif;
                    if ($is_first_org AND $aff['type'] == "organisation"):
                        $is_first_org = FALSE;
                        echo "ორგანიზაციის აქტივობის თარიღები";
                    endif;
                    echo "<hr class='splitter-left' />&nbsp;";
                endforeach;
            ?>

	    რეკომენდატორი
 <?php /* <hr class='splitter-left' />
	    ინტერესები */ ?>
        </div> 

        <div class='b-block-right group'>
            <div class='small-spacer'></div>
            <?php echo empty($person['username']) ? ' ― ' : $person['username'] ?>
            <div class='splitter-right'></div>
            <?php echo empty($person['sex']) ? ' ― ' : $person['sex'] ?>
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
            <?php /* <hr class='splitter-right' /> 
               echo empty($person['years_in_school']) ? ' ― ' : $person['years_in_school'] */ ?>
            <hr class='splitter-right' />
            <?php echo empty($person['organisation']) ? ' ― ' : $person['organisation'] ?>
            <hr class='splitter-right' />
            <?php echo empty($person['position']) ? ' ― ' : $person['position'] ?>
            <hr class='splitter-right' />
            <?php
            		
		        if ( !is_array($person['languages']) ):
		        	echo ' ― ';
		        else:
				    $lang = array();
				    foreach ( $person['languages'] as $lng ) 
				    	$lang[] = $lng['language'];            
				    echo implode(', ', $lang);
		        endif;            
			
				 /* <hr class='splitter-right' />
		         echo empty($person['becoming_member_date']) ? ' ― ' : $person['becoming_member_date'] */ 
            ?>
            <hr class='splitter-right' />

            <?php
            if (!empty($affiliation) AND is_array($affiliation))
                foreach ($affiliation as $aff):
                    echo $aff['from'] . " - " . $aff['to']
                    ?>
                    <hr class='splitter-right' />
                <?php endforeach; ?>

            <?php echo empty($person['reference']) ? ' ― ' : $person['reference'] ?>
            <?php /*<hr class='splitter-right' />
            
            $int = empty($person['interested_in']) ? NULL : unserialize($person['interested_in']);
            if (!empty($int) AND is_array($int))
                echo implode(', ', $int);
            else
                echo ' ― '; */
            ?>
        </div>

    </div>

</div>
