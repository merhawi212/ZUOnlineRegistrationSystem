<?php

 class Course {
	private $Course_ID;
	private $Course_Name;
	private  $Subject;
	private  $CreditHour;
	private $Major;
        
        function __construct($Course_ID, $Course_Name, $Subject,$CreditHour, $Major ) {
            
		$this->Course_ID = $Course_ID;
		$this->Course_Name = $Course_Name;
		$this->Subject = $Subject;
		$this->CreditHour = $CreditHour;
		$this->Major = $Major;
	}

	function  getCourseID() {
		return $this->Course_ID;
	}

	function getCourseName() {
		return $this->Course_Name;
	}

	function getSubject() {
		return $this->Subject;
	}

	function getCreditHour() {
		return $this->CreditHour;
	}

	function getMajor() {
		return $this->Major;
	}

	function displayCourse() {
            $result = array($this->getCourseID(), $this->getCourseName(), $this->getSubject(), $this->getCreditHour(),
                    $this->getMajor());
            return $result;
	}
}

//$course1 = new Course("CIT460", "System analysis", "InfoTech", 3, "IT");
//
//echo implode(", ", $course1->displayCourse());