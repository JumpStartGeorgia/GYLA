<div class="group">
    <a id="filter_text"></a>
    <a id="filter_photo"></a>
    <a id="filter_video"></a>
    <a id="filter_document"></a>
</div>
<div id="new_post" class="post_text group">
    <?php
    foreach ($forms as $form)
        echo $form;
    ?>
</div>

<div id="all_posts" class="group">
    <?php
    if (!empty($posts)):
        $number_of_posts_on_this_page = count($posts);
        foreach ($posts as $index => $post):

            $display = "block";
            if ($index > 4 AND !$show)
                $display = "none";

            if ($post['type'] == "text")
            {
                $class = "post_text";
                $divstart = $divend = "";
            }
            elseif ($post['type'] == 'video')
            {
                $class = "post_" . $post['type'];
                $divstart = "<div class='post_left'>
					" . $post['embed_code'] . "
				     </div>
	    			     <div class='post_right'>";
                $divend = "</div>";
            }
            else
            {
                $cls = NULL;
                if ($post['type'] != "photo")
                {
                    $imgurl = URL::base() . 'images/images/document_attachment.png';
                    if (substr($post['attachment_url'], 0, 7) == "http://")
                        $fileurl = $post['attachment_url'];
                    else
                        $fileurl = URL::base() . $post['attachment_url'];
                    //$fileurl = '';
                }
                else
                {
                    if (substr($post['attachment_url'], 0, 7) == "http://")
                        $imgurl = $post['attachment_url'];
                    else
                        $imgurl = URL::base() . $post['attachment_url'];
                    $fileurl = $imgurl;
                    $cls = ' class="single_image"';
                }
                $class = "post_" . $post['type'];
                $divstart = "<div class='post_left'>
					<a{$cls} href='" . $fileurl . "' target=\"_blank\"><img src='" . $imgurl . "' class='rounded_image' alt='' /></a>
				    </div>
	    			     <div class='post_right'>";
                $divend = "</div>";
            }
            ?>
            <a name="post-<?php echo $post['id'] ?>"></a>
            <div class="<?php echo $class ?> group wall-post" style="display: <?php echo $display ?>" id="postbox<?php echo $index ?>">
                <div class="group">
                    <?php echo $divstart; ?>
                    <p class="post_title"><?php echo $post['title'] ?></p>
                    <p class="post_info">
                        <img src="<?php echo URL::base() ?>/images/images/user.png" />
                        <a href='<?php echo URL::site('people/view/' . $post['user_id']) ?>' class='userprofilelink'><?php
            $name = NULL;
            if (!empty($post['first_name']))
                $name .= $post['first_name'];
            if (!empty($post['last_name']))
                $name .= ' ' . $post['last_name'];
            if (empty($post['first_name']) AND empty($post['last_name']))
                $name = $post['username'];
            echo $name;
                    ?></a>&nbsp;&nbsp;
                        <img src="<?php echo URL::base() ?>/images/images/data_time.png" class="fiximage" />
                        <abbr title="<?php echo $post['published_at'] ?>"><?php echo fuzzy_span_geo(strtotime($post['published_at'])) ?></abbr>
                    </p>

                    <div class="post_body">
                        <?php echo Text::auto_link($post['body']) ?>
                    </div>

                    <?php $delete_button = $allow_delete ? "<a href='" . URL::site('post/delete/' . $post['id']) . "' class='edit_button' style='color: #fff;padding-bottom:2px;'>წაშლა</a>" : NULL; ?>

                    <div class='link_comment'><?php echo $delete_button ?></div>
                    <a class="link_reply" onclick="get_comments(<?php echo $post['id'] . ",'" . URL::base() . "'" ?>);">
                        <img src="<?php echo URL::base() ?>images/images/comment.png" />
                        <?php echo $post['total_comments'] ?> კომენტარი
                    </a>

                    <?php
                    echo $divend . "
	 	</div>
	 	<center>
	 	    <img id='loading-post-{$post['id']}' style='display: none' src='" . URL::base() . "/images/images/ajax-loader.gif' />
	 	</center>
	 	<div id='comments" . $post['id'] . "' class='comments group'></div>
	</div>";

                endforeach;

                $pages = ($total_posts % 10 == 0) ? $total_posts / 10 : ($total_posts - $total_posts % 10 + 10) / 10;
                $show_more_button = !$show AND ($pages != $current_page OR ($pages == $current_page AND $pages == 1) OR
                        ($number_of_posts_on_this_page > 5));
                $show_pages = ($show AND !$show_more_button);

                if ($show_more_button AND !empty($posts) AND count($posts) > 5)
                    echo "<div id='wall-more' class='group'>მეტი...</div>";
                ?>

                <center>
                    <img id='wall-loader' style='margin-top:20px;display:none' src='<?php echo URL::base() ?>/images/images/ajax-loader.gif' />
                    <div id='pager' class='group'<?php $show_pages AND print 'style="display: block"' ?>>
                        <?php
                        if ($current_page > 5):  //first page
                            $show_first = TRUE;
                            ?>
                            <a href='<?php echo URL::site('wall/index/1') ?>'>პირველი</a>
                            <?php
                        endif;
                        if ($current_page != 1 AND (empty($show_first) OR !$show_first)):  //previous page
                            ?>
                            <a href='<?php echo URL::site('wall/index/' . ($current_page - 1)) ?>'><?php //echo htmlentities("<");   ?>წინა</a>
                            <?php
                        endif;
                        for ($i = 1; $i <= $pages; $i++):      //pages
                            echo ($current_page == $i) ? "<span id='nonlink'>" . $i . "</span> " : "<a href='" . URL::site('wall/index/' . $i) . "'>" . $i . "</a> ";
                            if ($i > 5):
                                $show_last = TRUE;
                                continue;
                            endif;
                        endfor;
                        if ($current_page != $pages AND (empty($show_last) OR !$show_last)):  //next page
                            ?>
                            <a href='<?php echo URL::site('wall/index/' . ($current_page + 1)) ?>'>შემდეგი<?php //echo htmlentities(">");   ?></a>
                            <?php
                        endif;
                        if (!empty($show_last) AND $show_last AND $current_page != $pages):  //last page
                            ?>
                            <a href='<?php echo URL::site('wall/index/' . $pages) ?>'>ბოლო</a>
                            <?php
                        endif;
                        ?>
                    </div>
                </center>

            <?php else: ?>
                <center>კედელი ცარიელია...</center>
            <?php endif; ?>

        </div>
