<div id='all_posts'>
<?php
    $results_exist = FALSE;

    if(!empty($results['posts'])):
    	    $num = count($results['posts']) - 1;
    	    $results_exist = TRUE;
?>
	    <div class='post_text group' style='padding-bottom: 13px;'>
	    	<p class='search_results_title'>პოსტები</p>
<?php
	    foreach ($results['posts'] as $index => $post):

		$nbmp = ($index == $num) ? " style='border: 0; margin: 0; '" : NULL;

		$link_to_post = URL::site('wall/index/' . $post['page'] . "/show#post-" . $post['id']);
		echo "
			<a href='" . $link_to_post . "' class='search_result'".$nbmp.">" . $post['title'] . "</a>
		";

	    endforeach;
?>
	    </div>
<?php
    endif;

    if(!empty($results['events'])):
    	    $num = count($results['events']) - 1;
    	    $results_exist = TRUE;
?>
	    <div class='post_text group' style='padding-bottom: 13px;'>
	    	<p class='search_results_title'>მოვლენები</p>
<?php
	    foreach ($results['events'] as $index => $event):

		$nbmp = ($index == $num) ? " style='border: 0; margin: 0; '" : NULL;

		$link_to_event = URL::site('events/view/' . $event['id']);
		echo "
			<a href='" . $link_to_event . "' class='search_result'".$nbmp.">" . $event['name'] . "</a>
		";

	    endforeach;
?>
	    </div>
<?php
    endif;

    if(!$results_exist):
?>
	    <div class='post_text group'>
	    	<p class='search_results_title'>არაფერი მოიძებნა :((</p>
	    </div>
<?php
    endif;
?>
</div>
