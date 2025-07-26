<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_myname = "project_number 3";
try {
  $conn = new PDO("mysql:host=$servername;dbname=".$db_myname, $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>