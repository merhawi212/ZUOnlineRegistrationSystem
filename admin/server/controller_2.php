<?php

require 'controller.php';
        
if(isset($_POST['request_type']))
{
    $request_type = $_POST['request_type'];
    $returned_value="";
    switch ($request_type) {

       case "fetch_students":
            $returned_value = display_students($connection, $_POST['student_id'],$_POST['CGPA'] ,$_POST['major'],
                    $_POST['college'] , $_POST['campus'] ,$_POST['AddDropOnholdStatus'] );
            break;
        case "fetch_AddDropRequested_courses":
            $returned_value= display_AddDropRequestedCourses($connection, $_POST['id']);   
            break;
        case "update_AddDropApproval":
            $returned_value= update_AddDropApproval($connection, $_POST['crn'],  $_POST['status'], $_POST['requestType']);   
            break;
        case "find_courseClasses":
            $returned_value= find_CourseClasses($connection, $_POST['courseid']);   
            break;
        case "enroll_student":
            $returned_value= enroll_student($connection, $_POST['crn']);   
            break;
        case "drop_course":
            $returned_value= Drop_Studentcourse($connection, $_POST['CRN']);   
            break;
        
  

    }
    echo $returned_value;
}
function Drop_Studentcourse($connection, $crn) {
     $username = $_SESSION['student_ID'];
   
    return Drop_course($connection, $crn, $username);
}

function checkCourseOVerLoad($connection, $CGPA, $totalCreditHours, $courseid) {
    $query = "SELECT c.Course_Credit FROM course c where c.Course_ID = '$courseid' ";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_array($result);
        $totalCreditHours += intval($row['Course_Credit']);
        if(($CGPA >= 3.4) && ($totalCreditHours <= 19))
         return 1;
        elseif (($CGPA >= 2.2) && ($totalCreditHours <= 15)) {
             return 1;
         }
         elseif (($CGPA < 2.2) && ($totalCreditHours <= 11)) {
             return 1;
         }
        else {
         return 0;

         }
}
function enroll_student($connection, $CRN) {
    $username = $_SESSION['student_ID'];
     $CGPA = getStudentCGPA($connection, $username);
    $totalCreditHours = getTotalEnrolledCreditHour($connection, $username);
    $query = "Select c.Course_ID From section s join course c on s.Course_ID = c.Course_ID where s.CRN='$CRN'";
    $result = mysqli_query($connection, $query);
    $row =mysqli_fetch_array($result);
    $courseid = $row['Course_ID'];
    
    if(checkCourseOVerLoad($connection, $CGPA, $totalCreditHours, $courseid)==1) {
        if(checkOutEnrollmentProcess($connection, $CRN)== 1){
            $query = "UPDATE track_student SET IsRegistered =True WHERE student_id ='$username' ";
             $result = mysqli_query($connection, $query);
             if (!$result) {
                 die("unable to update track_student" . mysqli_error($connection));
              }

             return 'success';
           }
            
    }
    return 'error';
    
}
//echo enroll_student($connection, '221119');
function checkOutEnrollmentProcess($connection, $CRN){
        $username = $_SESSION['student_ID'];
        $now= date('Y-m-d h:i:s', time());
        $query = "Insert into Course_enroll values('$username', '$CRN', '$now')";
        $result = mysqli_query($connection, $query);
        if (!$result) {
             die("unable to update projec").mysqli_error($connection);
        } 
        
        else {
            $query = "Update section s set s.EnrolledStudents = s.EnrolledStudents + 1 where s.CRN ='$CRN'";
            $result = mysqli_query($connection, $query);
              if (!$result ) {
               die("unable to update section").mysqli_error($connection);
            }
            $query = "UPDATE projectiontable p set status ='Enrolled' where p.std_ID='$username' "
                    . " AND p.course_ID=( SELECT s.Course_ID FROM section s WHERE s.CRN='$CRN' )";
            $result_2 = mysqli_query($connection, $query);
            if (!$result_2) {
               die("unable to update projec").mysqli_error($connection);
            } 
        }   

    return 1;
}
function find_CourseClasses($connection, $courseid) {
    $query = "SELECT * FROM section sec join course c on sec.Course_ID = c.Course_ID"
            . " join faculty f on f.Fac_ID = sec.Fac_ID join room r on sec.Room_ID = r.Room_ID "
            . " where sec.Course_ID ='$courseid'";
      $result = mysqli_query($connection, $query);
      if (!$result) {
        die('could not find classes ' . mysqli_error($connection));
    }
    return generate_data($result, '', 'EnrollStudentToClass');
}

