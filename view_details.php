<?php

include 'connect.php';
include 'functions.php';

$tablename=$_GET['table_name'];
$id=$_GET['id'];
$extra_fields = 'Actions';
//option to add new
//add_new_entry($tablename);
echo $tablename;
echo '<div>';
echo '<table class="table table-responsive table-striped table-hover">';

	$row_values=select_row($id,$tablename);
	$fields=get_column_names($tablename);
	for($i=0;$i<count($row_values);$i++){
	echo '<tr><td><b>'.$fields[$i].':</b></td><td>'.$row_values[$i].'</td></tr>';

	//assign letter code to variable
		if ($fields[$i]=='Letter_Code'){
			$letter_code=$row_values[$i];
		}
		else if($fields[$i]=='Status'){
			$status_val=$row_values[$i];
		}
	}	
echo '</table>';
echo '</div>';


//item history code here

//meta table
$tablename_meta=$tablename."_meta";

add_new_entry($tablename_meta);

echo "<br><b>Items</b></br>";

echo $tablename_meta."<br>";
//echo '<div>';
//echo '<table>';

	$row_values=select_row_meta($id,$tablename_meta);
	$fields=get_column_names($tablename_meta);
	
	//generate headers
	/*echo "<tr>";
	foreach ($fields as $col){
		echo "<td>";
			echo $col;
		echo "</td>";
	}
	echo "</tr>";

	//generate table results
	for($i=0;$i<count($row_values);$i++){
	//echo '<tr><td>'.$fields[$i].':</td><td>'.$row_values[$i].'</td></tr>';
	*/

	select_all($tablename_meta,0,'');

	//}
//echo '</table>';
//echo '</div>';


//*********button status change section********************
if($status_val='Request'){
echo '<a class="btn btn-default" href="#" role="button">Approve</a>';
echo '<a class="btn btn-default" href="#" role="button">Reject</a>';
echo '<a class="btn btn-default" href="#" role="button">Cancel</a>';
}

//**************chat box section**********************

//send text section
chat_box($id, $letter_code);

//inbox table
/*global $current_user;
      get_currentuserinfo();

      echo 'Username: ' . $current_user->user_login . "\n";
      echo 'User email: ' . $current_user->user_email . "\n";
      echo 'User level: ' . $current_user->user_level . "\n";
      echo 'User first name: ' . $current_user->user_firstname . "\n";
      echo 'User last name: ' . $current_user->user_lastname . "\n";
      echo 'User display name: ' . $current_user->display_name . "\n";
      echo 'User ID: ' . $current_user->ID . "\n";


if ( is_user_logged_in() ) {
	$userRole = ($current_user->data->wp_capabilities);
	$role = key($userRole);
	unset($userRole);
	$edit_anchr = '';
	switch($role) {
		case ('administrator'||'editor'||'contributor'||'author'):
			$edit_anchr = ucfirst($role).': <a href="'.get_edit_post_link( $post->ID ).'">Edit</a>';
		break;
		default:
		break;
	}
	echo $edit_anchr;
}
*/

echo get_user_role();
?>

