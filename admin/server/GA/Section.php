<?php

 class Section {
	private $CRN;
	private $Section_No;
	private  $meetingTime;
	private  $course;private $room;
        private $instructor_id;
        private $fname;
        private $lname; private $campus;  private $avaliablity;  
        private $instructor_campus;      

          private $section = array();
      
         function __construct($CRN, $Section_No,  Course $course ) {
            
		$this->CRN = $CRN;
		$this->Section_No = $Section_No;
		$this->course = $course;
	}
        function setInstructor($instructor) {
            $this->instructor_id = $instructor['faculty_id'] ;
            $this->fname =$instructor['fname'];
            $this->lname = $instructor['lname'];
            $this->avaliablity = $instructor['availablity'];
            $this->instructor_campus = $instructor['campus'];
        }
         function setRoom($room) {
            $this->room = $room;
        }
        function setMeetingTime($meetingTime) {
            $this->meetingTime = $meetingTime;
        }
        function setCampus($campus) {
            $this->campus= $campus;
        }
	function  getCRN() {
		return $this->CRN;
	}

	function getSection_No() {
		return $this->Section_No;
	}

	function getMeetingTime() {
		return $this->meetingTime;
	}
   
          function getInstructor_id() {
            return $this->instructor_id;
        }

        public function getFname() {
            return $this->fname;
        }

        public function getLname() {
            return $this->lname;
        }

        public function getAvaliablity() {
            return $this->avaliablity;
        }

	function getRoom() {
		return $this->room;
	}

	function getcourse() {
		return $this->course;
	}
        public function getCampus() {
            return $this->campus;
        }
          public function getInstructor_campus() {
            return $this->instructor_campus;
        }


	function displaySection() {
            $this->section = array('CRN'=>$this->getCRN(), 'sectionNo'=>$this->getSection_No(),
                'meetingTime'=>$this->getMeetingTime(), 'course_id'=> $this->getcourse()->getCourse_ID(),
                'courseName'=>$this->getcourse()->getCourseName(), 'creditHours'=>$this->getcourse()->getCreditHours(),
               'maxNumofStudents'=>$this->getcourse()->getMaxNumofStudents(), 'instructor_ID'=>$this->getInstructor_id(), 'fname'=> $this->getFname(),
                'lname'=> $this->getLname(),  'room'=> $this->getRoom(), 'campus'=> $this->getCampus(), 'avaliablity'=> $this->getAvaliablity() );
            return $this->section;
	}
}

//$section1 = new Section(12, 901, "MW", "8:10", "9:20", "Z873", "CIT460");
//
//echo implode(", ", $section1->displaySection());