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

function update_statement($tablename, $table_string, $row_id){
	include 'connect.php';
//concat two strings to generate sql statement
$sql="UPDATE $tablename SET ".$table_string." WHERE ID='".$row_id."'";
echo '<br><br><br>sql: '.$sql;

//proceed to input
if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "<br><br>Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();
}

//view and generate everything in table
function select_all($tablename, $extra_cells, $extra_fields){
	include 'connect.php';
	
	echo '<div class="table-responsive">';
	echo '<table class="table table-responsive table-striped table-hover table-condensed">';

	$fieldnames = [];
	$fieldnames=get_column_names($tablename);
	//output table headers
	echo '<tr>';
	foreach ($fieldnames as $col)
		echo '<th>'.$col.'</th>';

	if($extra_fields=='Actions' || $extra_fields=='QA Actions' && $extra_cells>0){
		echo '<th colspan="'.$extra_cells.'">'.$extra_fields.'</th>';
	}

	echo '</tr>';


	$sql = "SELECT * FROM $tablename ORDER BY ID DESC";
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
	    			$icon_size=50;
	    		
	    			//edit icon - secretary
	    			echo '<td>';
	    			echo '<a href="../edit-row?id='.$row["ID"].'&table_name='.$tablename.'"><img src="../assets/Edit.png" height="'.$icon_size.'" width="'.$icon_size.'"></a>';
	    			echo '</td>';

	    			//view icon - QA
	    			echo '<td>';
	    			echo '<a href="../view-details?id='.$row["ID"].'&table_name='.$tablename.'"><img src="../assets/view_details.png" height="'.$icon_size.'" width="'.$icon_size.'"></a>';
	    			echo '</td>';

	    			//view icon - CR
	    			echo '<td>';
	    			echo '<a href="../view-details?id='.$row["ID"].'&table_name='.$tablename.'"><img src="../assets/view_details.png" height="'.$icon_size.'" width="'.$icon_size.'"></a>';
	    			echo '</td>';

	    			//delete icon
	    			echo '<td>';
	    			echo '<a href="../delete-row?id='.$row["ID"].'&table_name='.$tablename.'"><img src="../assets/cross.jpg" height="'.$icon_size.'" width="'.$icon_size.'"></a>';
	    			echo '</td>';
	    			
	    		}
	    		else if($extra_fields=='QA Actions'){
	    			$icon_size=25
;	    			//view icon
	    			echo '<td>';
	    			echo '<a href="../view-details?id='.$row["ID"].'&table_name='.$tablename.'"><img src="../assets/view_details.png" height="'.$icon_size.'" width="'.$icon_size.'"></a>';
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

	echo '</table>';
	echo '</div>';

}

function add_new_entry($tablename){
	//generate add form link/button
	echo '<a href="../add-new?tablename='.$tablename.'&id='.$_GET['id'].'">Add New</a>';

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

function select_row($row_id, $tablename){
	include 'connect.php';
	//echo "row id: ".$row_id."<br>";
	//prepare an array to return
	$results=[];
	$field_names=[];
	$field_names=get_column_names($tablename);

	$sql = "SELECT * FROM $tablename WHERE ID=$row_id";
	
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) { 
	    	for($i=0; $i<count($field_names); $i++){
	    		$results[]=$row[$field_names[$i]];
	    	}
	    
	    }
	}
	else {
	    echo "0 results<br>";
	}
	
	$conn->close();

	return $results;


}

function select_row_meta($row_id, $tablename){
	include 'connect.php';
	//echo "row id: ".$row_id."<br>";
	//prepare an array to return
	$results=[];
	$field_names=[];
	$field_names=get_column_names($tablename);

	$sql = "SELECT * FROM $tablename WHERE Reference_ID=$row_id";
	
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) { 
	    	for($i=0; $i<count($field_names); $i++){
	    		$results[]=$row[$field_names[$i]];
	    	}
	    
	    }
	}
	else {
	    echo "0 results<br>";
	}
	
	$conn->close();

	return $results;


}

function get_letter_code($tablename){
	include 'connect.php';
	$date_today=date("Y-m-d");

	$sql = "SELECT Letter_Code FROM $tablename WHERE STR_TO_DATE(Date,'%Y-%m-%d')  = CURDATE() ORDER BY Date DESC";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) { 
	    	return $row['Letter_Code'];
	    	break;
		}
	}
	else {
	    return 'A';
	}
	
	$conn->close();	
	//return 0;
}

