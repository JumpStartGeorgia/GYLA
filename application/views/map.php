<div id='event_switcher'>
    <a class='switch' href='<?php echo URL::site('events/index') ?>'>სია</a>
    <a class='switch switched' href='<?php echo URL::site('events/map') ?>'>რუკა</a>
    <a class='switch' href='<?php echo URL::site('events/calendar') ?>'>კალენდარი</a>
</div>


<br/><br/>


<center>

    <div id="map">
        <div id="map-info"></div>
    </div>

</center>

<script type="text/javascript">

    var places = [<?php echo $coordinates ?>];

    window.onload = map_init();

</script>
