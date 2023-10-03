<?php

class GeneticAlgorithm {
     private  $data;
     

      function __construct(Data $data) {
         $this->data=$data;
         
     }

    function  evolve(Population $population) {
		return $this->mutatePopulation($this->crossoverPopulation($population));

	}
     
    function crossoverPopulation(Population $population) {
                $countSched = count($population->getSchedules());
		$crossoverPopulation = new Population($countSched, $this->data);
                $k = 0;
                 while ($k < Driver::NUMBER_OF_ELITE_SCHEDULES){
                     $crossoverPopulation->getSchedules()[$k] = $population->getSchedules()[$k];
                     $k++;
                 }
                 $n = Driver::NUMBER_OF_ELITE_SCHEDULES;
                 $countCrossP = count($crossoverPopulation->getSchedules());
                  while ($n < $countCrossP){
                      if (Driver::CROSSOVER_RATE > Schedule::rand_float()) {
                        $schedule1 = $this->selectTornamentPopulation($population)->getSchedules()[0];
                        $schedule2 = $this->selectTornamentPopulation($population)->getSchedules()[0];
                        $crossoverPopulation->getSchedules()[$k] = $this->crossoverSchedule($schedule1, $schedule2);
                    } else {
                        $crossoverPopulation->getSchedules()[$k] = $population->getSchedules()[$n];
                    }
                    $n++;
                 }
		return $crossoverPopulation;
	}
      function crossoverSchedule(Schedule $schedule1, Schedule $schedule2) {
		$crossoverSchedule = new Schedule($this->data);
                $countSec = count($crossoverSchedule->getScheduledSections());
                $i = 0;
                while ($i < $countSec){
                    if(Schedule::rand_float() > 0.5){
                        $crossoverSchedule->getScheduledSections()[$i] = $schedule1->getScheduledSections()[$i];
                    }else{
                        $crossoverSchedule->getScheduledSections()[$i] = $schedule2->getScheduledSections()[$i];
                    }
                    $i++;
                }
  
		return $crossoverSchedule;
	}
    function mutatePopulation(Population $population) {
                $countSched = count($population->getSchedules());
                
		$mutatePopulation = new Population($countSched, $this->data);
		 $schedules = $mutatePopulation->getSchedules();
                 
                 $k = 0;
                 while ($k < Driver::NUMBER_OF_ELITE_SCHEDULES){
                     $schedules[$k] = $population->getSchedules()[$k];
                     $k++;
                 }
                 $n = Driver::NUMBER_OF_ELITE_SCHEDULES;
                  while ($n < $countSched){
                     $mutatePopulation->getSchedules()[$n] = $this->mutateSchedule($population->getSchedules()[$k]) ;
                     $n++;
                 }

            return $mutatePopulation;
	}
     function mutateSchedule(Schedule $mutateSchedule) {
		$schedule = new Schedule($this->data);
                $j = 0;
                $countSec = count($mutateSchedule->getScheduledSections());
                while ($j < $countSec){
                    if(Driver::MUTATION_RATE > Schedule::rand_float()){
                        $mutateSchedule->getScheduledSections()[$j]=$schedule->getScheduledSections()[$j];
                    }
                $j++;
            }
	return $mutateSchedule;
	}
    function selectTornamentPopulation(Population $population) {
            $tournamePopulation = new Population(Driver::TOURNAMENT_SELECTION_SIZE, $this->data);
            $i = 0;
            while ($i < Driver::TOURNAMENT_SELECTION_SIZE)
            {
                $index =  intval(count($population->getSchedules()) * Schedule::rand_float());
                $count = (($index >= count($population->getSchedules()))  || $index < 0)?0:$index;
               $tournamePopulation->getSchedules()[$i] =$population->getSchedules()[$count] ;
                $i++;
            }
           return $tournamePopulation;
      }
}
