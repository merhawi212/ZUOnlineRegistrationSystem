<?php

 date_default_timezone_set('Asia/dubai');

require 'controller.php';
if(isset($_POST['request_type']))
{
    $request_type = $_POST['request_type'];
    $returned_val ='';
    switch ($request_type) {
        case "get_default_Schedule":
             $returned_val =  dis_sections($connection);
             break;
        case "load_courses_data_from_cart":
             $returned_val = fetch_CoursesIn_cart($connection);
             break;
        case "load_instructors";
            $returned_val = fetch_instructors($connection, $_POST['courses_ids']);
             break;
       
         case "delete_section_By_courseID":
             $returned_val = delete_CoursesIn_cart($connection, $_POST['course_id']);
             break;
          case "load_courses_data_fromProjection":
             $returned_val = fetch_remainCoursesFromProjection($connection);
             break;
        case "bulid_Schedule_based_On_Input":
          $returned_val = fetch_selected_section($connection, $_POST['instructor_ids'],  $_POST['days'],$_POST['startTime'],$_POST['endTime'] );
          break;
       case "enroll_course_By_CRN":
             $returned_val= register_courses($connection, $_POST['CRN_IDs']);
             break;
        case "load_UnEnrolled_courses":
             $returned_val= loadUnenrolledCourses($connection);
             break;
        case "fetch_addDropCart":
             $returned_val= fetchsavedcoursesInaddDropcart($connection);
             break;
        case "addDropCart":
             $returned_val= addDropcart($connection, $_POST['CRN_IDs'], $_POST['ReqType']);
             break;
         case "remove_addDropCourseFromCart":
             $returned_val= remove_addDropCourseFromCart($connection, $_POST['CRN']);
             break;
         case "submit_AddDropRequest":
             $returned_val= submit_AddDropRequest($connection);
             break;
         case "get_existingAddDropRequest":
             $returned_val= display_AddDropRequestedCourses($connection, $_POST['CourseID'], $_POST['CourseName'], $_POST['CRN'],
                                                            $_POST['Major'], $_POST['ReqType'], $_POST['status']);
             break;
         case "track_student":
             $returned_val= track_student($connection);
             break;
         
        default:
            break;
    }
    echo $returned_val;
}
function submit_AddDropRequest($connection) {
    $username = $_SESSION['login'];
    $now = date('Y-m-d h:i:s', time());
    $query = "Update adddropcourse set status ='Requested', RequestedDateTime='$now' where student_id ='$username' ";
     $result = mysqli_query($connection, $query);
     if(!$result){
        die("unable update addDropcourse ".mysqli_error($connection));
    } 
    else{
        $query = "UPDATE track_student SET IsAddDropCourse =True WHERE student_id ='$username' ";
       
         $result = mysqli_query($connection, $query);
         if(!$result){
            die("unable to update track_student".mysqli_error($connection));
        } 
    }
    return 'success';
}

function remove_addDropCourseFromCart($connection, $crn) {
    $username = $_SESSION['login'];
    $query = "DELETE c FROM adddropcourse c where c.student_id ='$username' AND c.CRN ='$crn'";
     $result = mysqli_query($connection, $query);
     if(!$result){
        die("unable to delete from cart".mysqli_error($connection));
    } 
    return 'success';
}
function track_student($connection) {
      $username = $_SESSION['login'];
    $query = "Select *  from track_student where student_id = '$username'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);
    $isPerformAddDrop = $row['IsAddDropCourse']?'disabled':'';
    $isRegistered = $row['IsRegistered']?'disabled':'';
    return json_encode(['isPerformedAddDrop'=>$isPerformAddDrop, 'isRegistered'=>$isRegistered]);
}

