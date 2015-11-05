<?php

include 'connect.php';
include 'functions.php';
$tablename='Account_Types';

$extra_fields = 'Actions';
//option to add new
add_new_entry($tablename);

echo '<div>';
echo '<table>';

	select_all($tablename, 0, $extra_fields);
echo '</table>';
echo '</div>';
?>

