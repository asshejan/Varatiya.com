<?php
// Database configuration
$host = "localhost";
$db_name = "varatiya_db";
$username = "root"; // typically "root" for local setups
$password = "123"; //m XAMP pass is 123 modified by myself

// Create a connection
$conn = new mysqli($host, $username, $password, $db_name);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
 }//else{
//     echo "connected";
// }
?>
