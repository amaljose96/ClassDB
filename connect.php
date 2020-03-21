<?php
function execute_MYSQL($sql){
  //DATABASE DETAILS
  $servername="localhost";
  $username = "***";
  $password='***';
  $database= "Class_DB";
  // Create connection
  $conn = new mysqli($servername, $username, $password, $database);
  // Check connection
  if ($conn->connect_error)
  {
     exit("Connection failed: " . $conn->connect_error);
  }
  $result = $conn->query($sql);
  $conn->close();
  return $result;
}
?>
