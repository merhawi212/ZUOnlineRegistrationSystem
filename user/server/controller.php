<?php
session_start();
 
     
include 'connection.php';
include '../include/autoloader.inc.php';
        
if(isset($_POST['request_type']))
{
    $request_type = $_POST['request_type'];
    $returned_value="";
    switch ($request_type) {
 
        case "fetch_avaliable_courses":
            $returned_value = display_courseProjection($connection);
            break;

         case "fetch_avaliable_sections":
            $returned_value = display_available_sections($connection, $_POST['course_ID'], $_POST['course_Name'],
                                            $_POST['subject'],  $_POST['instructor_name'],$_POST['major'] );
            break;
        case "store_Selected_Course_ID":
             $returned_value = Store_CourseID($connection, $_POST['courses_ID']);
             break;
         case "fetch_schedule":
             $returned_value = fetchScheduleResult($connection);
             break;
         case "fetch_enrolled_courses":
             $returned_value = fetch_EnrolledCourses($connection);
             break;
          case "drop_section":
             $returned_value = drop_course($connection, $_POST['CRN']);
             break;
          case "get_sections_by_CourseID":
             $returned_value = getCourseSections($connection, $_POST['course_ID']);
             break;
        case "submit_pin":
            $returned_value = verify_pin($connection,$_POST['Pin'], $_POST['type']);
            break;
         
       
        

    }
    echo $returned_value;
}
function  verify_pin($connection, $pin, $type=''){
    
    $username = $_SESSION["login"];
    $query = "SELECT * FROM user_pin  p where p.student_id = '$username' AND p.pin ='$pin'";
    $result = mysqli_query($connection, $query);
    $rows = mysqli_num_rows($result);
    if($rows == 1){
        if ($type !== '' && $type == 'coursesTable') {
            $_SESSION['pinForRegistration'] = $pin;
        } elseif ($type !== '' && $type == 'AddDropPage') {
            $_SESSION['pinForAddDrop'] = $pin;
        }
        return 'success';
       
    }
    else 
        return 'error';
    
}
//echo verify_pin($connection, '4321');
function getCourseSections($connection, $courseid){
     $username = $_SESSION["login"];
   $query = "SELECT * FROM projectiontable p join student s on p.std_ID = s.Std_ID "
           . "join course c on p.course_ID = c.Course_ID join section sec on sec.Course_ID = c.Course_ID "
           . " join faculty f on f.Fac_ID= sec.Fac_ID join room r on sec.Room_ID = r.Room_ID "
           . " where (p.status ='Unenroll' OR p.status ='Pending') AND p.std_ID ='$username' ";
   if (!empty($courseid)) {
        $query .= " AND c.Course_ID ='$courseid'";
    }
    $query .="  Group BY sec.CRN";
    $result = mysqli_query($connection,$query);
     return generate_data($result, 'addDrop');
}
function checkConflict($connection, $day, $startTime, $crn=''){
     $username = $_SESSION["login"];
   $query = "SELECT * FROM course_enroll e join  section s on s.CRN = e.CRN  "
           . " where  ( e.student_id='$username' AND ((s.Meeting_Day & $day) > 0) AND  "
           . " s.StartTime ='$startTime') ";
//   echo $query;
    $result = mysqli_query($connection,$query);
    $count = mysqli_num_rows($result);
    $query_2 = "select * from adddropcourse ad  "
            . "where ad.student_id='$username' and ad.CRN in (SELECT e.CRN FROM course_enroll e join  section s on s.CRN = e.CRN  "
           . " where  ( e.student_id='$username' AND ((s.Meeting_Day & $day) > 0) AND  "
           . " s.StartTime ='$startTime') )";
//   echo $query_2;
    $result_2= mysqli_query($connection,$query_2);
    $count_2 = mysqli_num_rows($result_2);
//    echo $count;
//    echo 'adddrop'.$count_2.'<br>';
    if( $count > 0 && $count_2 == 0)
        return 1;
    else 
        return 0;
   
}
//echo checkConflict($connection, 5, '15:00:00');
function drop_course($connection, $crn){
     $username = $_SESSION["login"];
     $query = "DELETE c FROM course_enroll  c where (c.student_id ='$username' AND c.CRN ='$crn')";
     $result = mysqli_query($connection, $query);
//     echo $query
     if(!$result){
        die("unable to delete from course enroll".mysqli_error($connection));
    } else {
       $query = "UPDATE projectiontable p set status ='Unenroll' where p.std_ID='$username' AND p.course_ID='$crn'";
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
//     return "success";
    return fetch_EnrolledCourses($connection);
}
//drop_course($connection, $crn)
function fetch_EnrolledCourses($connection){
    $username = $_SESSION["login"];
     $query = "SELECT * FROM course_enroll enroll join section s on enroll.CRN = s.CRN "
             . " join course c on s.Course_ID = c.Course_ID join faculty f on f.Fac_ID= s.Fac_ID "
                . "join room r on s.Room_ID = r.Room_ID where enroll.student_id ='$username'";
     $result = mysqli_query($connection, $query);
      return generate_data($result, 'EnrolledCourses');
}
//echo fetch_EnrolledCourses($connection);
function display_courseProjection($connection)
 {
   $username = $_SESSION["login"];
   $query = "SELECT * FROM projectiontable p join student s on p.std_ID = s.Std_ID "
           . "join course c on p.course_ID = c.Course_ID"
           . " where p.std_ID='$username'";
    $result = mysqli_query($connection,$query);
     return generate_CourseProjection($result);
  }
//echo display_courseProjection($connection);
function getStudentCGPA($connection){
    $username = $_SESSION['login'];
    $query = "SELECT CGPA FROM student s where s.Std_ID = '$username'";
     $result = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_array($result)) {
        return $row["CGPA"];
        }
}
function getCourseCreditHour($connection){
     $username = $_SESSION['login'];
    $query = "SELECT c.Course_Credit FROM cart ca join course c on ca.course_id = c.Course_ID "
            . "where ca.student_id = '$username'";
     $result = mysqli_query($connection, $query);
     $totalCreditHours = 0; 
    while ($row = mysqli_fetch_array($result)) {
        $totalCreditHours += $row["Course_Credit"];
        }
        return $totalCreditHours;
}


