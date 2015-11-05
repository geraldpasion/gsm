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
	if($i==count($fields)-1)
		$table_string=$table_string." ".$fields[$i]."";
	else
		$table_string=$table_string." ".$fields[$i].",";
}

echo 'table string: '.$table_string;

//prepare values string
$values_string="";
//get $_POST values form form

for ($i=1;$i<count($fields); $i++){
	if($i==count($fields)-1)
		$values_string=$values_string."'".$_POST[$fields[$i]]."'"; //no comma
	else
		$values_string=$values_string."'".$_POST[$fields[$i]]."',";

}

echo '<br>values: '.$values_string;

//send to function insert_statement($tablename, $columns, $values)
insert_statement($tablename,$table_string,$values_string);
header('Location: ' . $_SERVER['HTTP_REFERER']);

?>