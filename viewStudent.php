<?php
date_default_timezone_set('utc');
require 'connect.php';
$roll=$_GET['roll'];
$r=execute_MYSQL("SELECT * FROM STUDENT_DETAILS WHERE ROLL='$roll'");
if($r->num_rows==0){
  echo "Error. Record Missing.";
  exit();
}
if($r->num_rows!=1){
  echo "Error. Records Corrupt.";
  exit();
}
$row=$r->fetch_assoc();
$name=$row['NAME'];
$gender=strtolower($row['GENDER']);
$dob=$row['DOB'];
/*
$time=time();
$datetime1=new DateTime($dob);
$datetime2=new DateTime($time);
$age=$datetime2->diff($datetime1);*/
$age="Something";
$jee=$row['CATEGORY'];
$tenth=$row['TENTH'];
$twelth=$row['TWELTH'];
$jee_rank=$row['JEE_RANK'];
$phone=$row['PHONE'];

$r1=execute_MYSQL("SELECT STUDENT_DETAILS.NAME,SUM(GRADE_MAP.VALUE*COURSES.CREDITS)/SUM(COURSES.CREDITS) as CGPA from COURSE_TAKEN,GRADE_MAP,COURSES,STUDENT_DETAILS where GRADE_MAP.GRADE=COURSE_TAKEN.GRADE and COURSE_TAKEN.COURSE=COURSES.CODE and STUDENT_DETAILS.ROLL=COURSE_TAKEN.STUDENT and COURSE_TAKEN.STUDENT='$roll'  ");
$row=$r1->fetch_assoc();
$cgpa=$row['CGPA'];
$rank=1;
$r2=execute_MYSQL("SELECT STUDENT_DETAILS.NAME,SUM(GRADE_MAP.VALUE*COURSES.CREDITS)/SUM(COURSES.CREDITS) as CGPA from COURSE_TAKEN,GRADE_MAP,COURSES,STUDENT_DETAILS where GRADE_MAP.GRADE=COURSE_TAKEN.GRADE and COURSE_TAKEN.COURSE=COURSES.CODE and STUDENT_DETAILS.ROLL=COURSE_TAKEN.STUDENT  GROUP BY COURSE_TAKEN.STUDENT");
while($row=$r2->fetch_assoc()){
  if($cgpa<$row['CGPA']){
    $rank=$rank+1;
  }
}
$r1=execute_MYSQL("SELECT SUM(COURSES.CREDITS) as CREDITS from COURSE_TAKEN,GRADE_MAP,COURSES,STUDENT_DETAILS where GRADE_MAP.GRADE=COURSE_TAKEN.GRADE and COURSE_TAKEN.COURSE=COURSES.CODE and STUDENT_DETAILS.ROLL=COURSE_TAKEN.STUDENT and COURSE_TAKEN.STUDENT='$roll'");
$row=$r1->fetch_assoc();
$tot_credits=$row['CREDITS'];



 ?>

 <html>
  <style>

  </style>
  <body>
    <div id='welcome_panel'>
      <div id='welcome_line'>Welcome <?php echo ucwords(strtolower($name));?>.</div>
      <div class='subpanel'>
        <div class='desc'>
          <?php //echo "You are ".$age->y." years, ".$age->m." months and ".$age->d." days old.";
              echo "You are a $gender student who got $tenth% in 10th and $twelth% in 12th.";
              if($jee=="JEE"){
                  echo "<br>You got into NIT Calicut with a JEE rank of $jee_rank";
              }
              else{
                echo "<br>You got into NIT Calicut through DASA quota.";
              }
              echo "<br>You are reachable on ".$phone.".";
              echo "<br>You currently have a CGPA of $cgpa (" .(($cgpa-0.5)*10 ). "%) ";
              echo "<br>Total credits=".$tot_credits;
              echo "<br>Your rank is ".$rank;
          ?>
        </div>
      </div>
    </div>
    <script>
    var sgpapoints=[];
    var overallpoints=[];
    </script>
    <style>
    body{
      text-align: center;
      background-color: #000;
      color: #fff;
      font-family: 'Eurostile';
    }
    table{
      text-align: center;
      align-items: center;
      width: 80%;
      margin-left: 10%;
    }
    td{
      border-color: solid;
      border-width: 1px;
    }
    #welcome_line{
      font-size:2.5em;
      margin-top: 50px;
    }
    .sub_heading{
      margin-top: 30px;
    }
    .subpanel{
      background-color: rgba(50,50,0,0.6);
      padding:20px;
      margin: 20px;
      transition: all 0.7s;
    }
    .subpanel:hover{
        box-shadow: 0 0 5px rgba(50,50,0,0.6);
        background-color: rgba(50,50,0,0.8);
        transform: translateY(10px);
    }
    td{
      border-color: #fff;
      border-width: 1px;
      border-style: solid;
    }
    </style>
    <div id='COURSE_TAKEN_panel'>
      <?php
        $i=0;
        $r1=execute_MYSQL("SELECT SUM(GRADE_MAP.VALUE*COURSES.CREDITS) AS TOTAL from COURSE_TAKEN,GRADE_MAP,COURSES,STUDENT_DETAILS where GRADE_MAP.GRADE=COURSE_TAKEN.GRADE and COURSE_TAKEN.COURSE=COURSES.CODE and STUDENT_DETAILS.ROLL=COURSE_TAKEN.STUDENT and COURSE_TAKEN.STUDENT='$roll'  ");
        $row=$r1->fetch_assoc();
        $total_points=$row['TOTAL'];
        for($i=1;$i<=8;$i=$i+1){
          echo "<div class='subpanel'>";
          echo "<div class='sub_heading'>Sem $i</div><br><br>";
          echo "<table>";
          echo "<tr>
                  <th>Subject</th><th>Credits</th><th>Grade</th><th>Attendance</th><th>SemesterContribution</th><th>Overall Contribution</th>
                </tr>";
          $r1=execute_MYSQL("SELECT SUM(GRADE_MAP.VALUE*COURSES.CREDITS) AS TOTAL from COURSE_TAKEN,GRADE_MAP,COURSES,STUDENT_DETAILS where GRADE_MAP.GRADE=COURSE_TAKEN.GRADE and COURSE_TAKEN.COURSE=COURSES.CODE and STUDENT_DETAILS.ROLL=COURSE_TAKEN.STUDENT and COURSE_TAKEN.STUDENT='$roll'  and COURSE_TAKEN.SEMESTER=$i");
          $row=$r1->fetch_assoc();
          $sem_points=$row['TOTAL'];
          $r1=execute_MYSQL("SELECT COURSES.NAME as subject ,COURSES.CREDITS as credits ,GRADE_MAP.GRADE as grade ,COURSE_TAKEN.ATTENDANCE as attendance,GRADE_MAP.VALUE*COURSES.CREDITS as contri from COURSES,GRADE_MAP,COURSE_TAKEN where COURSES.CODE=COURSE_TAKEN.COURSE and GRADE_MAP.GRADE=COURSE_TAKEN.GRADE and COURSE_TAKEN.SEMESTER=$i and COURSE_TAKEN.STUDENT='$roll'");
          while($row=$r1->fetch_assoc()){
              $subject=$row['subject'];
              $credits=$row['credits'];
              $grade=$row['grade'];
              $attendance=$row['attendance'];
              $contri=$row['contri'];
              $semcontri=$contri*100/$sem_points;
              $totalcontri=$contri*100/$total_points;
              echo "<tr>
                    <td>$subject</td><td>$credits</td><td>$grade</td><td>$attendance</td><td>$semcontri</td><td>$totalcontri</td>
                </tr>";
          }
          echo "</table>";
          $r1=execute_MYSQL("SELECT SUM(GRADE_MAP.VALUE*COURSES.CREDITS)/SUM(COURSES.CREDITS) as SGPA from COURSE_TAKEN,GRADE_MAP,COURSES,STUDENT_DETAILS where GRADE_MAP.GRADE=COURSE_TAKEN.GRADE and COURSE_TAKEN.COURSE=COURSES.CODE and STUDENT_DETAILS.ROLL=COURSE_TAKEN.STUDENT and COURSE_TAKEN.STUDENT='$roll' and COURSE_TAKEN.SEMESTER=$i ");
          $row=$r1->fetch_assoc();
          $sgpa=$row['SGPA'];
          $rank=1;
          $r2=execute_MYSQL("SELECT COURSE_TAKEN.STUDENT,SUM(GRADE_MAP.VALUE*COURSES.CREDITS)/SUM(COURSES.CREDITS) as SGPA from COURSE_TAKEN,GRADE_MAP,COURSES,STUDENT_DETAILS where GRADE_MAP.GRADE=COURSE_TAKEN.GRADE and COURSE_TAKEN.COURSE=COURSES.CODE and STUDENT_DETAILS.ROLL=COURSE_TAKEN.STUDENT and COURSE_TAKEN.SEMESTER=$i GROUP BY COURSE_TAKEN.STUDENT");
          while($row=$r2->fetch_assoc()){
            if($sgpa<$row['SGPA']){
              $rank=$rank+1;
              //print_r($row);
            }
          }
          echo "<br><br>SGPA=".$sgpa;
          $r1=execute_MYSQL("SELECT SUM(COURSES.CREDITS) as CREDITS from COURSE_TAKEN,GRADE_MAP,COURSES,STUDENT_DETAILS where GRADE_MAP.GRADE=COURSE_TAKEN.GRADE and COURSE_TAKEN.COURSE=COURSES.CODE and STUDENT_DETAILS.ROLL=COURSE_TAKEN.STUDENT and COURSE_TAKEN.STUDENT='$roll' and COURSE_TAKEN.SEMESTER=$i");
          $row=$r1->fetch_assoc();
          $tot_credits=$row['CREDITS'];
          echo "<br>Sem credits=".$tot_credits;
          echo "<br>Sem rank=".$rank;
          echo "<script>sgpapoints.push({x:$i,y:$rank});</script>";
          $rank=1;
          $r2=execute_MYSQL("SELECT COURSE_TAKEN.STUDENT,SUM(GRADE_MAP.VALUE*COURSES.CREDITS)/SUM(COURSES.CREDITS) as SGPA from COURSE_TAKEN,GRADE_MAP,COURSES where GRADE_MAP.GRADE=COURSE_TAKEN.GRADE and COURSE_TAKEN.COURSE=COURSES.CODE and COURSE_TAKEN.SEMESTER<=$i and COURSE_TAKEN.STUDENT='$roll'");
          $row=$r2->fetch_assoc();
          $csgpa=$row['SGPA'];
          //echo "CCCCSSSSGGGPPPAAA=$csgpa????";
          $r2=execute_MYSQL("SELECT COURSE_TAKEN.STUDENT,SUM(GRADE_MAP.VALUE*COURSES.CREDITS)/SUM(COURSES.CREDITS) as SGPA from COURSE_TAKEN,GRADE_MAP,COURSES,STUDENT_DETAILS where GRADE_MAP.GRADE=COURSE_TAKEN.GRADE and COURSE_TAKEN.COURSE=COURSES.CODE and STUDENT_DETAILS.ROLL=COURSE_TAKEN.STUDENT and COURSE_TAKEN.SEMESTER<=$i GROUP BY COURSE_TAKEN.STUDENT");
          while($row=$r2->fetch_assoc()){
            if($csgpa<$row['SGPA']){
              $rank=$rank+1;
            //  print_r($row);
            }
          }
          echo "<br>Rank till now=".$rank;
          echo "<script>overallpoints.push({x:$i,y:$rank});</script>";
          echo "</div>";
        }

      ?>
    </div>
    <div id='graphs_panel'>
      <div id='semranks' style="height:300px;">
      </div>
      <div id='overallranks' style="height:300px;">
      </div>
    </div>
    <script type="text/javascript">
  	window.onload = function() {
  		var chart = new CanvasJS.Chart("semranks", {
  			title: {
  				text: "Semester Rankings(Lower the better)"
  			},
  			axisX: {
          title: "Semester",
  				interval: 1
  			},
        axisY:{

          title:"Ranking"
        },
  			data: [{
  				type: "area",
  				dataPoints:sgpapoints
  			}]
  		});
  		chart.render();
      var chart2 = new CanvasJS.Chart("overallranks", {
  			title: {
  				text: "Overall Rankings(Lower the better)"
  			},
  			axisX: {
          title: "Semester",
  				interval: 1
  			},
        axisY:{

          title:"Ranking"
        },
  			data: [{
  				type: "area",
  				dataPoints:overallpoints
  			}]
  		});
  		chart2.render();
  	}
  	</script>
  	<script src="canvasjs.min.js"></script>
  </body>
</html>
