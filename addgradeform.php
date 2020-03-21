<?php
session_start();
$r=$_SESSION['roll'];
$s=$_SESSION['sem'];
$c=$_SESSION['C'];
if($r!=''){
  $script="<script src='jquery.js'></script><script>$(document).ready(function(){ $('#roll').val('$r');$('#C').val('$c');$('#sem').val('$s');});</script>";
}
else{
  $script='';
}
?>

<form action="addgrade.php" method='POST'>
  <input id='roll' placeholder="Roll no" name='roll'>
  <input id='C' placeholder="Course ID" name='course'>
  <input placeholder="Grade" name='grade'>
  <input placeholder="Attendance" name='attendance'>
  <input id='sem' placeholder="Semester" name='sem'>
  <input type='submit'>
</form>


<?php
echo $script;
?>
