<?php
require 'connect.php';
$str=$_GET['string'];
$arr=explode("\t",$str);

$roll=$arr[0];
$name=$arr[1];
$gender=$arr[2];
$tenth=$arr[3];
$twelth=$arr[4];
$gradyear=$arr[5];
$address=$arr[6];
$email=$arr[7];
$dob=$arr[8];
$dateadmission=$arr[9];
$jeeroll=$arr[10];
$jeeair=$arr[11];
$mob=$arr[12];


$r=execute_MYSQL("SELECT * FROM STUDENT_DETAILS WHERE ROLL='$roll'");

if($r->num_rows!=0){
  echo "data already exists for ".$roll;
  echo "<script>window.onload=function(){
    setTimeout(function(){
      window.location.href='addstudentquickform.php';
    },1000);
  }</script>";
  exit();
}



echo "<br>Roll=".$roll;
echo "<br>Name=".$name;
echo "<br>Gender=".$gender;
echo "<br>Tenth=".$tenth;
echo "<br>Twelth=".$twelth;
echo "<br>GradYear=".$gradyear;
echo "<br>Address=".$address;
echo "<br>Email=".$email;
echo "<br>DOB=".$dob;
echo "<br>Admission Date=".$dateadmission;
echo "<br>JEE Roll=".$jeeroll;
echo "<br>JEE AIR=".$jeeair;
echo "<br>Mobile=".$mob;




if($jeeroll=='DASA'){
  $category='DASA';
  $jeeair=0;
}
else{
  $category='JEE';
}
if($name<"L"){
  $batch='A';
}
else{
  $batch='B';
}
echo "<br>Batch=".$batch;


if(count($arr)!=13){
  echo "<br>ERROR in input<br>";
  print_r($arr);

  exit();
}
echo "INSERT INTO STUDENT_DETAILS VALUES('$name','$roll','$gender','$category','$dob','$email','$mob','$address','$tenth','$twelth',$gradyear,'$jeeroll',$jeeair,'$dateadmission','-','$batch')";
execute_MYSQL("INSERT INTO STUDENT_DETAILS VALUES('$name','$roll','$gender','$category','$dob','$email','$mob','$address','$tenth','$twelth',$gradyear,'$jeeroll',$jeeair,'$dateadmission','-','$batch')");

echo "<script>window.onload=function(){
  setTimeout(function(){
    window.location.href='addstudentquickform.php';
  },1000);
}</script>";
?>
