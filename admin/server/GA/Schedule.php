<?php

//include '../controller.php';
//include 'Data.php';
//include 'Section.php';
//include '../../include/autoloader.inc.php';
class Schedule {
    
   	private  $data;
	private  $numberofConflicts = 0;
	private $numberofClasses = 0;
	private $fitness = -1;
	private $isFitnessChanged = true;
	private  $conflict = array();
        private $sections = array();
        function __construct(Data $data) {
            $this->data = $data; 
            $this->courses= ($this->data->getCourses());
             $this->numberofClasses= $this->data->getNumberOfClasses();
            $this->i = 0;
            $this->CRN = 20001;
            $this->sections = [];
          
                foreach ( $this->courses as $course){
                 
                    $this->creatSectionsForEachCampus($course, $course->getNumofClassesInDXB(), 50, 'DXB', "DXB");
                    $this->creatSectionsForEachCampus($course, $course->getNumofClassesInADM(), 90, 'ADM', 'AUH');
                    $this->creatSectionsForEachCampus($course, $course->getNumofClassesInADF(), '00', 'ADF', 'AUH');
                 
                    }
            
        }
        
        function creatSectionsForEachCampus($course, $NumofClassesForCourseForCampus, $sectionNum, $campus, $instruc_campus ) {
             $n = 0;
             $c = 1;
             $k = 0;
             while ($n < ($NumofClassesForCourseForCampus)){
                        $Instructor_index = 0;
                        while(true){
                            $Instructorindex = (intval(count($course->getInstructors()) * $this->rand_float()));
                            $Instructor_index = ($Instructorindex >= count($course->getInstructors()) || $Instructorindex < 0)? 0:$Instructorindex;
                       
                            if ($course->getInstructors()[$Instructor_index]['campus'] == $instruc_campus){
                                break;
                            }

                        }
                        $room_index = 0;
                        while (true){
                             $roomindex = (intval(count($this->data->getRooms()) * $this->rand_float()));
                             $room_index = ($roomindex >= count($this->data->getRooms()) || $roomindex < 0)? 0:$roomindex;
                             if ($this->data->getRooms()[$room_index]->campus == $campus) {
                                  break;
                                }
                        }
                        
                        $meetingTimeindex = (intval(count($this->data->getMeetingTime()) * $this->rand_float()));
                       $meetingTime_index = ($meetingTimeindex >= count($this->data->getMeetingTime()) || $meetingTimeindex < 0)? 0:$meetingTimeindex;
////       
                      
                        $section = new Section($this->CRN, ($sectionNum.$c), $course);
//        
                        $section->setInstructor($course->getInstructors()[$Instructor_index]);
                        $section->setMeetingTime($this->data->getMeetingTime()[$meetingTime_index]);
                        $section->setRoom($this->data->getRooms()[$room_index]);
                        $section->setCampus($campus);
                        $this->sections[] = $section;
                        $n++; $c++;
                        $this->CRN++;
                        
                    }
        }
        function rand_float($st_num=0,$end_num=1,$mul=1000000)
        {
            if ($st_num > $end_num) {
                 return false;
            }
            return mt_rand($st_num*$mul,$end_num*$mul)/$mul;
        }
        
        
        function getFitness() {
		if ($this->isFitnessChanged == true) {
                    $this->fitness = $this->recalculateFitness();
                    $this->isFitnessChanged = false;
		}
		return round($this->fitness, 2) ;
	}
        
    function recalculateFitness(){
         for($i = 0; $i <  $this->numberofClasses; $i++) {
             if($this->sections[$i]->getcourse()->getMaxNumofStudents() <= $this->sections[$i]->getRoom()->capacity){
//                         $this->numberofConflicts++;
             
             $i_meetingID = $this->sections[$i]->getMeetingTime()->meetingTime_id;
             
//            if (in_array($i_meetingID, $this->sections[$i]->getAvaliablity())){
//                   $this->numberofConflicts++;
//                   echo  "<br> yes :".$this->sections[$i]->getInstructor_id().' '. $i_meetingID  .' '. json_encode($this->sections[$i]->getAvaliablity());
//            }
              for($j = $i+1; $j <  $this->numberofClasses; $j++) {  
//                    echo $j;
                    $j_meetingID = $this->sections[$j]->getMeetingTime()->meetingTime_id;
                  
                    if(($i_meetingID === $j_meetingID) &&($this->sections[$i]->getCRN() != $this->sections[$j]->getCRN())){

                        if($this->sections[$i]->getRoom()->room_id === $this->sections[$j]->getRoom()->room_id){
                            $this->numberofConflicts++;
    //                                echo  "<br> room conflict : ".$this->sections[$i]->getRoom()->room_id . ' with '.$this->sections[$j]->getRoom()->room_id;
                        }

                        if ($this->sections[$i]->getInstructor_id() === $this->sections[$j]->getInstructor_id()) {
                                 $this->numberofConflicts++;
                   
                     }

                 }
                           
              }
                
         
//               
//             }else
//                 $this->numberofConflicts++;
////                 
            
            }else
                $this->numberofConflicts++;    
               
            }

            return (1/(($this->numberofConflicts + 1)));
        }

        function getScheduledSections() {
            $this->isFitnessChanged = true;
            return $this->sections;
            
        }
        function getNumberOfConflicts() {
		return $this->numberofConflicts;
	}
 
        function getConflicts() {
            return $this->conflict;
        }
        function getcoursedata() {
            return $this->courses;
        }
        
}
//$data = new Data();
//$schedule = new Schedule($data);
////
//////echo var_dump($schedule->getcoursedata());
//foreach ($schedule->getScheduledSections() as $section) {
//    echo json_encode($section->displaySection()) .'<br><br>';
//}
