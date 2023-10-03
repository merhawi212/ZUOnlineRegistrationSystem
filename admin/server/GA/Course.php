<?php

 class Course {
	private $Course_ID;
	private $instructors;
        private $numberofclasses; private $courseName; private $Major;private $creditHours;
        private $maxNumofStudents; private $numofClassesInDXB; private $numofClassesInADM;private $numofClassesInADF;
     

        function __construct($Course_ID, $courseName,$creditHours,$Major,   $instructors, $numberofclasses,
               $maxNumofStudents,  $numofClassesInDXB,$numofClassesInADM,$numofClassesInADF ) {
            
		$this->Course_ID = $Course_ID;
		$this->instructors = $instructors;
                $this->numberofclasses= $numberofclasses;
                $this->courseName= $courseName;
                $this->creditHours = $creditHours;
                $this->Major = $Major;
                $this->maxNumofStudents = $maxNumofStudents;
                $this->numofClassesInDXB = $numofClassesInDXB;
                $this->numofClassesInADM = $numofClassesInADM;
                $this->numofClassesInADF = $numofClassesInADF;
	}

        public  function getCourse_ID() {
            return $this->Course_ID;
        }

        public function getCourseName() {
            return $this->courseName;
        }

        public function getMajor() {
            return $this->Major;
        }

        public function getCreditHours() {
            return $this->creditHours;
        }

	function getInstructors() {
           
            return $this->instructors;
	}
        function getNumberofClasses() {
		return $this->numberofclasses;
	}

        public function getMaxNumofStudents() {
            return $this->maxNumofStudents;
        }

        public function getNumofClassesInDXB() {
            return $this->numofClassesInDXB;
        }

        public function getNumofClassesInADM() {
            return $this->numofClassesInADM;
        }

        public function getNumofClassesInADF() {
            return $this->numofClassesInADF;
        }

	function displayCourse() {

            return  ['course_id'=>$this->getCourse_ID(),'courseName'=> $this->getCourseName(),
                'Major'=> $this->getMajor(), 'creditHours'=> $this->getCreditHours(), 'instructor' =>$this->getInstructors(),
                'numberofclasses'=> $this->getNumberofClasses(), 'maxnumofStudents'=> $this->getMaxNumofStudents(),
                'numofClassesInDXB'=> $this->getNumofClassesInDXB(), 'numofClassesInADM'=> $this->getNumofClassesInADM(),
                'numofClassesInADF'=> $this->getNumofClassesInADF() ];
	}
}

//$course1 = new Course("CIT460", "System analysis", "InfoTech", 3, "IT");
//
//echo implode(", ", $course1->displayCourse());