function checkEligibility($connection,$id, $CGPA, $totalCreditHours, $type) {
    if ($type == 'DuringRegistration') {
        $query = "SELECT c.Course_Credit FROM course c where c.Course_ID = '$id' ";
    }
    if ($type == 'AddDropWeek') {
         $ids = "".implode("','", $id)."";
        $query = "SELECT c.Course_Credit FROM course c join section sec on sec.Course_ID =c.Course_ID"
                . "  where  sec.CRN in ('$ids')";
        
    }
    $result = mysqli_query($connection, $query);
     $creditHr = 0;
    while ($row = mysqli_fetch_array($result)) {
        $creditHr += $row["Course_Credit"];
        }
        $total = $totalCreditHours + $creditHr;
     if(($CGPA >= 3.4) && ($total <= 19))
         return 1;
    elseif (($CGPA >= 2.2) && ($total <= 15)) {
         return 1;
     }
     elseif (($CGPA < 2.2) && ($total <= 11)) {
         return 1;
     }
    else {
     return 0;
         
     }
}
  function Store_CourseID($connection, $course_id){
    
    $username = $_SESSION['login'];
    $CGPA =  getStudentCGPA($connection);
    $totalCreditHours = getCourseCreditHour($connection);
    $type ='DuringRegistration';
    if (checkEligibility($connection, $course_id, $CGPA, $totalCreditHours, $type) == 1) {
        $query = "INSERT INTO cart (student_id, course_id) VALUES ('$username', '$course_id')";
        $result = mysqli_query($connection, $query);
        if (!$result) {
            die("unable to insert into cart" . mysqli_error($connection));
        } else {
            $query = "UPDATE projectiontable p set status ='Pending' where p.std_ID='$username' AND p.course_ID='$course_id'";
            $result = mysqli_query($connection, $query);
            
        }
         return "success";
    } else {
        return "error";
    }
}

  
function display_available_sections($connection, $course_ID, $courseName, $subject, $instructor, $major) {
    $query = "SELECT * FROM section sec join course c on sec.Course_ID = c.Course_ID"
            . " join faculty f on f.Fac_ID = sec.Fac_ID join room r on sec.Room_ID = r.Room_ID ";
    if ($course_ID !== '' && $subject !=='' && $courseName !== '' && $major !=='' && $instructor !=='') {
        $query .= " where c.Course_ID like '%$course_ID%' and c.Course_subject like '%$subject%' "
                . " and c.Course_Name like '%$courseName%' and f.Fac_FirstName like '%$instructor%"
                . " and c.Major_ID like '%$major%'";
    }
    else if($course_ID !==''){
        $query .= " where c.Course_ID like '%$course_ID%'";
    }
    else if($subject !==''){
        $query .= " where c.Course_subject like '%$subject%'";
    }
    else if($courseName !==''){
        $query .= " where c.Course_Name like '%$courseName%'";
    }
    else if($instructor !==''){
        $query .= " where f.Fac_FirstName  like '%$instructor%'";
    }
     else if($major !==''){
        $query .= " where c.Major_ID like '%$major%'";
    }
    $result = mysqli_query($connection, $query);
    
    return generate_data($result);
}

//echo display_valiable_sections($connection, '', '', '', '', '');

