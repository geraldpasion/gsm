<?php

include 'functions.php';
//$tablename=$_GET['tablename'];
$tablename='sms';
$fields=get_column_names($tablename);

//foreach ($field_name as $col)
//	echo $col.'<br>';

//generate string for insert into
//prepare table string
$table_string="";
$values_string="";


for ($i=1; $i<count($fields); $i++){
	
	if ($fields[$i]=='Date' || $fields[$i]=='Date_Created' || $fields[$i]=='Date_Sent'){
		//do nothing
	}
	else
	{
		$table_string=$table_string." ".$fields[$i].",";
		$values_string=$values_string."'".$_GET[$fields[$i]]."',";
		//echo $fields[$i];
	}
}
if (substr($table_string,-1)==','){

	$table_string=trim($table_string, ',');
}
if (substr($values_string,-1)==','){

	$values_string=trim($values_string, ',');
}

echo 'table string: '.$table_string;

echo '<br>values: '.$values_string;

//send to function insert_statement($tablename, $columns, $values)
insert_statement($tablename,$table_string,$values_string);
//header('Location: ' . $_SERVER['HTTP_REFERER']);

//edit tablename without _meta
if($tablename=='with_po_meta')
	$tablename='with_po';
 else if ($tablename=='without_po_meta')
 	$tablename='without_po';


$location_val=str_replace('_','-',$tablename);
echo "<br>location value: ".$location_val;
//header('Location: '.$location_val);
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>