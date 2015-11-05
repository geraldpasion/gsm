<?php 
include 'functions.php';
$permission_label = array('Address Book', 'Department', 'W/ and W/o PO', 'Users', 'Roles');

//generate dropdown of roles/users under accounts
$table_name='accounts';
$colum_name='User_Name';
echo generate_dropdown($colum_name,$table_name);


?>
<br>
<form>
<table class="tg table table-responsive table-hover table-bordered table-striped">
  <tr>
    <th class="tg-031e">Label</th>
    <th class="tg-031e">Add</th>
    <th class="tg-031e">Edit</th>
    <th class="tg-031e">Delete</th>
   
    
  </tr>

  <?php 
  
    for ($count=0; $count<count($permission_label); $count++){
      echo ' <tr>
    <td class="tg-031e">'.$permission_label[$count].'</td>
    <td class="tg-031e"><input type="checkbox"></td>
    <td class="tg-031e"><input type="checkbox"></td>
    <td class="tg-031e"><input type="checkbox"></td>
    </tr>';
    }
 echo  '<td colspan="4"><input type="submit"></td>';
 echo '</table></form>';
   
  ?>