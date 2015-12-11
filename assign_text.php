<?php

include 'functions.php';

$sms_id=$_GET['checkbox_values'];
$id=$_GET['hidden_id'];
$letter_code=$_GET['hidden_letter_code'];

foreach ($sms_id as $col)
	echo $col.'<br>';

echo "id: ".$id."<br>";
echo "letter_code: ".$letter_code."<br>";
$tablename='sms';

foreach ($sms_id as $row_id){
	$table_string='Reference_ID="'.$id.'", Letter_Code_Assigned="'.$letter_code.'"';
	echo "table_string: ".$table_string."<br>";
	update_statement($tablename,$table_string, $row_id );
}
header('Location: ' . $_SERVER['HTTP_REFERER']);

//update sms table if assigned



?>