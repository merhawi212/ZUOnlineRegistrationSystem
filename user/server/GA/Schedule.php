<?php


class Schedule {
    
   	private  $data;
	private  $numberofConflicts = 0;
	private $numberofCourse = 0;
	private $fitness = -1;
	private $isFitnessChanged = true;
	private  $conflict = array();
        private $sections = array();
        private $tem;
        function __construct(Data $data) {
            $this->data = $data; 
            $this->tem= json_decode($this->data->getSections());
             $this->numberofCourse= $this->getNumOfCourses();
            $this->i = 0;
            $this->sections = [];
            while ($this->i < $this->numberofCourse) {
                $index = (intval(count($this->tem) * $this->rand_float()));
                $index_1 = (($index >= count($this->tem)) || ($index< 0) )?0:$index;
                    $this->sections[$this->i] = $this->tem[$index_1];
                    $this->i++;
                   
            }
            
        }
        function rand_float($st_num=0,$end_num=1,$mul=1000000)
        {
            if ($st_num > $end_num) {
                 return false;
            }
            return mt_rand($st_num*$mul,$end_num*$mul)/$mul;
        }
        
        function getNumOfCourses() {
            $countSections  = count($this->tem);
            $i = 0;
            $j = 0;
            $temCourseIDStore = [];
            while ($i < $countSections){
                if (!(in_array($this->tem[$i]->id, $temCourseIDStore))) {
                    $temCourseIDStore[$j] = $this->tem[$i]->id;
                    $j++;
                 }
            $i++;
            }
            return count($temCourseIDStore);
        }
        
        function getFitness() {
		if ($this->isFitnessChanged == true) {
                    $this->fitness = $this->recalculateFitness();
                    $this->isFitnessChanged = false;
		}
		return round($this->fitness, 2) ;
	}
        
        function recalculateFitness(){
            for($i = 0; $i <  $this->numberofCourse; $i++) {
                    for($j = $i+1; $j <  $this->numberofCourse; $j++) {
                    
                        if($this->sections[$i]->CRN == $this->sections[$j]->CRN){
                            $this->numberofConflicts += 1;
                        }
                        else{
                            if($this->sections[$i]->id == $this->sections[$j]->id){
                                 $this->numberofConflicts++;
                            }
                            else if(($this->sections[$i]->MeetingDay == $this->sections[$j]->MeetingDay) 
                                    &&($this->sections[$i]->StartTime == $this->sections[$j]->StartTime)){
                                $this->numberofConflicts++;
                                $this->conflict = ['timeconflict'=> $this->sections[$i]->id ." "
                                    . "and ".$this->sections[$j]->id." at ".$this->sections[$i]->StartTime];
    //                            
                             }
                         }
                     }
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
        function get_temp() {
           return $this->tem;
        }
        function getConflicts() {
            return $this->conflict;
        }
        
}
//$data = new Data();
//$schedule = new Schedule($data);
////$schedule2 = new Schedule($data);
//echo '<br><br><br>';
//echo json_encode($schedule->getScheduledSections())  ;
// $schedule2->recalculateFitness()  ;
// 

