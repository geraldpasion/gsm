<?php


function get_column_names($table_name){
//fetch table fields of profile to generate input statement
$dbname = 'gsm';

if (!mysql_connect('localhost', 'root', '')) {
    echo 'Could not connect to mysql';
    exit;
}

$sql = "SHOW COLUMNS FROM $table_name FROM $dbname";
$result = mysql_query($sql);

if (!$result) {
    echo "DB Error, could not list tables\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}

//prepare an array
$field_names = [];

while ($row = mysql_fetch_row($result)) {
    $field_names[]= $row[0];
    //cho "Table: {$row[0]}\n";
}

mysql_free_result($result);

return $field_names;

}

function select_statement($select_column, $tablename, $id, $fields){
	include 'connect.php';

	$sql = "SELECT $select_column FROM $tablename WHERE profile_id=".$id;
	//echo $sql;
	$result = $conn->query($sql);
	$dep_count=0;
	$select_results_in_array = array();
	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) { //clickable row
	        //assign each row results to an array
	        //this will return only 1 item because of $id
	        echo '<tr>';
	        for ($i=0; $i<count($fields); $i++){
	        	$select_results_in_array[] = $row[$fields[$i]];
	        	if($i>1)
	        		echo '<td class="table-grid">'.$select_results_in_array[$i].'</td>';	        
	        }
	        echo '</tr>';
	    }
	} 
	else {
	    echo "0 results";
	}
	$conn->close();
}


function view_everything($tablename, $fields){
	include 'connect.php';

	$sql = "SELECT * FROM $tablename";
	//echo $sql;
	$result = $conn->query($sql);
	$dep_count=0;
	$select_results_in_array = array();
	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) { //clickable row
	   	
	        echo '<tr>';
	        for ($i=0; $i<count($fields); $i++){
	        	$row[$fields[$i]];
	        	if($fields[$i]=='Image')
	        		echo '<td class="table-grid"><a href="../../'.$row[$fields[$i]].'"><img src="../../'.$row[$fields[$i]].'"></td>';
	        	else
	        		echo '<td class="table-grid">'.$row[$fields[$i]].'</td>';	        
	        	        
	        }
	        echo '</tr>';
	    }
	} 
	else {
	    echo "0 results";
	}
	$conn->close();

}

function insert_statement($tablename, $columns, $values){
	include 'connect.php';
//concat two strings to generate sql statement
$sql="INSERT INTO $tablename (".$columns.") VALUES (".$values.")";
echo '<br><br><br>sql: '.$sql;

//proceed to input
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "<br><br>Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();
}

//view and generate everything in table
function select_all($tablename, $extra_cells, $extra_fields){
	include 'connect.php';
	$fieldnames = [];
	$fieldnames=get_column_names($tablename);
	//output table headers
	echo '<tr>';
	foreach ($fieldnames as $col)
		echo '<th>'.$col.'</th>';

	if($extra_fields=='Actions' && $extra_cells>0){
		echo '<th colspan="'.$extra_cells.'">'.$extra_fields.'</th>';
	}

	echo '</tr>';


	$sql = "SELECT * FROM $tablename";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) { 
	    	echo '<tr>';

	    		for($i=0; $i<count($fieldnames); $i++){
	    			echo '<td>'.$row[$fieldnames[$i]].'</td>';
	    		}

	    		//add extra cells if necessary.
	    		if($extra_fields=='Actions'){
	    			$icon_size=25;
	    			//edit icon
	    			echo '<td>';
	    			echo '<a href="../edit-row?id='.$row["ID"].'&table_name='.$tablename.'"><img src="../assets/Edit.png" height="'.$icon_size.'" width="'.$icon_size.'"></a>';
	    			echo '</td>';

	    			//delete icon
	    			echo '<td>';
	    			echo '<a href="../delete-row?id='.$row["ID"].'&table_name='.$tablename.'"><img src="../assets/cross.jpg" height="'.$icon_size.'" width="'.$icon_size.'"></a>';
	    			echo '</td>';
	    			
	    		}

	    	echo '</tr>';
	    }
	}
	else {
	    echo "0 results";
	}
	
	$conn->close();

}

function add_new_entry($tablename){
	//generate add form link/button
	echo '<a href="../add-new?tablename='.$tablename.'">Add New</a>';

}

function generate_inputs(){

}

function generate_dropdown($column_name, $table_name){

	$dropdown_values=simple_select($column_name,$table_name);

	//initialize dropdown string
	$dropdown_string="";

	$dropdown_string=$dropdown_string.'<select id="'.$column_name.'" name="'.$column_name.'">';  
	$dropdown_string=$dropdown_string.'<option value="0">--Select '.$column_name.'--</option>';
	foreach ($dropdown_values as $val){
		//generate dropdown string
		$dropdown_string=$dropdown_string.'<option value="'.$val.'">'.$val.'</option>';
	}
	$dropdown_string=$dropdown_string.'</select>';
		
	return $dropdown_string;
	

}

function simple_select($column_name, $table_name){
	include 'connect.php';
	
	//prepare an array to return
	$results=[];

	$sql = "SELECT $column_name FROM $table_name";
	
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) { 
	    	$results[]=$row[$column_name];
	    }
	}
	else {
	    echo "0 results<br>";
	}
	
	$conn->close();

	return $results;
}

function select_and_fill(){
	include 'connect.php';
}
//end of file
?>