function display_AddDropRequestedCourses($connection, $id, $name, $crn, $major, $reqType, $status) {
     $username = $_SESSION['login'];
    $query = "Select * FROM adddropcourse ad join section s on ad.CRN = s.CRN join faculty f "
            . " on f.Fac_ID= s.Fac_ID join course c on s.Course_ID = c.Course_ID  join "
            . " room r on s.Room_ID = r.Room_ID where ad.student_id ='$username' AND ad.status  NOT in ('Pending')  ";
    if ($id !== '' && $name !=='' && $crn !== '' && $major !==''  ) {
        $query .= " and c.Course_ID like '%$id%' and s.CRN like '%$crn%' and  "
                . "   c.Course_Name like '%$name%' and c.Major_ID like '%$major%'";
    }
    else if ( $reqType !=='' && $status !=='') {
        $query .= " and ad.RequestTypee  like '%$reqType%' and  ad.status  like '%$status%'";
    }
    else if($id !==''){
        $query .= " and  c.Course_ID like '%$id%'";
    }
    else if($name !==''){
        $query .= " and  c.Course_Name like '%name%'";
    }
    else if($crn !==''){
        $query .= " and  s.CRN like '%$crn%'";
    }
    
     else if($major !==''){
        $query .= " and c.Major_ID like '%$major%'";
    }
    else if($reqType !==''){
        $query .= " and ad.RequestTypee  like '%$reqType%'";
    }
     else if($status !==''){
        $query .= " and  ad.status  like '%$status%'";
    }
     $result = mysqli_query($connection, $query);
    return generate_data($result, '', 'addDropcart');
}
//echo display_AddDropRequestedCourses($connection);
function fetchsavedcoursesInaddDropcart($connection) {
     $username = $_SESSION['login'];
    $query = "Select * FROM adddropcourse ad join section s on ad.CRN = s.CRN join faculty f "
            . " on f.Fac_ID= s.Fac_ID join course c on s.Course_ID = c.Course_ID  join "
            . " room r on s.Room_ID = r.Room_ID where ad.student_id ='$username' AND ad.status ='Pending'";
     $result = mysqli_query($connection, $query);
    return generate_data($result, '', 'addDropcart');
}
//echo fetchsavedcoursesInaddDropcart($connection);
function addDropcart($connection, $crn, $requestType){
     $username = $_SESSION['login'];
    $i = 0;
    $count = count($crn);
    $res = '';
    while ($i < $count){
        $query = "Select  * FROM adddropcourse where CRN = '$crn[$i]' and student_id ='$username'";
        $result = mysqli_query($connection, $query);
         if(mysqli_num_rows($result) !=0)
                 $res = 'error';
         else{
            $query = "Insert into adddropcourse (student_id, CRN, RequestType) values ('$username', '$crn[$i]', '$requestType')";
            $result = mysqli_query($connection, $query);
            if(!$result)
                    $res = 'error';
            else {
                $res = 'success';
            }
         }
        $i++;
    }
    return $res;  
}


function dis_sections($connection) {
       $username = $_SESSION['login'];
        $query = "SELECT  * FROM cart join student s on cart.student_id = '$username' "
                . "join course c on cart.course_id = c.Course_ID JOIN section sec "
                . "on sec.Course_ID = c.Course_ID join faculty f on f.Fac_ID= sec.Fac_ID "
                . "join room r on sec.Room_ID = r.Room_ID";
       
        $result = mysqli_query($connection, $query);

          return display_result($result, 'ToGA');  
}

function fetch_CoursesIn_cart($connection) {
     $username = $_SESSION["login"];
     $query = "SELECT * FROM cart c join course co on c.course_id = co.Course_ID "
             . "where c.student_id ='$username' ";
//     echo $query;
     $result = mysqli_query($connection, $query);
      return generate_CourseCart($result);
    
}

function fetch_instructors($connection, $courses_ids){
  $id = "".implode("','", $courses_ids)."";
    $query = "Select * FROM section s join faculty f on f.Fac_ID= s.Fac_ID join course c "
            . "on s.Course_ID = c.Course_ID  join room r on s.Room_ID = r.Room_ID"
            . " where s.Course_ID in('$id') Group by f.Fac_ID";
     $result = mysqli_query($connection, $query);
     return generate_data($result);

}
function delete_CoursesIn_cart($connection, $courseID){
     $username = $_SESSION["login"];
     $query = "DELETE c FROM cart as c where c.student_id ='$username' AND c.course_id ='$courseID'";
     $result = mysqli_query($connection, $query);
     if(!$result){
        die("unable to delete from cart".mysqli_error($connection));
    } else {
       $query = "UPDATE projectiontable p set status ='Unenroll' where p.std_ID='$username' AND p.course_ID='$courseID'";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die("unable to update projectiontable".mysqli_error($connection));
        }
    }
    return dis_sections($connection);
    
}
function fetch_remainCoursesFromProjection($connection){
    $username = $_SESSION["login"];
   $query = "SELECT * FROM projectiontable p join student s on p.std_ID = s.Std_ID "
           . "join course c on p.course_ID = c.Course_ID"
           . " where p.std_ID='$username' AND p.status='Unenroll'";
    $result = mysqli_query($connection,$query);
     return generate_CourseProjection($result);
}

