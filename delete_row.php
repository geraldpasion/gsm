<?php
include 'connect.php';

$table_name=$_GET['table_name'];
$id=$_GET['id'];
echo 'xxxx: '.$id;

// sql to delete a record
$sql = "DELETE FROM $table_name WHERE id=".$id;
echo $sql;
if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();

echo '<br>';
include $table_name.'.php';
?>