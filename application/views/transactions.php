<div class="post_text">

    <div style="width: 100%; text-align: center; font-size: 18px; font-weight: bold; margin-bottom: 25px;">
	<a style="color: #3B417F; text-decoration: none;" href="<?php echo URL::site('people/view/' . $userid); ?>"><?php echo $fullname; ?></a> - ტრანზაქციები
    </div>

    <?php
    $num = count($tas) - 1;

    if ($num != -1)
    { ?>
    <table id="transactions_list">
	<tr>
	    <th style="border-left: 0;">თარიღი</th>
	    <th style="">ტრანზაქცია</th>
	    <th style="border-right: 0;"></th>
	</tr>
    <?php
      foreach ($tas as $index => $ta):
        $nb = NULL;//($index == $num) ? ' border-bottom: 0 none;' : NULL;
        $minus = ($ta['amount'] < 0);
        $ta['amount'] >= 0 and $ta['amount'] = '+' . $ta['amount'];
    ?>
	<tr>
	    <td style="border-left: 0;<?php echo $nb; ?>"><?php echo $ta['paydate']; ?></td>
	    <td class="<?php echo $minus ? 'am_red' : 'am_green'; ?>" style="text-align: right;<?php echo $nb; ?>">
		<?php echo $ta['amount']; ?> ლ.
	    </td>
	    <td style="border-right: 0;<?php echo $nb; ?>"><?php if (!$minus): ?>
		<a href="<?php echo URL::site('transactions/delete/' . $ta['id'] . '-' . $userid); ?>"
		   onclick="return confirm(\'Are you sure?\');" class="edit_button">წაშლა</a>
	    <?php endif; ?></td>
	</tr>
    <?php
      endforeach; ?>
	</table>
	<div style="font-size: 15px; width: 100%; text-align: right; margin: 19px 0px;">ბალანსი: <span class="<?php echo ($balance < 0) ? 'am_red' : 'am_green'; ?>"><?php echo $balance; ?> ლარი</span></div>
    <?php }
    else
	echo '<div class="b-block group" style="text-align: center;">სია ცარიელია</div>';
    ?>
    <form action="<?php echo URL::site('transactions/create/' . $userid) ?>" method="post">

	<table id="new_ta_form">
	    <tr>
		<th>თარიღი:</th>
		<th>რაოდენობა:</th>
	    </tr>
	    <tr>
		<td><input type="text" class="text_field datepicker" name="paydate" /></td>
		<td><input type="text" class="text_field" name="amount" /></td>
		<td><input type="submit" value="დამატება" class="text_field" id="new_post_submit" /></td>
	    </tr>
	</table>
    </form>
</div>
