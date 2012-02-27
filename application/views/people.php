<?php
	echo $search_form;		
?>
<div class="post_text">

<?php
    $num = count($people) - 1;

    if (empty($message) OR !$message)
    {
        foreach ($people as $index => $person):
            $edit_button = $allow_edit ? "<a href='" . URL::site('people/edit/' . $person['id']) . "' class='edit_button' style=\"margin-right: 5px\">შეცვლა</a>" : NULL;
            $dele_button = $allow_dele ? '<a href="' . URL::site('people/delete/' . $person['id']) . '"  class="edit_button confirmdel" style="margin-right: 5px">წაშლა</a>' : NULL;
            $trans_button = $allow_transactions ? '<a href="' . URL::site('transactions/user/' . $person['id']) . '" class="edit_button">ტრანზაქციები</a>' : NULL;
            $profile = URL::site('people/view/' . $person['id']);

            $nbmp = ($index == $num) ? " style='border: 0; margin-bottom: 0; padding-bottom: 0;'" : NULL; ?>

            <div class="b-block group"<?php echo $nbmp ?>>
                <div class="b-block-header group">
                    <a class="b-block-title" href="<?php echo $profile ?>">
			<?php echo $person['first_name'] . ' ' . $person['last_name'] ?>
		    </a>
                    <?php echo $trans_button . $dele_button . $edit_button; ?>
                </div>
            </div><?php

        endforeach;
    }
    else
    {
        echo $message;
    }
?>

</div>