//echo find_CourseClasses($connection , 'INS468');

 function  update_AddDropApproval($connection, $crn,  $status, $requestType){
    $student_id = $_SESSION['student_ID'];
    $query = "Update adddropcourse set status ='$status' where CRN ='$crn' and student_id ='$student_id'";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("unable to update status" . mysqli_errno($connection));
    }
    if ($status == 'Approved'){
        if ($requestType === 'Drop') {
            return drop_course($connection, $crn, $student_id);
        }
        if ($requestType === 'Add') {
            return Add_course($connection, $crn, $student_id);
        }
    }
    return 'success';
 }
 function Add_course($connection, $CRN, $username){
       $query = "Insert into Course_enroll values($username, $CRN)";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("unable to insert into course_enroll".mysqli_error($result));
    } else {
        $query = "Update section s set s.EnrolledStudents = s.EnrolledStudents + 1 where s.CRN ='$CRN'";
        $result = mysqli_query($connection, $query);
          if (!$result ) {
           die("unable to update section".mysqli_error($result));
        }
        $query = "UPDATE projectiontable p set status ='Enrolled' where p.std_ID='$username' "
                . " AND p.course_ID=( SELECT s.Course_ID FROM section s WHERE s.CRN='$CRN' )";
        $result_2 = mysqli_query($connection, $query);
        if (!$result_2) {
           die("unable to update projection".mysqli_error($result_2));
        } 
    }
    return 'success';
       
}

 function Drop_course($connection, $crn, $username=''){
   $query = "DELETE c FROM course_enroll  c where (c.student_id ='$username' AND c.CRN ='$crn')";
    $result = mysqli_query($connection, $query);
     if(!$result){
        die("unable to delete from course enroll".mysqli_error($connection));
    } else {
      $query = "UPDATE projectiontable p set status ='Unenroll' where p.std_ID='$username' "
                . " AND p.course_ID=( SELECT s.Course_ID FROM section s WHERE s.CRN='$crn' )";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die("unable to update projectiontable".mysqli_error($connection));
        }else{
         $query = "Update section s set s.EnrolledStudents = s.EnrolledStudents - 1 where s.CRN ='$crn'";
        $result = mysqli_query($connection, $query);
        if (!$result) {
                die("unable to update enrolledStudents" . mysqli_error($connection));
            }
        }
       
    }
    return 'success';
}



function display_AddDropRequestedCourses($connection, $id) {
    $query = "Select * FROM adddropcourse ad join section s on ad.CRN = s.CRN join faculty f "
            . " on f.Fac_ID= s.Fac_ID join course c on s.Course_ID = c.Course_ID  join "
            . " room r on s.Room_ID = r.Room_ID where ad.student_id ='$id' AND ad.status  NOT in ('Pending')  ";
     $result = mysqli_query($connection, $query);
    return generate_data($result, '', 'addDropcart');
}

