<?php
//include 'Schedule.php';
//include 'Population.php';
//
//include 'GeneticAlgorithm.php';
class Driver {
        public const POPULATION_SIZE = 20;
	public const MUTATION_RATE = 0.2;
	public const CROSSOVER_RATE = 0.9;
	public const TOURNAMENT_SELECTION_SIZE = 3;
	public const NUMBER_OF_ELITE_SCHEDULES = 1;
	public  $scheduleNum = 1;
	private $data; private $NumofSchedules; public $html; private $geneticAlgorithm; 
        private $population; private $PutSelectedSchedules; private $countCorrectSchedules;
        private $output; private $iterationNum = 0;
        private  $days = [1=>'M', 2=>'T', 4=>'W', 8=>'T', 16=>'F'];
        private $conflic = [];
                
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
                       $temp[$j++] = $section->getCRN();
                   }
                   $currentCRNs = [];
                   $k = 0;
                   foreach ($ArrayOfSchedules[$pos] as $section) {
                       $currentCRNs[$k++] = $section->getCRN();
                     
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
//            while ($this->population->getSchedules()[0]->getFitness() !=1){
                $checkEmpty =[];
                $rowspan =0;
                while (true){
                    $fitness = 0;
                  $this->population = $this->geneticAlgorithm->evolve($this->population);
                   foreach ($this->population->getSchedules() as $schedule) {
                        $this->conflic = $schedule->getConflicts();
                        $fitness = $schedule->getFitness();
                        if($schedule->getFitness()==1 ){
                            $this->PutSelectedSchedules[$this->NumofSchedules] = $schedule->getScheduledSections();
                            if($this->check_double($this->PutSelectedSchedules, $this->NumofSchedules++) == 0){
                             $rowspan = count($schedule->getScheduledSections());
                             $this->countCorrectSchedules++;
                        
                              $this->html = $this->html.'<tr>';
//                              $this->html = $this->html.'<td rowspan='.$rowspan.'>'.$schedule->getFitness().' '.$schedule->getNumberOfConflicts() .'</td>';

                              $sectionCRN = '';
                              $i= 0;
                              $c = 0;
                              foreach ($schedule->getScheduledSections() as $section) {
                                  $checkEmpty[] = $i;
                                  if($i == 0){
                                               $sectionCRN = $section->getCRN();
                                 }else{
                                   $sectionCRN = $section->getCRN().','.$sectionCRN;
                                 }
                                       $i++;
                                       
                                  $this->html = $this->html.'<td><input type="hidden" name=tableRow['.$c.'][courseID] value='.$section->getcourse()->getCourse_ID().'>'.$section->getcourse()->getCourse_ID().'</td>'
                                          . '<td><input type="hidden" name=tableRow['.$c.'][courseName] value="'.$section->getcourse()->getCourseName().'">'.$section->getcourse()->getCourseName().'</td>'
                                          . '<td><input type="hidden" name=tableRow['.$c.'][Major] value='.$section->getcourse()->getMajor().'>'.$section->getcourse()->getMajor().'</td>'
                                          . '<td><input type="hidden" name=tableRow['.$c.'][CRN] value='.$section->getCRN().'>'.$section->getCRN().'</td>'
                                          . '<td><input type="hidden" name=tableRow['.$c.'][sectionNum] value='.$section->getSection_No().'>'.$section->getSection_No().'</td>'
                                          . '<td><input type="hidden" name=tableRow['.$c.'][Faculty_ID] value='.$section->getInstructor_id().'>'.$section->getFname().', '.$section->getLname() .'</td>';

                                             $this->html = $this->html. '<td><input type="hidden" name=tableRow['.$c.'][MeetingTime] value='.$section->getMeetingTime()->days.'><ul class="meetingDay">';
                                             foreach($this->days as $key => $value){
                                                     if(($section->getMeetingTime()->days & $key) > 0){
                                                            $this->html = $this->html. '<li class="active" style="">'.$value.'</li>';
                                                         }else{
                                                            $this->html = $this->html. '<li>'.$value.'</li>';
                                                         }

                                                  }
                                               $this->html = $this->html.'<input type="hidden" name=tableRow['.$c.'][StartTime] value='.$section->getMeetingTime()->startTime.'>'
                                                       . '<span style="margin-left:1%">'.$section->getMeetingTime()->startTime.'</span> -'
                                                       . ' <input type="hidden" name=tableRow['.$c.'][EndTime] value='.$section->getMeetingTime()->endTime.'>'
                                                       . '<span style="margin-left:1%">'.$section->getMeetingTime()->endTime.'</span></ul></td>'
                                             .'<td><input type="hidden" name=tableRow['.$c.'][Room_ID] value='.$section->getRoom()->room_id.'>'.$section->getRoom()->location.'</td> '
                                               . '<td><input type="hidden" name=tableRow['.$c.'][campus] value='.$section->getCampus().'>'.$section->getCampus().'</td>'
                                                       . '<td>'.$section->getRoom()->capacity. ' seats of ' .$section->getRoom()->capacity.'</td></tr>';
                                                  
                                    $c++;
                                }


                         }  
                        }
              
                }
                if($this->iterationNum == 800 || $fitness ==1 ){
//                    return "dka this is break ".$this->iterationNum;
                    break;
                }
                $this->iterationNum++;
             }
             if (!empty($this->html) && !empty($checkEmpty)) {
                    return json_encode([ $this->html,  $rowspan]);
        } else {
            $message = '<tr><td colspan="11" style="text-align:center; color:red">! There are/is some/a conflict(s) ';

            if (!empty($this->conflic['timeconflict']))
                return $message . ' for courses ' . ($this->conflic['timeconflict']) . '</td></tr>';
            else {
                return '';
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

<?php
//$data = new Data();
//
//$driver = new Driver($data);

//$html = '<table class="GAScheduleTable"><tr><th>Fitness</th><th>CourseID</th><th>Course Title</th><th>Major</th><th>CRN</th><th>Section Number</th>
//                            <th>Instructor</th><th>MeetingTime</th><th>Location</th><th>Campus</th><th>Capacity</th></tr>
//                         <tbody id="display_schedule">';
//                         
//  echo $driver->displayDriver();
//  $html .= '</tbody> </table>';
//                         
//
//                    
//  echo $html;

?>

