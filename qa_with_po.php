<?php

include 'connect.php';
include 'functions.php';
$tablename='with_po';

$extra_fields = 'QA Actions';
//option to add new
//add_new_entry($tablename);

echo '<div>';
echo '<table>';

	select_all($tablename, 3, $extra_fields);
echo '</table>';
echo '</div>';
?>

