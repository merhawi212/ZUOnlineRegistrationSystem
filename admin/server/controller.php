<?php

session_start();
 
     
include 'connection.php';
//include '../InternalHeader.html';
//include '../include/autoloader.inc.php';
//
// date_default_timezone_set('Asia/dubai');
        
if(isset($_POST['request_type']))
{
    $request_type = $_POST['request_type'];
    $returned_value="";
    switch ($request_type) {

       case "fetch_avaliable_sections":
            $returned_value = display_available_sections($connection, $_POST['course_ID'], $_POST['course_Name'],
                                            $_POST['subject'],  $_POST['instructor_name'],$_POST['major'], '');
            break;
        case "fetch_selected_section":
             $returned_value= display_selected_section($connection,  $_POST['crn']);    
            break;
         case "update_section":
             $returned_value= update_section($connection, $_POST['id'], $_POST['crn'],$_POST['secNo'],
                                          $_POST['instructor'], $_POST['meetingDay'], $_POST['time'], $_POST['loc']);    
            break;
         case "delte_section":
             $returned_value= delte_section($connection, $_POST['crn']);    
            break;
        case "add_section":
             $returned_value= add_section($connection, $_POST['crn'], $_POST['id'],$_POST['secNo'],
                                          $_POST['faculty_id'], $_POST['meetingDay'], $_POST['time'], $_POST['location'], '' );    
            break;
        case "fetch_CourseProjection":
             $returned_value= displayCourseProjection($connection, $_POST['id']);    
            break;
        case "fetch_enrolled_courses":
             $returned_value= displayEnrolledCourses($connection, $_POST['id']);    
            break;
        
        


    }
    echo $returned_value;
}
function displayEnrolledCourses($connection, $username){
$_SESSION['student_ID'] = $username;
     $query = "SELECT * FROM course_enroll enroll join section s on enroll.CRN = s.CRN "
             . " join course c on s.Course_ID = c.Course_ID join faculty f on f.Fac_ID= s.Fac_ID "
                . "join room r on s.Room_ID = r.Room_ID where enroll.student_id ='$username'";
     $result = mysqli_query($connection, $query);
      return generate_data($result, 'EnrolledCourses');

}

function displayCourseProjection($connection, $username)
 {
   $query = "SELECT * FROM projectiontable p "
           . "join course c on p.course_ID = c.Course_ID"
           . " where p.std_ID='$username'";
    $result = mysqli_query($connection,$query);
     return generate_CourseProjection($result);
  }
function add_section($connection, $crn, $id,  $secNo, $instructor_id, $meetingDay, $time, $loc, $campus) {
    $times= explode("-", $time);
    $startTime = $times[0];
   $endTime = trim($times[1]);
    if (!empty(display_selected_section($connection, $crn))){
        if (checkInstructorEligibility($connection, $meetingDay, $startTime,$instructor_id, $crn ) ===0 
           && checkRoomEligibility($connection, $meetingDay, $startTime, $loc, $crn) === 0){
                $query = "insert into section values ('$crn', '$secNo', '$meetingDay', '$startTime','$endTime', '$id', "
                        . " '$loc', '$instructor_id' ";
                if ($campus !=='')
                   $query .= ", '$campus'";
                $query .= ", '0' )";
                 $result = mysqli_query($connection, $query);
                  if(!$result){
                    die('unable to add section'.mysqli_error($connection));
                }
                return "success";
          }else {
              return "error";
          }
    }else{
        return "error";
    }
    return "success";
}
function delte_section($connection, $crn) {
    
    $query = "DELETE s FROM section AS s  WHERE  s.CRN ='$crn'";
     $result = mysqli_query($connection, $query);
      if(!$result){
        die('unable to delete section'.mysqli_error($connection));
    }
    return "success";
}
function update_section($connection, $id, $crn, $secNo, $instructor, $meetingDay, $time, $loc) {
  
    $times= explode("-", $time);
    $startTime = $times[0];
   $endTime = trim($times[1]);
   if (checkInstructorEligibility($connection, $meetingDay, $startTime,$instructor, $crn ) ===0 
           && checkRoomEligibility($connection, $meetingDay, $startTime, $loc, $crn) === 0){
    $query = "Update section set Section_NO = '$secNo', Meeting_Day='$meetingDay', Fac_ID='$instructor', "
            . " Course_ID ='$id',StartTime='$startTime', EndTime='$endTime', "
            . " Room_ID =(SELECT Room_ID FROM room WHERE Room_Location = '$loc' ) where CRN = '$crn'";
    $result = mysqli_query($connection, $query);
    if(!$result){
        die('unable to update section '.mysqli_error($connection));
    }
   } else {
       return "error";
   }
    return "success";
}

function display_selected_section($connection, $crn) {
    $query = "SELECT * FROM section sec join course c on sec.Course_ID = c.Course_ID join faculty f "
            . "  on f.Fac_ID = sec.Fac_ID join room r on sec.Room_ID = r.Room_ID where sec.CRN ='$crn'";
 
    $result = mysqli_query($connection, $query);
    
    return generate_data($result);
}
function display_available_sections($connection, $course_ID, $courseName, $subject, $instructor, $major, $dbtype) {
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
    
    return generate_data($result, '', '',  $dbtype);
}