function list_tables(){
	$dbname = 'gsm';

if (!mysql_connect('localhost', 'root', '')) {
    echo 'Could not connect to mysql';
    exit;
}

$sql = "SHOW TABLES FROM $dbname";
$result = mysql_query($sql);

if (!$result) {
    echo "DB Error, could not list tables\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}

$return=[];
while ($row = mysql_fetch_row($result)) {
    //echo "Table: {$row[0]}\n";
    $return_val[]=$row[0];

}

mysql_free_result($result);

return $return_val;
}

function list_tables_dropdown($column_name,$default_value){

	//$dropdown_values=simple_select($column_name,$table_name);
	$values=list_tables();
	//initialize dropdown string
	$dropdown_string="";

	$dropdown_string=$dropdown_string.'<select id="'.$column_name.'" name="'.$column_name.'">';  
	$dropdown_string=$dropdown_string.'<option value="0">--Select '.$column_name.'--</option>';
	foreach ($values as $val){
		//generate dropdown string
		if($default_value==$val)
			$dropdown_string=$dropdown_string.'<option value="'.$val.'" selected>'.$val.'</option>';
		else
		$dropdown_string=$dropdown_string.'<option value="'.$val.'">'.$val.'</option>';
	}
	$dropdown_string=$dropdown_string.'</select>';
		
	return $dropdown_string;

}

function status_generator($tablename,$default_value){
	include 'connect.php';

	//prepare an array to return
	$results=[];
	$field_names=[];
	$field_names=get_column_names($tablename);

	$sql = "SELECT status FROM status WHERE table_assigned='".$tablename."'";
	
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) { 
	    	
	    		$results[]=$row['status'];
	    
	    
	    }
	}
	else {
	    echo "0 results<br>";
	}
	
	$conn->close();

	//return $results;
	//generate reutrn string
	$dropdown_values=$results;
	$dropdown_string="";

	$column_name='Status';

	$dropdown_string=$dropdown_string.'<select id="'.$column_name.'" name="'.$column_name.'">';  
	$dropdown_string=$dropdown_string.'<option value="0">--Select '.$column_name.'--</option>';
	foreach ($dropdown_values as $val){
		//generate dropdown string
		if($default_value==$val)
			$dropdown_string=$dropdown_string.'<option value="'.$val.'" selected>'.$val.'</option>';
		else
			$dropdown_string=$dropdown_string.'<option value="'.$val.'">'.$val.'</option>';
	}
	$dropdown_string=$dropdown_string.'</select>';
		
	return $dropdown_string;

}

function select_row_table_view_qa($id,$tablename){
	$row_values=select_row($id,$tablename);

	foreach($row_values as $val){
	echo '<tr><td>'.$val.'</td></tr>';
	}

}

function get_details_meta(){

}

//SMS section
function sendText($text,$phone_number,$smsc_id)
{
	$text=urlencode($text);
	$response = file_get_contents("http://127.0.0.1:13013/cgi-bin/sendsms?user=sms-app&pass=app125&text=".$text."&to=".$phone_number."&smsc_id="+$smsc_id );
}

function chat_box($id,$letter_code){
	include 'connect.php';
	echo '<form action="../send_sms.php?tablename=sms" method="get">';
	echo '<label>Chatbox</label><br>';
	echo '<textarea type="textarea" name="SMS"></textarea>';
		//generate checkbox for choosing which smsc they will sned
	echo '<br><b>Choose Phone Number/SMSC to send</b><br>';
		smsc_checkboxes();

		//hidden to get id value and lettercode
		echo '<input type="hidden" name="Reference_ID" value="'.$id.'" readonly="readonly">';
		echo '<input type="hidden" name="Letter_Code_Assigned" value="'.$letter_code.'" readonly="readonly">';


	echo '<br><input type="submit"> ';
	echo '</form>';
	//chat box inbox
	echo '<table class="table table-responsive table-hover table-striped table-condensed">';
	$condition='WHERE Reference_ID='.$id;
	inbox_select($id,$letter_code,$condition,0);
	echo '</table>';


	//general inbox
	echo '<b>General Inbox</b>';
	echo '<table class="table table-responsive table-hover table-striped table-condensed">';
	$condition='WHERE Reference_ID=""';
	inbox_select($id,$letter_code,$condition,1);
	echo '</table>';
}

function smsc_checkboxes(){
	include 'connect.php';

	$sql = "SELECT SMS_Slot, Phone_Number FROM sms_slots WHERE Status='Active'";
	
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) { 
	    	echo '<input type="checkbox" id="checkbox_smsc" name="Sender" value="'.$row['Phone_Number'].'">';
	   		echo $row['SMS_Slot']."&nbsp;";
	    	echo $row['Phone_Number']."&nbsp;";   
	    }

	}
	else {
	    echo "0 results<br>";
	}
	
	$conn->close();

}
function inbox_select($id,$letter_code,$condition,$action_check){
	include 'connect.php';

	$tablename='sms';

	$fieldnames = [];
	$fieldnames=get_column_names($tablename);
	//output table headers
	echo '<tr>';
	foreach ($fieldnames as $col)
		echo '<th>'.$col.'</th>';

	if ($action_check>0){
		for($i=0; $i<$action_check; $i++){
			echo '<td></td>';
		}
	}
	echo '</tr>';

	echo '<form action="../assign_text.php?tablename=sms&id="'.$id.'" method="get">';
	$sql = "SELECT * FROM $tablename ".$condition;
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) { 
	    	echo '<tr>';

	    		for($i=0; $i<count($fieldnames); $i++){
	    			echo '<td>'.$row[$fieldnames[$i]].'</td>';

	    			if($fieldnames[$i]=='ID')
	    				$id_sms=$row[$fieldnames[$i]];
	    		}
	    	//generate checkbox
	    	if ($action_check>0){
  				echo '<td><input type="checkbox" id="checkbox_values" name="checkbox_values[]" value="'.$id_sms.'"></td>';
	    	}
	    	echo '</tr>';
	    }
	}
	else {
	    echo "0 results";
	}
		//hidden to get id value and lettercode
		echo '<input type="hidden" name="hidden_id" value="'.$id.'" readonly="readonly">';
		echo '<input type="hidden" name="hidden_letter_code" value="'.$letter_code.'" readonly="readonly">';

	//remove submit if there are no conditions
	if($action_check>0)
		{
			echo '<tr><td><input type="submit" value="Assign"></td></tr>';
			//echo '<tr><td><a class="btn btn-default" href="../assign_text.php?tablename=sms&id="'.$id.'" role="button">Assign</a>';
			echo '</td></tr>';
	}
	echo '</form>';
	$conn->close();

}	

function get_user_role() {
	global $current_user;

	$user_roles = $current_user->roles;
	$user_role = array_shift($user_roles);

	return $user_role;
}
//end of file
?>