<?php
  require 'connect.php';
  $name=$_POST['Name'];
  $rollnumber=$_POST['Roll'];
  $gender=$_POST['gender'];
  $category=$_POST['category'];
  $dob=$_POST['DOB'];
  $email=$_POST['email'];
  $phone=$_POST['contact'];
  $address=$_POST['address'];
  $tenth=$_POST['tenth'];
  $twelfth=$_POST['twelfth'];
  $jee_roll=$_POST['jee_roll'];
  $jee_rank=$_POST['jee_rank'];
  $first_batch=$_POST['first_batch'];
  $cur_batch=$_POST['batch'];
  execute_MYSQL("INSERT INTO STUDENT")
?>
