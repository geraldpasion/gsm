<?php

include 'connect.php';
include 'functions.php';
$tablename='with_po';

$extra_fields = 'Actions';
//option to add new
add_new_entry($tablename);

echo '<div>';
echo '<table>';

	select_all($tablename, 4, $extra_fields);
echo '</table>';
echo '</div>';

list_tables();
?>

