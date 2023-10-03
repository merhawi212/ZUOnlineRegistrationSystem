
<?php

//include '../controller.php';
    
class Data {
    private  $courses;
    private $sec_data;

    function __construct($data =''){
       global $connection;
        $this->courses = $this->selectCourses($connection);
        $this->sec_data = $data;
    }
    function selectCourses($connection){
        return display_courseProjection($connection);
    }
    function setSelected_Sections($dat){
         $this->sec_data = $dat;
        
    }
 
    function getCourse() {
        
        return $this->courses;
    }
    function getSections() {
      return $this->sec_data;
//        return $this->sections;
    }

}