function checkRoomEligibility($connection,$day, $startTime, $location, $CRN='') {
    $query = "SELECT * FROM section sec join course c on sec.Course_ID = c.Course_ID join faculty f "
            . "  on f.Fac_ID = sec.Fac_ID join room r on sec.Room_ID = r.Room_ID where ((sec.Meeting_Day & $day) > 0) "
            . " AND sec.StartTime ='$startTime' And  sec.Room_ID = '$location' ";
    $query .= " And sec.CRN not in ('$CRN')  Group by sec.CRN  ";
//    echo $query;
    $result = mysqli_query($connection,$query);
    $count = mysqli_num_rows($result);
//    echo json_encode(mysqli_fetch_array($result));
    if($count > 0)
        return 1;
    else 
        return 0;
}
//echo checkRoomEligibility($connection, '5', '11:00', '23', "22117");
function checkInstructorEligibility($connection,$day, $startTime, $instructor='', $CRN ='') {
    $query = "SELECT * FROM section sec join course c on sec.Course_ID = c.Course_ID join faculty f "
            . "  on f.Fac_ID = sec.Fac_ID join room r on sec.Room_ID = r.Room_ID where ((sec.Meeting_Day & $day) > 0) "
            . " AND sec.StartTime ='$startTime' And  sec.Fac_ID = '$instructor'  ";
    $query .= " AND sec.CRN not in ('$CRN')  Group by sec.CRN ";
    
    $result = mysqli_query($connection,$query);
    $count = mysqli_num_rows($result);
//    echo json_encode(mysqli_fetch_array($result));
    if($count > 0 )
        return 1;
    else 
        return 0;
}
//echo checkInstructorEligibility($connection, '5', '11:00', 'z2344', '22112' );
function generate_CourseProjection($result){
    $output=array();
    while ($row = mysqli_fetch_array($result)) {
          $status=($row["status"] =='Enrolled')?'Enrolled':'Uneroll';
        $output[]=array("id"=>$row["Course_ID"],"courseName"=>$row["Course_Name"],
            "subject"=>$row["Course_subject"],
            "CreditHour"=>$row["Course_Credit"], 'Major'=>$row["Major_ID"],'status'=>$status);
    }
     return json_encode($output); 
}
function checkConflict($connection, $day, $startTime, $CRN){
     $username = $_SESSION['student_ID'];
   $query = "SELECT * FROM adddropcourse c join  section s on s.CRN = c.CRN where c.CRN not in ($CRN)"
           . " AND c.student_id='$username' AND ((s.Meeting_Day & $day) > 0) AND  "
           . " s.StartTime ='$startTime' And c.status not in ('Approved', 'Rejected') Group by c.CRN";
    $result = mysqli_query($connection,$query);
    $count = mysqli_num_rows($result);
    if($count > 0)
        return 1;
    else 
        return 0;
   
}
function checkConflict_2($connection, $day, $startTime, $crn=''){
   $username = $_SESSION['student_ID'];
   $query = "SELECT * FROM course_enroll e join  section s on s.CRN = e.CRN  "
           . " where  ( e.student_id='$username' AND ((s.Meeting_Day & $day) > 0) AND  "
           . " s.StartTime ='$startTime') ";
    $result = mysqli_query($connection,$query);
    $count = mysqli_num_rows($result);

    if( $count > 0 )
        return 1;
    else 
        return 0;
   
}
//echo checkConflict($connection, '5', '11:00', '22112');
function generate_data($result, $type='', $requestFrom='', $dbtype=''){
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
       $status ='';
       if ($requestFrom == 'addDropcart') {
            $RequestType = $row["RequestType"];
            $AddDropRequestedTime =date_format(date_create($row['RequestedDateTime']),"M d, Y H:i:s A"); ;
            $AddDropReqStatus = $row['status'];
            
            if(checkConflict($connection, intval($MeetingDay), $StartTime, $CRN)===1){
             $status ='conflict';
          }
        }
        $campus = '';
        if ($dbtype =='GenerateClassDB'){
            $campus = $row['campus'];
            if ($campus ==='ADF')
                $sectionNum  = '00'.$sectionNum;
        }
        if ($requestFrom =='EnrollStudentToClass'){
           if(checkConflict_2($connection, intval($MeetingDay), $StartTime, $CRN)===1){
             $status ='conflict';
          }  
        }
        $enrolledDateTime ='';
        if ($type == 'EnrolledCourses') {
            $enrolledDateTime = date_format(date_create($row['dateTime']),"M d, Y H:i:s A");
        }  
       if($type =='addDrop' || $type ==''|| $type == 'EnrolledCourses' || ($type=='ToGA' && $NumofEnrolledStudents < $RoomCapacity)){
         $output[]=array("id"=>$id,"courseName"=>$courseName,"subject"=>$subject,"CreditHour"=>$credit,
             'Major'=>$major, 'section_No'=>$sectionNum,'CRN'=>$CRN, 'InstructorID'=>$instructor_id, 'Instructor'=>$instructor,"MeetingDay"=>$MeetingDay,
             "StartTime"=>$StartTime,"EndTime"=>$EndTime,"RoomCapacity"=> $RoomCapacity, "RoomLocation"=> $RoomLocation,
             "SeatLeft"=> $seatleft, 'RoomCapacity'=>$RoomCapacity,"NumofEnrolledStudents"=>$NumofEnrolledStudents, 'conflict'=>$status, 
           'RequestType'=> $RequestType, 'AddDropRequestedTime' => $AddDropRequestedTime,'AddDropReqStatus'=>$AddDropReqStatus,
            'campus'=>$campus, 'EnrolledDateTime'=>$enrolledDateTime,  'countrows'=>$count);
       }

    } 
     return json_encode($output); 
    }
  
//    session_destroy();