function loadUnenrolledCourses($connection) {
       $username = $_SESSION["login"];
   $query = "SELECT * FROM projectiontable p join student s on p.std_ID = s.Std_ID "
           . "join course c on p.course_ID = c.Course_ID"
           . " where p.std_ID='$username' AND (p.status='Unenroll' OR p.status='Pending')";
    $result = mysqli_query($connection,$query);
     return generate_CourseProjection($result);
}

function fetch_selected_section($connection, $instructors_id, $days, $startTime, $endTime) {
    $username = $_SESSION['login'];
      $query = "Select * FROM section s join faculty f on f.Fac_ID= s.Fac_ID join course c "
            . " on s.Course_ID = c.Course_ID  join room r on s.Room_ID = r.Room_ID"
            . " join cart on cart.course_id = c.Course_ID where cart.student_id = '$username'  "
              . " AND ((s.Meeting_Day  & $days) > 0) AND ( s.StartTime >= '$startTime' AND s.EndTime <= '$endTime') ";
      
    if(!empty($instructors_id) != 0){
        $id = "".implode("','", $instructors_id)."";
        $query .= " AND s.Fac_ID in('$id') ";
    }
    
     $result = mysqli_query($connection, $query);
     if (!$result) {
        die("unable to filter" . mysqli_error($connection));
    }
    return display_result($result, 'ToGA');
}
//echo fetch_selected_section($connection, '', '', '13:50', '');
function getEnrolledCreditHours($connection){
     $username = $_SESSION['login'];
    $query = "SELECT c.Course_Credit FROM course_enroll e join section s on e.CRN = s.CRN "
            . " join course c on s.Course_ID = c.Course_ID "
            . "where e.student_id = '$username'";
     $result = mysqli_query($connection, $query);
     $totalCreditHours = 0; 
    while ($row = mysqli_fetch_array($result)) {
        $totalCreditHours += $row["Course_Credit"];
        }
        return $totalCreditHours;
}

function register_courses($connection, $CRNs) {
    $username = $_SESSION["login"];
     if ( !empty($CRNs) ) { 
            $CRNs = is_array($CRNs)?$CRNs:explode(",", $CRNs);     
           if(checkOutRegistrationProcess($connection, $CRNs)== 1){
               $query = "UPDATE track_student SET IsRegistered =True WHERE student_id ='$username' ";
                $result = mysqli_query($connection, $query);
                if (!$result) {
                    die("unable to update track_student" . mysqli_error($connection));
                 }
               
            return 'success';
           }
            return 'error';
        }
        else {
            return "error";
        }
        
}

function checkOutRegistrationProcess($connection, $CRNs){
    $i = 0;
    $count = count($CRNs);
     $username = $_SESSION["login"];
    while ($i < $count){
         $now= date('Y-m-d h:i:s', time());
        $query = "Insert into Course_enroll values('$username', '$CRNs[$i]', '$now')";
        $result = mysqli_query($connection, $query);
//        echo $query;
        if (!$result) {
//             die("unable to update projec").mysqli_error($connection);
            return 0;
        } 
        
        else {
            $query = "Update section s set s.EnrolledStudents = s.EnrolledStudents + 1 where s.CRN ='$CRNs[$i]'";
//            echo $query .'<br>';
            $result = mysqli_query($connection, $query);
              if (!$result ) {
               die("unable to update section").mysqli_error($connection);
            }
            $query = "UPDATE projectiontable p set status ='Enrolled' where p.std_ID='$username' "
                    . " AND p.course_ID=( SELECT s.Course_ID FROM section s WHERE s.CRN='$CRNs[$i]' )";
//            echo $query .'<br>';
            $result_2 = mysqli_query($connection, $query);
            if (!$result_2) {
               die("unable to update projec").mysqli_error($connection);
            } 
        }   
        $i++;
    }
    return 1;
}
//echo register_courses($connection, '22111, 22112');

function display_result($result, $type) {
    $error = "<tr><td colspan='11' style='text-align:center'>Search Not Avaliable! Please Search Again.</td></tr>";
    if(mysqli_num_rows($result)==0){
         return $error;
     }
    else {
        $temp = generate_data($result, $type);
        $res = $temp;
        if(!empty(json_decode($temp))){
          $data = new Data($res);
        $driver = new Driver($data);
        return $driver->displayDriver();
     }
    else {
         return $error;
        }
    }
}