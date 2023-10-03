<?php 
require 'check_session.php';
include 'connection_2.php';
require '../head.html';

  if(isset($_POST['saveclasses'])){
    $courseID= $_POST['tableRow'];
    $i = 0;
    $query_2 = "DELETE FROM section WHERE EXISTS (SELECT * FROM section)";
    $result_2 = mysqli_query($connection_2, $query_2);
    foreach($courseID as $row){
//        if ($i >= 18){
//        echo print_r($row).'<br/>';
        $crn= $row['CRN'];
        $courseID = $row['courseID'];
        $sectionNum = $row['sectionNum'];
        $meetingDay = $row['MeetingTime'];
        $startTime = $row['StartTime'];
        $endTime= $row['EndTime'];
        $roomID= $row['Room_ID'];
        $faculty_ID= $row['Faculty_ID'];
        $campus= $row['campus'];
        if ($campus === 'ADF') {
            $sectionNum = '00' . $sectionNum;
        }
       
        $query = "insert into university_class_scheduler.section  "
            ."  values('$crn', '$sectionNum', '$meetingDay', '$startTime', '$endTime',"
                . " '$courseID', '$roomID', '$faculty_ID', '$campus', '0' )";    
        $result = mysqli_query($connection_2, $query);
       
        if (!$result) {
                 die("unable to insert into table". mysqli_error($connection_2));
            }
//        }
        $i++;
}
}  
?>
<script src="../script/script_manageClasses.js?2" type="text/javascript"></script>
<style>
    #ManageClasses{
        margin: 1%;
        padding: 1%;
        background: white;
    }
</style>
<body onload="display()">
     <div class="individual-page">
        <div id="updatesuccessNotification">section is successfully updated</div>
        <div id="updateerrorNotification">unable to update</div> 
        <div id="deletesuccessNotification">section is deleted successfully </div>
        <div id="deleteerrorNotification">unable to delete</div> 
        <div id="addsuccessNotification">section is added successfully</div>
        <div id="adderrorNotification">unable to add</div> 
        <div class="pageName">Class Schedule Creator</div>
     <div class="page-styling" >
        <?php require '../filterGroupsForSectionsAndDataInputs.html';?>
     </div>
         <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                      <a class="nav-item nav-link active" id="nav-first-tab" data-toggle="tab" href="#nav-first" role="tab" aria-controls="nav-first" aria-selected="true">Generated Classes </a>
                      <a class="nav-item nav-link" id="nav-second-tab" data-toggle="tab" href="#nav-second" role="tab" aria-controls="nav-second" aria-selected="false">Create ClassesSchedules</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-first" role="tabpanel" aria-labelledby="nav-first-tab">  
                       <div class="page-styling" style="margin-top:0" >
                        <div class="numofrecordsShown" style="padding-top:1.2%; padding-bottom: 1.2%;">Number of records shown: <span id="numofRecordsShownForDisplay_Created_Classes">0</span></div>

                         <div style="width:10%; display: flex ; right: 0;  margin-top: -3.2%; margin-bottom: 0%; 
                             margin-left: 88.4%; margin-bottom: 0.8%">
                             <button  type='submit' class='btn btn-primary' id ="addSection"
                                style="  background-color: #138D75; z-index: 9999; border-radius: 5%" 
                                data-toggle="modal" data-target="#exampleModal_2" > Add Section </button>
                      </div>
                          <div>
                             <fieldset class="form-row">
                                <table class="classSchedulerTable" style="width:99.4%; margin-left: 0.2%">
                                     <thead class ="head-style">
                                     <tr><th>Course Title</th><th>CourseID</th><th>Major</th><th>CHrs.</th><th>CRN</th><th>Section Number</th>
                                        <th>Instructor</th><th>MeetingTime</th><th>Location</th><th>Campus</th><th>Capacity</th><th>-</th><th>-</th></tr>
                                     </thead>
                                     <tbody id="display_created_Classes">

                                    </tbody> 
                             </table>
                               </fieldset>
                         </div>   
                        <div class="showNumberofEntries" style="margin-left:1%; margin-top: 1%">showing <span id="oneEntryForDisplay_Created_Classes">0</span> 
                                 to <span id="numberofDisplayingForDisplay_Created_Classes"> 0 </span>
                                    <span style="padding-left:0.4%"> of </span> <span id="TotalnumberofEntriesForDisplay_Created_Classes" style="padding-left:0.4%"> 0 </span>
                                    <span style="padding-left:0.4%">entries</span>
                             </div> 
                        <br>
                    </div>

                    </div>
         <div class="tab-pane fade" id="nav-second" role="tabpanel" aria-labelledby="nav-second-tab">
              <div class="page-styling" style="margin-top:0" >
                  <div class="numofrecordsShown" style="padding-top:1.2%; padding-bottom: 1.2%;">Number of records shown: <span id="numofRecordsShownForDisplay_NewGenerated_Classes">0</span></div>

              
                <div style="width:10%; display: flex ; right: 0;  margin-top: -3.2%; margin-bottom: 0%; 
                             margin-left: 88.4%; margin-bottom: 0.8%">
                        <button  type='submit' class='btn btn-primary' style="  background-color: green; z-index: 9999; border-radius: 5%" 
                           onclick="GenerateClassSchedule();"  id="generateClassSchedule" > Generate Classes </button>
                 </div>
                        <form method="post" action="#">
                     <div style="margin-top:0.2%; width: 100%">
                         <table class="classSchedulerTable" style="width:100%; ">
                                <thead class ="head-style">
                                <tr><th>CourseID</th><th>Course Title</th><th>Major</th><th>CRN</th><th>Section Number</th>
                                   <th>Instructor</th><th>MeetingTime</th><th>Location</th><th>Campus</th><th>Capacity</th>
                                </tr>
                                </thead>
                                <tbody id="display_classSchedule">

                               </tbody> 
                        </table>
                        </div>
                      <div class="showNumberofEntries" style="margin-left:1%; margin-top: 2%">showing <span id="oneEntryForDisplay_NewGenerated_Classes">0</span> 
                                 to <span id="numberofDisplayingForDisplay_NewGenerated_Classes"> 0 </span>
                                    <span style="padding-left:0.4%"> of </span> <span id="TotalnumberofEntriesForDisplay_NewGenerated_Classes" style="padding-left:0.4%"> 0 </span>
                                    <span style="padding-left:0.4%">entries</span>
                             </div> 
                        
                    
                        <div style="width:10%; display: flex ; right: 0; margin-bottom: 0.5%; margin-left: 88%;margin-top: -1.5%">
                        <button  type='submit' class='btn btn-primary' style="  background-color: green; z-index: 9999; border-radius: 5%" 
                           id="saveClassSchedule"  name="saveclasses"> Save Classes </button>
                    </div>
                    </form>
                  <br>
                    </div>
             </div>
                    
                </div>
        
       <?php    require '../classSchedulerModals.html';?>

    </div>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 <?php 
require '../footer.html';

?>  

