<?php
date_default_timezone_set('utc');
require 'connect.php';
echo "<table>";
$r=execute_MYSQL("SELECT STUDENT_DETAILS.NAME,SUM(GRADE_MAP.VALUE*COURSES.CREDITS)/SUM(COURSES.CREDITS) as CGPA from COURSE_TAKEN,GRADE_MAP,COURSES,STUDENT_DETAILS where GRADE_MAP.GRADE=COURSE_TAKEN.GRADE and COURSE_TAKEN.COURSE=COURSES.CODE and STUDENT_DETAILS.ROLL=COURSE_TAKEN.STUDENT GROUP BY COURSE_TAKEN.STUDENT ORDER BY CGPA DESC");
$i=1;
while($row=$r->fetch_assoc()){
  echo "<tr><td>".$i.".</td><td>".$row['NAME']."</td><td>".$row['CGPA']."</td></tr>";
  $i=$i+1;
}

echo "</table>";
?>
