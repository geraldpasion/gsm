<?php
include 'functions.php';

$tablename=$_GET['table_name'];
$id=$_GET['id'];

//get table fields
$field_name=get_column_names($tablename);

$row_values=[]; //prepare an array
$row_values=select_row($id,$tablename);

//foreach ($field_name as $col)
//	echo $col.'<br>';

//get row values using id

echo $tablename;

//start form
echo '<div>';
echo '<form action="../update_form.php?tablename='.$tablename.'&id='.$id.'" method="post">';
echo '<table>';

for($i=0; $i<count($row_values); $i++){

	$col=$field_name[$i];

	if($field_name[$i]=='ID'){
		//do nothing
	}
	else if($field_name[$i]=='Letter_Code' || $field_name[$i]=='Date'){
		echo '<tr><td>'.$field_name[$i].': </td><td><input type="text" name="'.$field_name[$i].'" value='.$row_values[$i].' readonly="readonly"></td></tr>';
	}
	else if($col=='Department' || $col=='Account_Type'){
		$dropdown_string=generate_dropdown($col,strtolower($col));
		echo '<tr><td>'.$col.': </td><td>'.$dropdown_string.'</td><tr>';
	}
	else if ($col=='table_assigned'){
		$dropdown_string=list_tables_dropdown($col,$row_values[$i]);
		echo '<tr><td>'.$col.': </td><td>'.$dropdown_string.'</td><tr>';
	}
	else if ($col=='Status'){
		$status_dropdown_results=status_generator($tablename,$row_values[$i]);
		echo '<tr><td>'.$col.': </td><td>'.$status_dropdown_results.'</td></tr>';
	}
	else
		echo '<tr><td>'.$field_name[$i].': </td><td><input type="text" name="'.$field_name[$i].'" value="'.$row_values[$i].'""></td></tr>';

}

echo '<td colspan="2"><input type="submit"></td>';
echo '</table>';
echo '</form>';
echo '</div>';
?>