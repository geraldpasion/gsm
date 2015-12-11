<?php

include 'functions.php';
$tablename=$_GET['tablename'];

$fields=get_column_names($tablename);

//foreach ($field_name as $col)
//	echo $col.'<br>';

//generate string for insert into
//prepare table string
$table_string="";
for ($i=1; $i<count($fields); $i++){
	if($i==count($fields)-1) //meaning end array. must not add comma
		$table_string=$table_string." ".$fields[$i]."='".$_POST[$fields[$i]]."'";
	else if ($fields[$i]=='Date' || $fields[$i]=='Letter_Code' || $fields[$i]=='Date_Created'){
		//do nothing
	}
	else
		$table_string=$table_string." ".$fields[$i]."='".$_POST[$fields[$i]]."',";
}

echo 'table string: '.$table_string;

$row_id=$_GET['id'];
echo 'ID: '.$row_id;
//send to function insert_statement($tablename, $columns, $values)
update_statement($tablename,$table_string, $row_id );
//header('Location: ' . $_SERVER['HTTP_REFERER']);
$location_val=str_replace('_','-',$tablename);
echo "<br>location value: ".$location_val;
header('Location: '.$location_val);
?>