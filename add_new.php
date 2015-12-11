<?php
include 'functions.php';

$tablename=$_GET['tablename'];
$id=$_GET['id'];
//get table fields
$field_name=get_column_names($tablename);

//foreach ($field_name as $col)
//	echo $col.'<br>';

//start form
echo '<div>';
echo '<form action="../submit_form.php?tablename='.$tablename.'" method="post">';
echo $tablename;
echo '<table class="table table-hover table-responsive table-striped">';


//generate text boxes
foreach ($field_name as $col){

	//echo $col.'<br>';]
	if($col=='ID'){
		//do nothing
	}
	else if($col=='Letter_Code'){
		echo '<tr><td>'.$col.': </td><td>';
		$letter_code_val=get_letter_code($tablename);
		if($letter_code_val!='A'){
			$letter_code_val++;
		}
		echo '<input type="text" name="'.$col.'" value="'.$letter_code_val.'" readonly="readonly">';
		echo '</td><tr>';
	}		
	else if($col=='Department' || $col=='Account_Type' || $col=='Payment_Type'){
		
		if($tablename!='payment_type'){
			$dropdown_string=generate_dropdown($col,strtolower($col));
			echo '<tr><td>'.$col.': </td><td>'.$dropdown_string.'</td><tr>';
		}
		else
			echo '<tr><td>'.$col.': </td><td><input type="text" name="'.$col.'"></td><tr>';

	}
	else if($col=='profile_id'){
		echo '<tr><td>'.$col.': </td><td><input type="text" name="'.$col.'" value="'.$id.'"></td><tr>';
	}
	else if($col=='Date_Created' || $col=='Date' ){
		//generate date display
		echo '<tr><td>Date: </td><td>';
		echo date("Y-m-d");
		echo '</td></tr>';
	}
	else if ($col=='table_assigned'){
		$dropdown_string=list_tables_dropdown($col,"");
		
		echo '<tr><td>'.$col.': </td><td>'.$dropdown_string.'</td><tr>';
	}
	else if ($col=='Status'){

		$status_dropdown_results=status_generator($tablename,'');
		echo '<tr><td>'.$col.': </td><td>'.$status_dropdown_results.'</td></tr>';
	}
	else if ($col=='Reference_ID'){
		echo '<tr><td>'.$col.': </td><td>';
		echo '<input type="text" name="'.$col.'" value="'.$_GET['id'].'" readonly="readonly">';
	}
	else if ($col=='Letter_Code_Assigned' || $col=='Date_Sent'){
		//do nothing, blank by default
	}
	else
		echo '<tr><td>'.$col.': </td><td><input type="text" name="'.$col.'"></td><tr>';
}
echo '<td colspan="2"><input type="submit"></td>';
echo '</table>';
echo '</form>';
echo '</div>';
?>