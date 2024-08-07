<?php
include_once "db_connection.php";
include_once "includes/functions.php";
/*echo "<div id='light-nav-bar'><h1><?php getSettingValue('home_light_nav_bar_title'); ?></h1>
</div>";
*/
?>
<div id='light-nav-bar'>
    <h1><?php echo getSettingValue('home_light_nav_bar_title'); ?></h1>
    <h3><?php echo getSettingValue('home_light_nav_bar_desc'); ?></h3>
</div>