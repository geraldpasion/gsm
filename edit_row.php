<?php
include 'functions.php';

$tablename=$_GET['table_name'];
$id=$_GET['id'];

//get table fields
$field_name=get_column_names($tablename);

//foreach ($field_name as $col)
//	echo $col.'<br>';

//start form
echo '<div>';
echo '<form action="../update_form.php?tablename='.$tablename.'" method="post">';
echo '<table>';
//generate text boxes
foreach ($field_name as $col){

	//echo $col.'<br>';]
	if($col=='ID'){
		//do nothing
	}		
	else if($col=='Department' || $col=='Status'){
		$dropdown_string=generate_dropdown($col,strtolower($col));
		echo '<tr><td>'.$col.': </td><td>'.$dropdown_string.'</td><tr>';
	}
	else
		echo '<tr><td>'.$col.': </td><td><input type="text" name="'.$col.'"></td><tr>';
}
echo '<td colspan="2"><input type="submit"></td>';
echo '</table>';
echo '</form>';
echo '</div>';
?>