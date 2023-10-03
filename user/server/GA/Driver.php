<?php
//include 'Schedule.php';

//include 'Schedule.php';

class Driver {
        public const POPULATION_SIZE = 6;
	public const MUTATION_RATE = 0.1;
	public const CROSSOVER_RATE = 0.9;
	public const TOURNAMENT_SELECTION_SIZE = 3;
	public const NUMBER_OF_ELITE_SCHEDULES = 1;
	public  $scheduleNum = 1;private $data; private $NumofSchedules; public $html; private $geneticAlgorithm;
        private $population;private $PutSelectedSchedules; private $countCorrectSchedules;  private $output;
        private $iterationNum = 0; private  $days = [1=>'M', 2=>'T', 4=>'W', 8=>'T', 16=>'F'];private $conflic = [];
                
        function __construct(Data $data) {
            $this->data = $data;
            $this->geneticAlgorithm = new GeneticAlgorithm($this->data);
            $this->PutSelectedSchedules;
            $this->countCorrectSchedules=0;
            $this->NumofSchedules = 0;
            $this->population = new Population(Driver::POPULATION_SIZE, $this->data);
            $this->output;
        }
        
        function check_double($ArrayOfSchedules, $pos) {
            $countSchedules = count($ArrayOfSchedules);
            $count = 0;
            if($countSchedules == 1){
                return 0; //0, 1
            }else{
                $i = 0;
               while($i < $pos){
                   $temp = [];
                   $j = 0;
                   foreach ($ArrayOfSchedules[$i] as $section) {
                       $temp[$j++] = $section->CRN;
                   }
                   $currentCRNs = [];
                   $k = 0;
                   foreach ($ArrayOfSchedules[$pos] as $section) {
                       $currentCRNs[$k++] = $section->CRN;
                     
                   }
                   sort($currentCRNs);
                   sort($temp);
                   if($currentCRNs == $temp){
                       $count++;
                   }
                   $i++;
               }
               if($count > 0){
                   return 1;
               }
            }
            
        }
       
        
        function displayDriver() {
            $this->output = array();
//             if(!empty($this->getGenZero()))
//                  return $this->getGenZero();
//             
//            while ($this->population->getSchedules()[0]->getFitness() !=1){
                $checkEmpty =[];
                while (true){
                  $this->population = $this->geneticAlgorithm->evolve($this->population);
                   foreach ($this->population->getSchedules() as $schedule) {
                        $this->conflic = $schedule->getConflicts();
                        if($schedule->getFitness()==1 ){
     //                   $this->NumofSchedules++;
                            $this->PutSelectedSchedules[$this->NumofSchedules] = $schedule->getScheduledSections();
                            if($this->check_double($this->PutSelectedSchedules, $this->NumofSchedules++) == 0){
                             $rowspan = count($schedule->getScheduledSections());
                             $this->countCorrectSchedules++;
                              $this->html = $this->html.'<tr><td rowspan='.$rowspan.'> Schedule'.$this->countCorrectSchedules.'</td>';

                              $sectionCRN = '';
                              $i= 0;

                              foreach ($schedule->getScheduledSections() as $section) {
                                  $checkEmpty[] = $i;
                                  if($i == 0){
                                               $sectionCRN = $section->CRN;
                                 }else{
                                   $sectionCRN = $section->CRN.','.$sectionCRN;
                                 }
                                       $i++;

                                  $this->html = $this->html. '<td>'.$section->courseName.'</td><td>'.$section->subject.'</td><td>'.$section->id.'</td><td>'.$section->CreditHour.'</td>'
                                     . '<td>'.$section->CRN.'</td>';

                                             $this->html = $this->html. '<td><ul class="meetingDay">';
                                             foreach($this->days as $key => $value){
                                                     if(($section->MeetingDay & $key) > 0){
                                                            $this->html = $this->html. '<li class="active">'.$value.'</li>';
                                                         }else{
                                                            $this->html = $this->html. '<li>'.$value.'</li>';
                                                         }

                                                  }
                                               $this->html = $this->html.'</ul><span style="margin-left:1%">'.$section->StartTime.'</span> - <span style="margin-left:1%">'.$section->EndTime.'</span></td>'
                                             .'<td>'.$section->RoomLocation.'</td> <td>'.$section->Instructor.'</td><td>'.$section->SeatLeft.' seats of <span>'.$section->RoomCapacity.'</span></td>'
                                                       . '<td><button  type="submit" class="btn btn-primary" data-course-id="'.$section->id.'"  id ="deletecourseFromschedule"   onclick="delete_section(this);"
                                                                          style="z-index: 9999;padding: 5%; margin-left:2%"> Delete </button></td></tr>';

                                }

                               $this->html = $this->html.'<tr class="emptyRow"><td colspan="10" style="border-right-style: none;"></td>'
                                    . '<td style="padding: 1%; border-left-style: none;">'
                                      . '<button type="submit" data-CRN-ids="'.$sectionCRN.'" name="view" onclick="enroll(this);" '
                                      . 'class="btn btn-primary optschedule" style=" background-color: darkcyan; z-index: 99999">'
                                      . 'Register </button></td></tr>';

                         }  
                        }
              
                }
                if($this->iterationNum == 100){
//                    return "dka this is break ".$this->iterationNum;
                    break;
                }
                $this->iterationNum++;
             }
             if(!empty($this->html) && !empty($checkEmpty))
                     return $this->html;
            else {
                $message =  '<tr><td colspan="11" style="text-align:center; color:red">! There is a time conflict ';

               if(!empty($this->conflic['timeconflict']))
                    return $message .' for courses ' . ($this->conflic['timeconflict']).'</td></tr>';
                else {
                     return $message . ' for some sections </td></tr>';
                }
            }

//         return json_encode( $this->output);
            
        }
        function getNumofSchedules() {
            return $this->NumofSchedules;
            
        }
        function getSelectedSchedules() {
            return $this->PutSelectedSchedules;
        }
        function getScheduleResult() {
            return json_encode( $this->output);
            
        }
}




?>
