<?php


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "finance_gsm_files";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

//$sql = "INSERT INTO MyGuests (firstname, lastname, email)
//VALUES ('John', 'Doe', 'john@example.com')";
echo "<br>From: ".$_GET['phone'];
echo "<br>Text Message: ".$_GET['text'];
echo "<br>Date Received: ".$_GET['received_date'];

//$query = "INSERT INTO sms_files (received, sms, date_sent) Values ('".$_GET['phone']."','".$_GET['text']."','".$_GET['received_date']."')";
$query = "INSERT INTO sms_files (received, sms) Values ('".$_GET['phone']."','".$_GET['text']."')";
$result = mysql_query($query);

if ($conn->query($query) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}

//$conn->close();












//$in_phoneNumber='+639175541429';
//$in_msg='marla christelle dm pasion';

//sendSmsMessage($in_phoneNumber, $in_msg);

function sendSmsMessage($in_phoneNumber, $in_msg)
{
  $url = '/cgi-bin/sendsms?username=' . CONFIG_KANNEL_USER_NAME
         . '&password=' . CONFIG_KANNEL_PASSWORD
         . '&charset=UCS-2&coding=2'
         . "&to={$in_phoneNumber}"
         . '&text=' . urlencode(iconv('utf-8', 'ucs-2', $in_msg));

  $results = file('http://'
                  . CONFIG_KANNEL_HOST . ':'
                  . CONFIG_KANNEL_PORT . $url);
}

?>