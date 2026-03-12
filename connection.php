<?php
// Connecting to MySQL server using mysqli
$domain = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "cde";

// Create connection
$conn = new mysqli($domain, $dbuser, $dbpass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
