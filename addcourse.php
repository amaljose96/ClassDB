<?php
require 'connect.php';
$name=$_POST['CName'];
$code=$_POST['CCode'];
$credit=$_POST['CCredit'];

execute_MYSQL("INSERT INTO COURSES VALUES('$code','$name',$credit)");

echo "Successfully inserted $name.<script>setTimeout(function(){
  window.location.href=\"addcourse.html\";
},1000);</script>"

 ?>
