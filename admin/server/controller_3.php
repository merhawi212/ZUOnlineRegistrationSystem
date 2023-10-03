<?php
require 'connection_2.php';

include '../include/autoloader.inc.php';
require 'controller.php';

if(isset($_POST['request_type']))
{
    $request_type = $_POST['request_type'];
    $returned_value="";
    switch ($request_type) {
        
        case 'generate_class_schedule':
            $returned_value = generateClassSchedule();
            break;
         case 'fetch_generated_class_schedule':
            $returned_value = display_available_sections($connection_2, $_POST['course_ID'], $_POST['course_Name'],
                                            $_POST['subject'],  $_POST['instructor_name'],$_POST['major'], 'GenerateClassDB' );
            break;
        case 'fetch_selected_section_ToEdit':
            $returned_value = display_selected_section($connection_2, $_POST['crn']);
            break;
        case 'update_GeneratedClasses':
            $returned_value = update_section($connection_2, $_POST['id'], $_POST['crn'],$_POST['secNo'],
                                          $_POST['instructor'], $_POST['meetingDay'], $_POST['time'], $_POST['loc']);
            break;
         case "add_sectionToGeneratedClasses":
             $returned_value= add_section($connection_2, $_POST['crn'], $_POST['id'],$_POST['secNo'],
                                          $_POST['faculty_id'], $_POST['meetingDay'], $_POST['time'], $_POST['location'], $_POST['campus'] );    
            break;
         case "delte_sectionFromCreatedClasses":
             $returned_value= delte_section($connection_2, $_POST['crn']);    
            break;
        case "fetch_courses":
             $returned_value= displayCourses($connection_2, $_POST['CourseID'],$_POST['CourseName'],$_POST['major']);    
            break;
        case "fetch_selected_course_ToEdit":
             $returned_value= display_selected_course($connection_2, $_POST['id']);    
            break;
        case "update_Courses":
             $returned_value= update_Courses($connection_2, $_POST['id'],$_POST['name'],$_POST['max_students'],$_POST['major'],
                                     $_POST['credit_Hours'],$_POST['dxb'],$_POST['adm'],$_POST['adf']);    
            break;
          case "add_course":
             $returned_value= add_course($connection_2, $_POST['id'],$_POST['name'], $_POST['subject'],$_POST['max_students'],
                                     $_POST['major'],$_POST['credit_Hours'],$_POST['dxb'],$_POST['adm'],$_POST['adf']);    
            break;
        case "delete_course":
             $returned_value= delete_course($connection_2, $_POST['id']);    
            break;
        case "fetch_instructors":
             $returned_value= displayCourse_Instructors($connection_2, '', $_POST['InstructorName']);    
            break;
         case "fetch_selected_instructor_ToEdit":
             $returned_value= displayCourse_Instructors($connection_2, $_POST['id']);    
            break;
          case "update_faculty_course":
             $returned_value= update_faculty_course($connection_2, $_POST['faculty_id'], $_POST['courseid']);    
            break;
        case "delete_faculty_course":
             $returned_value= delete_faculty_course($connection_2, $_POST['faculty_id']);    
            break;
        case "add_course_instructor":
             $returned_value= add_faculty_course($connection_2, $_POST['faculty_id'], $_POST['courseid']);    
            break;
        
         case "fetch_rooms":
             $returned_value= displayRoom($connection_2);    
            break;
        case "fetch_selected_room_ToEdit":
             $returned_value= displayRoom($connection_2,  $_POST['id']);    
            break;
         case "update_room":
             $returned_value= update_Room($connection_2,  $_POST['roomid'],$_POST['location'],$_POST['capacity'],$_POST['campus']);    
            break;
        case "add_room":
             $returned_value= add_Room($connection_2,  $_POST['roomid'],$_POST['location'],$_POST['capacity'],$_POST['campus']);    
            break;
        case "delete_room":
             $returned_value= delete_Rooom($connection_2,  $_POST['id']);    
            break;
        case "fetch_meetingTimes":
             $returned_value= displayMeetingTime($connection_2);    
            break;
        case "fetch_selected_meetingTimes":
             $returned_value= displayMeetingTime($connection_2, $_POST['id']);    
            break;
        case "add_meetingTimes":
             $returned_value= add_meetingTimes($connection_2, $_POST['meetingTimesID'], $_POST['days'], $_POST['startTime'], $_POST['endTime']);    
            break;
        case "delete_meetingTimes":
             $returned_value= delete_meetingTimes($connection_2, $_POST['id']);    
            break;
          case "update_meetingTimes":
             $returned_value= update_meetingTimes($connection_2, $_POST['meetingTimesID'], $_POST['days'], $_POST['startTime'], $_POST['endTime']);    
            break;
        
        default :
            break;
    }
    echo $returned_value;
}
function update_meetingTimes($connection, $id, $days, $startTime, $endTime) {
    $query = "update meeting_times  set days='$days', StartTime ='$startTime', EndTime ='$endTime'  where MT_ID ='$id'";
     $result = mysqli_query($connection, $query);
    if (!$result) {
        die("unable to delete from meeting_times table" . mysqli_error($connection));
    }
    return "success";
    
}
function delete_meetingTimes($connection, $id) {
    $query = "delete from meeting_times where MT_ID ='$id'";
     $result = mysqli_query($connection, $query);
    if (!$result) {
        die("unable to delete from meeting_times table" . mysqli_error($connection));
    }
    return "success";
}
function add_meetingTimes($connection, $id, $days, $startTime, $endTime){
     $query = "insert into meeting_times values ('$id', '$days', '$startTime', '$endTime')";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("unable to insert into the meeting_times table" . mysqli_error($connection));
    }
    return "success";
}
function delete_Rooom($connection, $id) {
    $query = "delete from room where Room_ID ='$id'";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("unable to delete the course" . mysqli_error($connection));
    }
    return "success";
}
function add_Room($connection, $id, $location, $capacity, $campus) {
    $query = "insert into room values ('$id', '$location', '$capacity', '$campus')";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("unable to update the room table" . mysqli_error($connection));
    }
    return "success";
}
function update_Room($connection, $id, $location, $capacity, $campus) {
    $query = "update room set Room_Location ='$location', capacity='$capacity', Campus ='$campus'"
            . " where Room_ID ='$id'";
 
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("unable to update the room table" . mysqli_error($connection));
    }
    return "success";
    
}
function add_faculty_course($connection, $fac_id, $courseids) {
    $course_ids = explode(",", $courseids);
    foreach ($course_ids as $courseid) {
      $query_2 = "insert into course_instructor values ('$courseid', '$fac_id')";
        $result_2 = mysqli_query($connection, $query_2);
        if (!$result_2) {
            die("unable to add the course_instructor" . mysqli_error($connection));
        }  
    }

    return "success";
}
function delete_faculty_course($connection, $fac_id) {
    $query = "delete from course_instructor where Faculty_ID ='$fac_id'";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("unable to delete the course" . mysqli_error($connection));
    }
    return "success";
}
function  update_faculty_course($connection, $fac_id, $courseids) {
    $query = "delete from course_instructor where Faculty_ID ='$fac_id'";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("unable to delete the course" . mysqli_error($connection));
    }
    $course_ids = explode(",", $courseids);
    foreach ($course_ids as $courseid) {
      $query_2 = "insert into course_instructor values ( '$courseid', '$fac_id')";
        $result_2 = mysqli_query($connection, $query_2);
        if (!$result_2) {
            die("unable to delete the course" . mysqli_error($connection));
        }  
    }

    return "success";
    
}
//echo update_faculty_course($connection_2, "z2341", "CIT460, CIT461");
function delete_course($connection, $id) {
    $query = "delete from course where Course_ID ='$id'";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("unable to delete the course" . mysqli_error($connection));
    }
    return "success";
}
function add_course($connection, $id, $name,$subject, $max_students, $major, $creditHours, $dxb, $adm, $adf) {
     $total = $dxb + $adm + $adf;
    $query = "insert into course values ('$id', '$name', '$subject', '$creditHours', '$major',"
            . " '$total', '$max_students', '$dxb' , '$adm' , '$adf')";
 
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("unable to add the course table" . mysqli_error($connection));
    }
    return "success";
}

