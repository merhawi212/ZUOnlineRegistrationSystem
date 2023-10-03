<?php
//include 'Data.php';
//include 'Schedule.php';
//include 'Data.php';
//include '../include/autoloader.inc.php';
class Population {
    private  $population;
    private $size;
    private $data;
            
    function __construct($size, Data $data) {
        $this->size= $size;
        $this->data =$data;
        $this->population = [];
        $this->i =0;
         while ($this->size != 0) {
            $this->population[$this->i] =  (new Schedule($this->data));
            $this->size--;
            $this->i++;
            
        }
    }

    function getSchedules() {
        return $this->sortByFitness();
    }
     function  sortByFitness() {
         
         usort($this->population,function($schdule1,$schdule2){
                return $schdule1->getFitness() < $schdule2->getFitness();
               
            });
        return $this->population;
	}
        
}