//echo display_AddDropRequestedCourses($connection, '201900112');
function getAddDropRequesteOnHoldOrNot($connection, $type, $studentid='') {
    $query = "SELECT * FROM  adddropcourse ad join student s on s.Std_ID = ad.student_id ";
    $query_2  = "SELECT Std_ID FROM student where Std_ID not in (SELECT student_id FROM  adddropcourse)";
    $result_2 = mysqli_query($connection, $query_2);
   $ids= array();
   
    while ($row = mysqli_fetch_array($result_2)) {
        $ids[] = $row['Std_ID'];
    }
    if ($studentid !=''){
        if ($type == 'Yes' ) {
        $query .= " where student_id='$studentid' and ad.status ='Requested'";
        }else{
            $query .= " where student_id='$studentid'  and ad.status not in ('Requested')";
        }
    }else{
         if ($type == 'Yes' ) {
        $query .= " where ad.status ='Requested'";
        }else{
            $query .= " where  ad.status not in ('Requested')";
        }
    }
     $query .= " Group BY student_id";
    $result = mysqli_query($connection, $query);
    $output = array();
//    echo $query_2;
    while ($row = mysqli_fetch_array($result)) {
        $output[] = $row['student_id'];
    }
   if ($type =='No' && $studentid ==''){
        return '"'.implode('","', $output).'",'.'"'.implode('","', $ids).'"';
   }
    return '"'.implode('","', $output).'"';
}
//echo getAddDropRequesteOnHoldOrNot($connection, 'No');
function display_students($connection, $id='', $CGPA='', $major='', $college='', $campus='', $AddDropOnholdstatus='') {
   $adddropOnholdstatus = getAddDropRequesteOnHoldOrNot($connection, $AddDropOnholdstatus);
 
 $query = "SELECT * FROM  student s join major m on s.Major_ID = m.Major_ID";
    if($id !=='' && $CGPA !=='' && $major !=='' && $college !=='' && $campus !=='' && $AddDropOnholdstatus !==''){
       $query .=" where s.Std_ID like '%$id%' AND s.Major_ID like '%$major%'  and m.College_ID like '%$college%' and "
               . " s.campus like '%$campus%' and s.CGPA > '$CGPA' and s.Std_ID in ($adddropOnholdstatus) ";
    }
    else if($id !==''){
        $query .=" where s.Std_ID like '%$id%'";
    }
     else if($major !==''){
        $query .=" where s.Major_ID like '%$major%'";
    }
      else if($college !==''){
        $query .=" where m.College_ID like '%$college%'";
    }
      else if($campus !==''){
        $query .=" where s.campus like '%$campus%'";
    }
      else if($CGPA !==''){
        $query .=" where s.CGPA > '$CGPA'";
    }
     else if($CGPA !==''){
        $query .=" where s.CGPA > '$CGPA'";
    }
    elseif ($AddDropOnholdstatus !=='') {
     $query .=" where  s.Std_ID in ($adddropOnholdstatus)";

   }
    $result = mysqli_query($connection, $query);
    return generate_student_data($result);
}
//echo display_students($connection, '', '', '', '', '', 'No');
function getTotalEnrolledCreditHour($connection, $username){

    $query = "SELECT c.Course_Credit FROM course_enroll e join section s on e.CRN = s.CRN "
            . " join course c on c.Course_ID =  s.Course_ID  "
            . "where e.student_id = '$username'";
     $result = mysqli_query($connection, $query);
     $totalCreditHours = 0; 
    while ($row = mysqli_fetch_array($result)) {
        $totalCreditHours += $row["Course_Credit"];
        }
        return $totalCreditHours;
}

function getStudentCGPA($connection, $username){
    $query = "SELECT CGPA FROM student s where s.Std_ID = '$username'";
     $result = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_array($result)) {
        return $row["CGPA"];
        }
}

function checkUnderEnrollStatus($CGPA, $totalCreditHours) {

      $total = $totalCreditHours;
     if(($CGPA >= 3.0) && ($total < 15))
         return 1;
    elseif (($CGPA >= 2.5) && ($total < 12)) {
         return 1;
     }
     elseif (($CGPA < 2.5) && ($total < 9)) {
         return 1;
     }
    else {
     return 0;
         
     }
}

function checkIsAddDropRequested($connection, $studentid) {
    $query = "SELECT * FROM  adddropcourse where student_id='$studentid' and status ='Requested'";
    $result = mysqli_query($connection, $query);
    if(mysqli_num_rows($result) > 0)
        return 1;
    else {
        return 0;  
    }
    
}

function generate_student_data($result) {
    global $connection;
    $output = array();
    while($row = mysqli_fetch_array($result)){
        $ID = $row['Std_ID'];
        $fname = $row['Std_FirstName'];
        $lname = $row['Std_LastName'];
        $email = $row['Std_Email'];
        $gender = $row['Gender'];
        $CGPA = $row['CGPA'];
        $major = $row['Major_ID'];
        $campus = $row['campus'];
        $college = $row['College_ID'];
        $status = $row['std_status'];
        $enrolledCHrs = getTotalEnrolledCreditHour($connection, $ID); 
        $isUnderEnroll = checkUnderEnrollStatus($CGPA, $enrolledCHrs)?'Yes':'No';
        $isAddDropRequested = checkIsAddDropRequested($connection, $ID)?'Yes':'No';
        $output[] = array('ID'=>$ID, 'fname'=>$fname, 'lname'=>$lname, 'email'=>$email,'gender'=>$gender,
                'CGPA'=>$CGPA, 'major'=>$major, 'campus'=>$campus, 'college'=>$college, 'status'=>$status,
                'enrolledCHrs'=>$enrolledCHrs, 'IsunderEnroll'=>$isUnderEnroll, 'IsAddDropRequested'=>$isAddDropRequested);
    }
    return json_encode($output);
}