<?php 
require 'check_session.php';
require '../head.html';

?>
<script src="../script/script_manageClasses.js" type="text/javascript"></script>
<style>
    #DataInput{
        margin: 1%;
        background-color: white;
        border-radius: 2%;
        padding: 1%;
        /*height: 60vh;*/
    }
    .modal-body .form-group{
        display: flex;
        margin: 1%;
    }
    .modal-body .form-group label{
        width: 40%;
        margin-right: 1%;
    }
    .modal {margin-top: 2%}
    .nav-tabs .nav-link {
    border-left: 1px solid lightgrey;
}


</style>
<body onload="display_inputData();" >
   <div class="individual-page">
        <div id="updatecoursesuccessNotification">course is successfully updated</div>
        <div id="updatecourseerrorNotification">unable to update a course</div> 
        <div id="deletecoursesuccessNotification">course is deleted successfully </div>
        <div id="deletecourseerrorNotification">unable to delete</div> 
        <div id="addcoursesuccessNotification">course is added successfully</div>
        <div id="addcourseerrorNotification">unable to add</div>  
     <div class="pageName">Data Input</div>
     <div class="page-styling" >
             <?php require '../filterGroupsForSectionsAndDataInputs.html';?>
     </div>
         <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                      <a class="nav-item nav-link active" id="nav-first-tab" data-toggle="tab" href="#nav-first" role="tab" aria-controls="nav-first" aria-selected="true">Courses </a>
                      <a class="nav-item nav-link" id="nav-second-tab" data-toggle="tab" href="#nav-second" role="tab" aria-controls="nav-second" aria-selected="false">Instructors</a>
                      <a class="nav-item nav-link" id="nav-third-tab" data-toggle="tab" href="#nav-third" role="tab" aria-controls="nav-third" aria-selected="false">Room</a>
                       <a class="nav-item nav-link" id="nav-four-tab" data-toggle="tab" href="#nav-four" role="tab" aria-controls="nav-four" aria-selected="false">MeetingTimes</a>

                    </div>
                </nav>
           <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-first" role="tabpanel" aria-labelledby="nav-first-tab">  
                     <div class="page-styling" style="margin-top:0" >
                   <div class="numofrecordsShown" style="padding-top:1.2%; padding-bottom: 1.2%;">Number of records shown: <span id="numofRecordsShownForDisplay_Courses">0</span></div>

                    <div style="width:10%; display: flex ; right: 0;  margin-top: -3.2%; margin-bottom: 0%; 
                             margin-left: 88.4%; margin-bottom: 0.8%">
                        <button  type='submit' class='btn btn-primary' id ="addSection"
                           style="  background-color: #138D75; z-index: 9999; border-radius: 5%" 
                           data-toggle="modal" data-target="#exampleModal_2" > Add Course </button>
                 </div>
                     <div>
                        <fieldset class="form-row">
                           <table id="InputCourseTable" style="width:99.4%; margin-left: 0.2%">
                                <thead class ="head-style">
                                    <tr><th>CourseID</th><th>Course Title</th><th>Major</th><th>CHrs.</th><th>MaxNumofStudents<br> Perclass</th><th>#OfClassesInDXB</th>
                                   <th>#OfClassesInADF</th><th>#OfClassesInADM</th><th>TotalClasses</th><th>-</th><th>-</th></tr>
                                </thead>
                                <tbody id="display_courses">

                               </tbody> 
                        </table>
                          </fieldset>
                    </div>  
                   <div class="showNumberofEntries" style="margin-left:1%; margin-top: 1%">showing <span id="oneEntryForDisplay_Courses">0</span> 
                            to <span id="numberofDisplayingForDisplay_Courses"> 0 </span>
                               <span style="padding-left:0.4%"> of </span> <span id="TotalnumberofEntriesForDisplay_Courses" style="padding-left:0.4%"> 0 </span>
                               <span style="padding-left:0.4%">entries</span>
                        </div> 
                   <br>
                    </div>
               </div>
              
                 <div class="tab-pane fade" id="nav-second" role="tabpanel" aria-labelledby="nav-second-tab">
                  <div class="page-styling" style="margin-top:0" >
                    <div class="numofrecordsShown" style="padding-top:1.2%; padding-bottom: 1.2%;">Number of records shown: <span id="numofRecordsShownForDisplay_Instructors">0</span></div>

                        <div style="width:15%; display: flex ; right: 0; margin-top: -3.2%; margin-bottom: 0%; 
                             margin-left: 88.4%; margin-bottom: 0.8%">
                            <button  type='submit' class='btn btn-primary' id ="addInstructorCourse"
                               style="  background-color: #138D75; z-index: 9999; border-radius: 5%" 
                               data-toggle="modal" data-target="#exampleModal_3" > Add QualifiedCourse </button>
                     </div>


                    <div>
                        <fieldset class="form-row">

                                <table  id="InstructorTable" style="width:99.6%; margin-left: 0.2%">
                                    <thead class="head-style"><tr> <th>ID</th><th>FirstName</th><th>LastName</th>
                                       <th>QualifiedIn</th> <th>College</th><th>Campus</th><th style="width:6%">-</th><th style="width:6%">-</th>
                                        </tr></thead>
                                        <tbody id="display_instructors" >

                                        </tbody>

                                </table>
                          </fieldset>
                        </div>
                        <div class="showNumberofEntries" style="margin-left:1%; margin-top: 1%">showing <span id="oneEntryForDisplay_Instructors">0</span> 
                            to <span id="numberofDisplayingForDisplay_Instructors"> 0 </span>
                               <span style="padding-left:0.4%"> of </span> <span id="TotalnumberofEntriesForDisplay_Instructors" style="padding-left:0.4%"> 0 </span>
                               <span style="padding-left:0.4%">entries</span>
                        </div> 
                    <br>
              </div>
                
       </div>
            <div class="tab-pane fade" id="nav-third" role="tabpanel" aria-labelledby="nav-third-tab">
                  <div class="page-styling" style="margin-top:0" >
                    <div class="numofrecordsShown" style="padding-top:1.2%; padding-bottom: 1.2%;">Number of records shown: <span id="numofRecordsShownForDisplay_Rooms">0</span></div>

                        <div style="width:15%; display: flex ; right: 0; margin-top: -3.2%; margin-bottom: 0%; 
                             margin-left: 88.4%; margin-bottom: 0.8%">
                            <button  type='submit' class='btn btn-primary' id ="addRoom"
                               style="  background-color: #138D75; z-index: 9999; border-radius: 5%" 
                               data-toggle="modal" data-target="#exampleModal_roomAdd" > Add Room </button>
                     </div>


                    <div>
                        <fieldset class="form-row">

                                <table  id="RoomTable" style="width:99.6%; margin-left: 0.2%">
                                    <thead class="head-style"><tr> <th>ID</th><th>Locatiom</th><th>Capacity</th>
                                       <th>camput</th><th style="width:6%">-</th><th style="width:6%">-</th>
                                        </tr></thead>
                                        <tbody id="display_rooms" >

                                        </tbody>

                                </table>
                          </fieldset>
                        </div>
                        <div class="showNumberofEntries" style="margin-left:1%; margin-top: 1%">showing <span id="oneEntryForDisplay_Rooms">0</span> 
                            to <span id="numberofDisplayingForDisplay_Rooms"> 0 </span>
                               <span style="padding-left:0.4%"> of </span> <span id="TotalnumberofEntriesForDisplay_Rooms" style="padding-left:0.4%"> 0 </span>
                               <span style="padding-left:0.4%">entries</span>
                        </div> 
                    <br>
              </div>
                
       </div>    
               
               <div class="tab-pane fade" id="nav-four" role="tabpanel" aria-labelledby="nav-four-tab">
                  <div class="page-styling" style="margin-top:0" >
                    <div class="numofrecordsShown" style="padding-top:1.2%; padding-bottom: 1.2%;">Number of records shown: <span id="numofRecordsShownForDisplay_MeetingTimes">0</span></div>

                        <div style="width:15%; display: flex ; right: 0; margin-top: -3.2%; margin-bottom: 0%; 
                             margin-left: 88.4%; margin-bottom: 0.8%">
                            <button  type='submit' class='btn btn-primary' id ="addMeetingTimes"
                               style="  background-color: #138D75; z-index: 9999; border-radius: 5%" 
                               data-toggle="modal" data-target="#exampleModal_MeetingTimesAdd" > Add Room </button>
                     </div>


                    <div>
                        <fieldset class="form-row">

                                <table  id="MeetingTimesTable" style="width:99.6%; margin-left: 0.2%">
                                    <thead class="head-style"><tr> <th>ID</th><th>Days</th><th>StartTime</th>
                                       <th>EndTime</th><th style="width:6%">-</th><th style="width:6%">-</th>
                                        </tr></thead>
                                        <tbody id="display_meetingTimes" >

                                        </tbody>

                                </table>
                          </fieldset>
                        </div>
                        <div class="showNumberofEntries" style="margin-left:1%; margin-top: 1%">showing <span id="oneEntryForDisplay_MeetingTimes">0</span> 
                            to <span id="numberofDisplayingForDisplay_MeetingTimes"> 0 </span>
                               <span style="padding-left:0.4%"> of </span> <span id="TotalnumberofEntriesForDisplay_MeetingTimes" style="padding-left:0.4%"> 0 </span>
                               <span style="padding-left:0.4%">entries</span>
                        </div> 
                    <br>
              </div>
           </div>
     </div>
         <?php require '../InstructorModals.html'; ?> 
        <?php require '../courseModals.html'; ?>  
         
               <?php require '../roomModals.html'; ?>  
      <?php require '../MeetingTimesModal.html'; ?>  

    </div>
     
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 
  <?php 
require '../footer.html';

?>  