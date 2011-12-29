<div id='event_switcher'>
    <a class='switch' href='<?php echo URL::site('events/index') ?>'>სია</a>
    <a class='switch' href='<?php echo URL::site('events/map') ?>'>რუკა</a>
    <a class='switch switched' href='<?php echo URL::site('events/calendar') ?>'>კალენდარი</a>
</div>

<br /><br />

<div style='float:left;'>
    <select id='yearselect' onchange='window.location.href = baseurl + "events/calendar/" + $(this).val() + "-" + $("#monthselect").val();'><?php
foreach ($event_years AS $year)
    echo '<option value="' . $year . '"' . ($now['year'] == $year ? ' selected="selected"' : NULL) . '>' . $year . '</option>';
?></select>

    &nbsp;

    <select id='monthselect' onchange='window.location.href = baseurl + "events/calendar/" + $("#yearselect").val() + "-" + $(this).val();'>
        <?php
        $months = array(
            NULL,
            "იანვარი",
            "თებერვალი",
            "მარტი",
            "აპრილი",
            "მაისი",
            "ივნისი",
            "ივლისი",
            "აგვისტო",
            "სექტემბერი",
            "ოქტომბერი",
            "ნოემბერი",
            "დეკემბერი"
        );

        for ($month = 1; $month <= 12; $month++):
            $month_name = $months[$month];
            $sel = ($now['month'] == $month) ? " selected='selected'" : NULL;
            ($month < 10) AND $month = "0" . $month;
            ?>
            <option value='<?php echo $month ?>'<?php echo $sel ?>><?php echo $month_name; ?></option>
            <?php
        endfor;
        ?>
    </select>
</div>

<h3 style='margin:6px 0 17px 77px;padding:0; display:inline-block;' class='group'>

    <?php
    $prev = ($now['month'] == 1) ? ($now['year'] - 1) . '-' . '12' : $now['year'] . '-' . ($now['month'] - 1);
    $next = ($now['month'] == 12) ? ($now['year'] + 1) . '-' . '1' : $now['year'] . '-' . ($now['month'] + 1);
    $prev = URL::site('events/calendar/' . $prev);
    $next = URL::site('events/calendar/' . $next);

    if ($now['year'] >= 2000):
        ?>
        <a href='<?php echo $prev ?>' style='text-decoration:none; color: #0000ee;'>◀</a>&nbsp;
        <?php
    endif;
    ?>
    <?php echo $current_date ?>&nbsp;
    <?php if ($now['year'] <= 2050): ?>
        <a href='<?php echo $next ?>' style='text-decoration:none; color: #0000ee;'>▶</a>
    <?php endif; ?>

</h3>

<a href='<?php echo URL::site('events/calendar/' . date("Y-m")) ?>' style='text-decoration:none; margin-top: 6px; float:right; color: #343673;'>
	დღევანდელი თარიღი
</a>

<?php
echo $calendar;
?>
