<?php
function OpenCon() {
$dbhost = "localhost";
$dbuser = "root";
$dbpass = ""; 
$dbname = "newestshop";
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
return $conn;
}
function CloseCon($conn) {
$conn->close();
}
?>