function generate_CourseCart($result){
    $output=array();
    while ($row = mysqli_fetch_array($result)) {
        $output[]=array("id"=>$row["Course_ID"],"courseName"=>$row["Course_Name"],
            "subject"=>$row["Course_subject"],
            "CreditHour"=>$row["Course_Credit"], 'Major'=>$row["Major_ID"]);
    }
     return json_encode($output); 
}

  function generate_CourseProjection($result){
    $output=array();
    while ($row = mysqli_fetch_array($result)) {
          $status=$row["status"];
          if($status == 'Pending' || $status == 'Enrolled')
              $status ='disabled';
          else {
             $status =''; 
          }
        $output[]=array("id"=>$row["Course_ID"],"courseName"=>$row["Course_Name"],
            "subject"=>$row["Course_subject"],
            "CreditHour"=>$row["Course_Credit"], 'Major'=>$row["Major_ID"],'status'=>$status);
    }
     return json_encode($output); 
}


  function generate_data($result, $type='', $requestFrom=''){
    $output=array();
    $count= 0;
    global $connection;
    while ($row = mysqli_fetch_array($result)) {
        $id=$row["Course_ID"];          $courseName=$row["Course_Name"];
       $subject=$row["Course_subject"];  $credit=$row["Course_Credit"];
       $major=$row["Major_ID"];         $sectionNum= $row["Section_NO"];  $CRN=$row["CRN"];
       $instructor =$row["Fac_FirstName"].', '.$row["Fac_LastName"]; $instructor_id = $row["Fac_ID"];
       $MeetingDay = $row["Meeting_Day"]; 
//       $status=$row["status"]?"disabled":"";
       $StartTime = date_format(new DateTime($row["StartTime"]),'H:i');
       $EndTime = date_format(new DateTime($row["EndTime"]),'H:i');
       $RoomCapacity = intval($row["capacity"]); $RoomLocation = $row["Room_Location"];
       $NumofEnrolledStudents = intval($row["EnrolledStudents"]) ; $count++;
       $seatleft = $RoomCapacity - $NumofEnrolledStudents;
       $RequestType ='';
       $AddDropReqStatus = '';
       $AddDropRequestedTime = '';
       $enrolledDateTime='';
       if ($type == 'EnrolledCourses') {
            $enrolledDateTime = date_format(date_create($row['dateTime']),"M d, Y H:i:s A");
        }
        if ($requestFrom == 'addDropcart') {
            $RequestType = $row["RequestType"];
            $AddDropRequestedTime = date_format(date_create($row['RequestedDateTime']),"M d, Y H:i:s A");
            $AddDropReqStatus = $row['status'];
        }
        $status = '';
       if($type =='addDrop' && (checkConflict($connection, intval($MeetingDay), $StartTime, $CRN)==1)){
           $status ='disabled';
       }
           
       if($type =='addDrop' || $type =='' || ($type=='ToGA' && $NumofEnrolledStudents < $RoomCapacity) || $type == 'EnrolledCourses'){
         $output[]=array("id"=>$id,"courseName"=>$courseName,"subject"=>$subject,"CreditHour"=>$credit,
             'Major'=>$major, 'section_No'=>$sectionNum,'CRN'=>$CRN, 'InstructorID'=>$instructor_id, 'Instructor'=>$instructor,"MeetingDay"=>$MeetingDay,
             "StartTime"=>$StartTime,"EndTime"=>$EndTime,"RoomCapacity"=> $RoomCapacity, "RoomLocation"=> $RoomLocation,
             "SeatLeft"=> $seatleft, 'RoomCapacity'=>$RoomCapacity,"NumofEnrolledStudents"=>$NumofEnrolledStudents, 'conflict'=>$status, 
           'RequestType'=> $RequestType, 'AddDropRequestedTime' => $AddDropRequestedTime,'AddDropReqStatus'=>$AddDropReqStatus, 
             'enrolledDateTime'=>$enrolledDateTime, 'countrows'=>$count);
       }

    } 
     return json_encode($output); 
    }
  
//session_write_close();

//function display_sections($connection)
//{
////    allselectedCourses is decleared in the script file
////    $_COOKIE['selectedCourses'] = ['CIT461', 'CIT460', 'SEC435'];
//    if ( ! empty( $_SESSION['CourseID'] ) ) { 
//        $str = explode(",", $_SESSION['CourseID']);
//        array_walk($str, create_function('&$val',
//                    '$val = trim($val);'));
//        $temp = "'".implode("','", $str)."'";
// 
//        $query = "SELECT * FROM section sec join course c on sec.Course_ID = c.Course_ID"
//            . " join faculty f on f.Fac_ID= sec.Fac_ID join room r on sec.Room_ID = r.Room_ID"
//            . " where sec.Course_ID in($temp)";
////        echo $query;
//        $result = mysqli_query($connection, $query);
//        return generate_data($result);
//    } 
//  
//}

//session_destroy();