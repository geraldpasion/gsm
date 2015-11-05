<?php

include 'connect.php';
include 'functions.php';
$tablename='companies';

$extra_fields = '';
//option to add new
add_new_entry($tablename);

echo '<div>';
echo '<table>';

	select_all($tablename, 0, $extra_fields);
echo '</table>';
echo '</div>';
?>

