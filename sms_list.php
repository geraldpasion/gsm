<?php

include 'connect.php';
include 'functions.php';
$tablename='sms';

$extra_fields = 'Actions';
//option to add new
add_new_entry($tablename);

echo '<div>';
echo '<table>';

	select_all($tablename, 3, $extra_fields);
echo '</table>';
echo '</div>';
?>

