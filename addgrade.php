<?php
  session_start();
  require 'connect.php';
  $roll=$_POST['roll'];
  $course=$_POST['course'];
  $grade=$_POST['grade'];
  $at=$_POST['attendance'];
  $sem=$_POST['sem'];
  $_SESSION['sem']=$sem;
  $_SESSION['roll']=$roll;
  $_SESSION['C']=$course;
  execute_MYSQL("INSERT INTO GRADES VALUES('$roll','$course','$grade','$at',$sem)");
  echo "<script>window.location.href='addgradeform.php';</script>";
?>
