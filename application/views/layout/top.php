
<a href="<?php echo URL::site('people/view/' . $_SESSION['userid']) ?>" id="profile"><img src="<?php echo URL::base() ?>images/images/user.png" /> პროფილი</a>

<?php if (!empty($is_admin) && $is_admin): ?>
    <span id="splitter"> | </span>
    <a href="<?php echo URL::site('admin') ?>" id="panel">ადმინისტრირება</a>
<?php endif; ?>

<a href="<?php echo URL::site('user/logout') ?>" id="logout"><img src="<?php echo URL::base() ?>images/images/logout.png" class="fiximage" /> გასვლა</a>

</div>

<div id="menu" class="group">

    <div id="menu_items">
        <a href="<?php echo URL::base(); ?>"" class="menuitem">კედელი</a>

        <a href="<?php echo URL::site('events'); ?>" class="menuitem">მოვლენები</a>

        <a href="<?php echo URL::site('people'); ?>" class="menuitem">წევრები/თანამშრომლები</a>

        <a href="<?php echo URL::site('offices'); ?>" class="menuitem" style="margin: 0px;">ოფისები</a>

    </div>

    <script type='text/javascript'>
        $(document).ready(function(){
            var keyword;
            function redirect_to_search()
            {
                window.location = "<?php echo URL::site('search/index') ?>/" + keyword;
                return false;
            };
            $('#search_box').change(function(){
                keyword = $(this).val();
            }).keypress(function(event){
                keyword = $(this).val();
                var code = event.keyCode ? event.keyCode : event.which;
                code == 13 && redirect_to_search();
            });
            $('#search_submit_button').click(redirect_to_search);
        });
    </script>

    <div id="search">
        <input type='text' name="keyword" id="search_box" value="<?php echo empty($search_keyword) ? 'ძიება...' : $search_keyword ?>" class="text_field" onfocus="if(this.value == 'ძიება...') this.value=''" onblur="if(this.value == '') this.value = 'ძიება...';" />
        <input type='submit' id="search_submit_button" style="background: url('<?php echo URL::base() ?>images/images/submit_button.png') no-repeat; width: 16px; height: 15px; border: 0 none; cursor: pointer" value="" />
    </div>
