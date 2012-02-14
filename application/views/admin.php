<div id="panel" class="post_text">
    <table>
        <tr>
            <?php if (in_array(TRUE, $people)): ?>
            <td>
                <h3>წევრები/თანამშრომლები და ძებნა</h3>
                <ul>
                    <?php if ($people['add']): ?>
			<li><a href="<?php echo URL::site('people/new') ?>">პიროვნების დამატება</a></li>
                    <?php endif;
                    if ($people['view']): ?>
			<li><a href="<?php echo URL::site('people') ?>">წევრების/თანამშრომლების სია</a></li>
                    <?php endif;
                    if ($people['search']): ?>
			<li><a href="<?php echo URL::site('people/searches') ?>">შენახული ძებნის პარამეტრების სია</a></li>
                    <?php endif; ?>
                </ul>
            </td>
            <?php endif;
            if (in_array(TRUE, $events)): ?>
            <td>

                <h3>მოვლენები და კალენდარი</h3>
                <ul>
                    <?php if ($events['add']): ?>
			<li><a href="<?php echo URL::site('events/new') ?>">მოვლენის დამატება</a></li>
		    <?php endif;
		    if ($events['view']): ?>
			<li><a href="<?php echo URL::site('events') ?>">მოვლენების სია</a></li>
		    <?php endif;
		    if ($events['calendar']): ?>
			<li><a href="<?php echo URL::site('events/calendar') ?>">კალენდარი</a></li>
		    <?php endif;
		    if ($events['map']): ?>
			<li><a href="<?php echo URL::site('events/map') ?>">რუკა</a></li>
		    <?php endif; ?>
                </ul>
            </td>
            <?php endif; ?>
        </tr>
        <tr>
	    <?php if ($admin): ?>
                <td>
			<h3>მომხმარებელთა ჯგუფები</h3>
			<ul>
				<li><a href="<?php echo URL::site('groups/new') ?>">ჯგუფის დამატება</a></li>
				<li><a href="<?php echo URL::site('groups') ?>">ჯგუფების სია</a></li>
			</ul>
		</td>
	    <?php endif;
	    if (in_array(TRUE, $offices)): ?>
            <td colspan="2">
                <h3>ოფისების მართვა</h3>
                <ul>
                    <?php if($offices['add']): ?>
			<li><a href="<?php echo URL::site('offices/new') ?>">ოფისის დამატება</a></li>
                    <?php endif;
                    if($offices['view']): ?>
			<li><a href="<?php echo URL::site('offices') ?>">ოფისების სია</a></li>
                    <?php endif; ?>
                </ul>
            </td>
            <?php endif; ?>
        </tr>
        <?php if ($admin): ?>
        <tr style='border: 0;'>
                <td>
			<h3>ტრანზაქციები</h3>
			<ul>
				<li><a href="<?php echo URL::site('transactions/billing') ?>">დავალიანებების სია</a></li>
			</ul>
		</td>
        </tr>
        <?php endif; ?>
    </table>
</div>
