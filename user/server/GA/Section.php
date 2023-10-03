<?php

 class Section {
	private $CRN;
	private $Section_No;
	private  $MeetingDay;
	private  $StartTime;
	private $EndTime;
	private  $Fac_ID;
	private $course_ID;
        
        function __construct($CRN, $Section_No, $MeetingDay, $StartTime,
                $EndTime, $Fac_ID, $course_ID) {
            
		$this->CRN = $CRN;
		$this->Section_No = $Section_No;
		$this->MeetingDay = $MeetingDay;
		$this->StartTime = $StartTime;
		$this->EndTime = $EndTime;
		$this->Fac_ID = $Fac_ID;
		$this->course_ID = $course_ID;
	}

	function  getCRN() {
		return $this->CRN;
	}

	function getSection_No() {
		return $this->Section_No;
	}

	function getMeetingDay() {
		return $this->MeetingDay;
	}

	function getStartTime() {
		return $this->StartTime;
	}

	function getEndTime() {
		return $this->EndTime;
	}

	function getFac_ID() {
		return $this->Fac_ID;
	}

	function getCourse_ID() {
		return $this->course_ID;
	}

	function __destruct() {
            $this->result = array($this->getCRN(), $this->getSection_No(), $this->getStartTime(), $this->getMeetingDay(),
                    $this->getEndTime(), $this->getCourse_ID(), $this->getFac_ID());
            return $this->result;
	}
}

