
<?php 
require 'check_session.php';
include '../header.html';
include 'connection.php'; 

?>


         <script src="http://code.jquery.com/jquery-2.2.1.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
 
<script src="../script/script2.js" type="text/javascript"></script>

    
<link href="../style/scheduler.css" rel="stylesheet" type="text/css"/>
   <style> 
       .FilterGroup, .scheduleClass{
           box-shadow:   0px 0px 2px 2px  #e4e4e4;
        border-color: #e4e4e4;
        background:  #eff3f8;
       }
button.multiselect.dropdown-toggle.btn.btn-default {
     -webkit-transition: 0.5s all;
    -moz-transition: 0.5s all;
    -o-transition: 0.5s all;
    -ms-transition: 0.5s all;
    max-width: 13.3em;
    white-space: nowrap;
    overflow: hidden;
}
.FilterGroup .form-group{
    width: 100%;
}
   </style>
  
   <body onload="display()" style=" background:  lightgrey;">
 <div class="individual-page" style="">
            <div id="successNotification">Courses are successfully registered   </div>
             <div id="deletesuccessNotification">Course is successfully deleted from cart   </div>
             <div id="errorNotification">Exceeds Max Course Load!</div>
             <div id="AddedSuccessNotification">Course is successfully added to cart   </div>
          <div class="pageName">Class Schedule</div>
         <div class="page-styling" style="padding-bottom: 0.6%; width: 99.8%">     
        
           <div class='form-row TopFilterGroup'  >
               <div class="form-group col-md-9">
                   <label for="courseID">Add Courses From Projection</label>
                       <select name="search-course-projection" id="courseID" class="form-control input-lg">
                       </select>

                </div>
               <button  type='submit' class='btn btn-primary' id ="addcourseToscheduler"   onclick="add_Course_ToCart_BySearch();"
                         style="  background-color: green; z-index: 9999;"> Add </button>

             </div>
             
        </div>
           <div class="page-styling" style="padding-bottom: 0.6%; padding-top: 0.6%; margin-right: 1%;   ">  
               <div class="infoNotice" style=" margin-left: 12%; display: flex; width: 74%; ">
                    <div  style="  margin-top: 1%; width: 100% ">

                     <i class="fa fa-info-circle" aria-hidden="true"></i><span style="padding-left:1%; ">If you cannot see any section for the added course(s) that is on the browse page, but not
                         on this page, it means that either the section is full or you cannot register on it due to time conflict. 
                        </span>
                     <br>
                     <i class='fas fa-exclamation-triangle' style="color: #F0871E"></i><span style="color:red; padding-left:1%">
                         Registration is only one time! Please make sure to 
                         add all courses you want to register to the schedule builder</span>
                 </div>
               </div>
              <div id="viewEnrolledCourse" style="  float: right; margin-right: 1%">
                 <a href="EnrolledCourses.php" class='btn btn-primary'  style=" padding: 6%; background-color:  #086277; 
                    z-index: 999; border-radius: 5%" >View Enrolled Course</a>
             </div>
               
           </div>
        
                <div class="form-row FilterGroup">

                         <div class="form-group">     
                                  <label for="courseID_inCart">Search Courses</label>
                                <select name="courses[]" id="courseID_inCart" multiple class="form-control" >

                                </select>
                         </div>

                        <div class="form-group" style="margin-left:-1%">     
                                  <label for="course_Instructor">Select Instructors</label>
                                <select name="course_Instructor[]" id="Instructors" multiple class="form-control" >
                                    <!--<option value="">Select Instructor</option>-->
                                </select>
                         </div>
                          <div class="form-group col-md-10" style="margin-left:-1.6%">   

                                  <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">

                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" 
                                                aria-expanded="false" aria-controls="flush-collapseOne" style="pading-left:2%;z-index: 999 ">

                                            Days

                                        </button>
                                    </div>
                                      <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                                    <input type="checkbox" name ='day' value ="1" id ='M' class="day">   
                                              <label for="M-day">Monday</label> </br>
                                             <input type="checkbox" name ='day' value ="2" id ='T' class="day">
                                             <label for="T-day">Tuesday</label> </br>
                                             <input type="checkbox" name ='day' value ="4" id ='W' class="day">
                                             <label for="W-day">Wednesday</label> </br>
                                             <input type="checkbox" name ='day' value ="8" id ='TH' class="day">
                                             <label for="TH-day">Thursday</label> </br>
                                             <input type="checkbox" name ='day' value ="16" id ='F' class="day">
                                              <label for="F-day">Friday</label>
                                        </div>
                                      </div>

                                  </div>


                          </div>

                 <div class="form-group" style="z-index:999; width: 100%">
                        <label for="TimeStart" style="display:block; float: none">Time Range</label>

                        <input type="time" id="TimeStart" name="startTime" value="" min="08:00" max="17:00" required> </br>
                        <span>TO </span> <br>
                      <input type="time" id="TimeEnd" name="endTime" value="" min="09:00" max="18:00" required>
                 </div>
                  
                 
                <div class="form-group" style="z-index:999; width: 10%; margin: 1%; margin-bottom: 2%">
                       <input type="submit" name="clear" value="ClearAll" id="clearAll" style="margin-left:1%; 
                              border-radius: 8%; background:  #333; color: white " onclick="clearAll();">

                 </div>
               
                    
                <div class="form-group" id="generate-schedule-button" style="z-index:999; width: 100%; display: block " >     
                   <button  type='submit' class='btn btn-primary' id ="process_Schedule"   onclick="generate_Schedule();"
                           style="background-color: lightseagreen; z-index: 99999;"> Generate Schedule </button>

                </div>
           
          

          </div>
                <div class="scheduleClass">
                  

                 <div class="generatedSchedule"> 
      
                     <table class="GAScheduleTable"><tr><th>options  </th><th>Course Title</th><th style="width:12%">Subject</th>
                             <th>CourseID</th><th>CreditHr.</th><th>CRN</th><th>MeetingTime</th>
                            <th>Location</th><th>Instructor Name</th><th>SeatLeft</th><th>Action</th></tr>
                         <tbody id="display_schedule">
                         <td colspan="11" style="text-align: center"> Loading...</td>
                         </tbody>

                     </table>

                 </div>
       
     </div>
             <br>
 </div>
<?php include '../footer.html' ;?>
 <script>
     
     function clearAll(){
         $('#TimeStart').val('');
         $('#TimeEnd').val('');
         
         $("input:checkbox[name=day]:checked").each(function (){
              $(this).prop('checked',false);
         });
//        $("#courseID_inCart").multiselect("uncheckAll");
          generate_Schedule();
         
     }
   
 $(window).on('load', function(){
   $('.preloader').fadeOut('slow');
 
});

  </script>

  
   </body>
   
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
     
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
 
