
<?php

//include '../controller_3.php';
//include 'Course.php';

    
class Data {
    private  $courses;
    private  $instructors;
    private $numberOfClasses = 0;
    private $rooms;
    private $meetingTime;
    private $instrutor_availablity;
//    private $data;
    function __construct(){
       global $connection_2;
        $this->courses = $this->selectCourse($connection_2);
	$this->instructors = displayInstructors($connection_2);
        $this->rooms = json_decode(displayRoom($connection_2));
        $this->meetingTime = json_decode(displayMeetingTime($connection_2));
        
    }
    
    function selectCourse($connection) {
        $Courses = array();
       $coursesResult = json_decode(displayCourses($connection));
       $course_instructors = json_decode(displayCourseInstructors($connection));
       foreach ($coursesResult as $course) {
          $instructors = array();
           foreach ($course_instructors as $course_instructor) {
                if($course->course_id ===$course_instructor->course_ID){
//                    echo 
//                   echo  $course_instructor->branch;
                    $instructors[] = array("faculty_id"=>$course_instructor->faculty_ID, 'fname'=>$course_instructor->fname,
                        'lname'=>$course_instructor->lname, 'campus'=>$course_instructor->branch,
                        'availablity'=>$this->selectInstructorAvailablity($connection, $course_instructor->faculty_ID));
                }
           }
           $this->numberOfClasses += intval($course->numberofClasses);
           $Courses[] = new Course($course->course_id,$course->courseName, $course->CreditHour,$course->Major,
                    $instructors, $course->numberofClasses, $course->maxnumofStudents,$course->numofclassesinDXB,
                   $course->numofclassesinADM, $course->numofclassesinADF);

//           $Courses[] = array('course'=>$course,'instructors'=>$instructors, 'numberofclasses'=>$course->numberofClasses);
          
       }
       return $Courses;
            
    }
    
    function selectInstructorAvailablity($connection, $fac_id) {
      $instrutor_availablity = (displayInstructorAvailablity($connection, $fac_id));
      
      return $instrutor_availablity;
    }
    function getCourses() {
        
        return $this->courses;
    }

    function getRooms() {
    return $this->rooms;
  }
  function getMeetingTime() {
    return $this->meetingTime;
  }

  function getNumberOfClasses() {
      return $this->numberOfClasses;
  }
}
//echo PHP_VERSION;
//$data = new Data();
//////echo $data->getNumberOfClasses();
//foreach ($data->selectCourse($connection_2) as $course){
//    echo json_encode($course->getInstructors()) .' <br><br>';
//    }