function update_Courses($connection, $id, $name, $max_students, $major, $creditHours, $dxb, $adm, $adf) {
    $total = $dxb + $adm + $adf;
    $query = "update course set Course_Name ='$name', Course_Credit='$creditHours', Major_ID ='$major',"
            . " maxnumofStudents ='$max_students', numofclassesInDXB ='$dxb' , numofclassesInADM ='$adm' , "
            . "  numofclassesInADF='$adf', numberofclasses = '$total'  where Course_ID ='$id'";
 
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("unable to update the course table" . mysqli_error($connection));
    }
    return "success";
    
}
   function display_selected_course($connection, $id) {
    $query = "SELECT * FROM course  where Course_ID ='$id'";
 
    $result = mysqli_query($connection, $query);
    
    return generate_course_data($result);

}

function generateClassSchedule() {
//    $error = "<tr><td colspan='11' style='text-align:center'>No record available</td></tr>";
       $data = new Data();
        $driver = new Driver($data);
        return ($driver->displayDriver()) ;
    
}
function displayCourses($connection, $courseid='', $name='', $major='')
 {
   $query = "SELECT * FROM course ";
   if($courseid !=='' && $name !=='' && $major !==''){
       $query .=" where Course_ID like '%$courseid%' and Course_Name like '%$name%' and Major_ID like '%$major%' ";
   }elseif ($courseid !=='') {
         $query .=" where Course_ID like  '%$courseid%' ";
    }
    elseif ($name !=='') {
         $query .=" where Course_Name like '%$name%' ";
    }
     elseif ($major !=='') {
         $query .=" where Major_ID like '%$major%' ";
    }
   
    $result = mysqli_query($connection,$query);
    
    return generate_course_data($result);
  }

  function generate_course_data($result) {
    $output = array();
   while ($row = mysqli_fetch_array($result)) {
        $output[]=array("course_id"=>$row["Course_ID"],"courseName"=>$row["Course_Name"],
            "subject"=>$row["Course_subject"],"CreditHour"=>$row["Course_Credit"], 
               'Major'=>$row["Major_ID"], 'numberofClasses'=>$row["numberofclasses"], 'maxnumofStudents'=>$row['maxnumofStudents'],
                'numofclassesinDXB'=>$row["numofclassesInDXB"], 'numofclassesinADF'=>$row["numofclassesInADF"],
            'numofclassesinADM'=>$row["numofclassesInADM"]);
    }
     return json_encode($output); 
}
  
  function displayInstructors($connection, $id='', $name='')
 {
   $query = "SELECT * FROM faculty ";
   if ($id !== '') {
        $query .= "  where Fac_ID ='$id'";
    }
    if ($name !==''){
        $query .= "  where Fac_FirstName like '%$name%' OR  Fac_LastName like '%$name%'";
    }
    $query .= "  order by Fac_ID asc";
    $result = mysqli_query($connection,$query);
    $output = array();
   while ($row = mysqli_fetch_array($result)) {
        $output[]=array("fac_id"=>$row["Fac_ID"],"fname"=>$row["Fac_FirstName"],"lname"=>$row["Fac_LastName"],
            "femail"=>$row["Fac_Email"], 'college_id'=>$row["college_id"], 'branch'=>$row["branch"]);
    }
     return json_encode($output); 
  }
  function displayRoom($connection, $id='')
 {
   $query = "SELECT * FROM room";
   if ($id !==''){
       $query .= " where Room_ID ='$id'";
   }
    $result = mysqli_query($connection,$query);
    $output = array();
   while ($row = mysqli_fetch_array($result)) {
        $output[]=array("room_id"=>$row["Room_ID"],"location"=>$row["Room_Location"],
            "capacity"=>$row["capacity"], 'campus'=>$row["Campus"]);
    }
     return json_encode($output); 
  }
  function displayMeetingTime($connection, $id='')
 {
   $query = "SELECT * FROM meeting_times ";
   if ($id !==''){
       $query.=" Where MT_ID='$id'";
   }
 
    $result = mysqli_query($connection,$query);
    $output = array();
   while ($row = mysqli_fetch_array($result)) {
        $output[]=array("meetingTime_id"=>$row["MT_ID"],"days"=>$row["days"],
            "startTime"=>$row["StartTime"], "endTime"=>$row["EndTime"]);
    }
     return json_encode($output); 
     
  }
   function displayCourseInstructors($connection, $id='')
 {
   $query = "SELECT * FROM course_instructor c join faculty f on f.Fac_ID = c.Faculty_ID ";
   if ($id !== '') {
        $query .= "  where c.Faculty_ID ='$id'";
    }
    $query .= "  order by f.Fac_ID asc";
    $result = mysqli_query($connection,$query);
    $output = array();
   while ($row = mysqli_fetch_array($result)) {
        $output[]=array("course_ID"=>$row["Course_ID"],"faculty_ID"=>$row["Faculty_ID"],
            "fname"=>$row["Fac_FirstName"],"lname"=>$row["Fac_LastName"], 'college_id'=>$row["college_id"], 'branch'=>$row["branch"]);
    }
     return json_encode($output); 
     
  }
   function displayCourse_Instructors($connection, $id ='', $name='')
 {
   $instructors = json_decode(displayInstructors($connection, $id, $name));
   $course_instructors = json_decode(displayCourseInstructors($connection, $id));
    $output = array();
    foreach ($instructors as $instructor) {
        $courses = array();
        foreach ($course_instructors as $c_instructor) {
            
            if($instructor->fac_id ==$c_instructor->faculty_ID ){
                $courses[] = $c_instructor->course_ID;
            }
        }
        $output[]=array("faculty_ID"=>$instructor->fac_id, "course_ID"=>$courses, "fname"=>$instructor->fname,
           "lname"=>$instructor->lname, 'college_id'=>$instructor->college_id, 'branch'=>$instructor->branch);
    }
     return json_encode($output); 
     
  }
  
  
function displayInstructorAvailablity($connection, $instructor='')
 {
   $query = "SELECT * FROM instructor_availablity ";
   if ($instructor !== '') {
        $query .= " where faculty_id = '$instructor' ";
    }
    $query .="  Group by meetingTime_id";
    $result = mysqli_query($connection,$query);
    $output = array();
   while ($row = mysqli_fetch_array($result)) {
           $output[]=$row["meetingTime_id"];

//        $output[]=array("faculty_id"=>$row["faculty_id"],"meetingTime_id"=>$row["meetingTime_id"]);
    }
     return ($output); 
     
  }
//  echo (displayCourse_Instructors($connection_2));