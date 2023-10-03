<?php 
require 'check_session.php';
require '../head.html';

?> 
<script src="../script/script_student.js" type="text/javascript"></script>
<style>
    #student_page{
        background: white;
        padding: 1%;
        margin: 1%;
    }
    .modal-xl {
    max-width: 1540px;
    }
    .enrolledstatus{
        color: green;
    }
    #exampleModal_2{
        margin-top: 2%;
    }
    #AddDropApprovalRequestsuccessNotification, #AddDropApprovalRequesterrorNotification{
        margin-left: 4%;
        display: none;
    }
  .ActionNotNeeded td a, .needsAction td a{
         color: black
    }
    .needsAction {
        background: #F8D7D0;
    }
    .needsAction:hover{
        background:  #861b1b!important;
        color: white;
    }
    .ActionNotNeeded{
        background: #DFE9EE;
       
    }
    .ActionNotNeeded:hover{
        background:  #173c63!important;
        color: white;
    }

    
    #nav-fourth, #nav-fourth-tab{
        visibility:  hidden;
    }
    #nav-fourth-tab{color: lightcoral}
    .nav-tabs .nav-link{
        border-left: 1px solid  lightgrey  ;
    }
 .successNotification, .errorNotification{

       color: red;
        font-weight: bold;
        /*padding: 2%;*/
        color: white;
      
      
    }
    .successNotification{ color: green;  }
    #EnrollsuccessNotification, #EnrollerrorNotification{display: none}
    
</style>
<body onload="display_students();">
    <div class="individual-page">
        
    <div class="pageName">Students' Courses</div>
         <div id="EnrollsuccessNotification" >Student Enrolled to course successfully</div>
         <div id="EnrollerrorNotification">Exceeds Max Course load</div>     
    <div class="page-styling" >
           <div id="filter-control" class="form-row">
                       <div class="form-group col-md-2" style="margin-left:0.4%">
                       <label> Student ID: </label>
                       <div class="form-group">
                           <input type="text" onkeyup="search_by();" class="form-control filter_by" id="std_id" placeholder="">

                     </div>
                     </div>
                        <div class="form-group col-md-2" style="margin-left:0.4%">
                           <label>CGPA > than: </label>
                           <div class="form-group">
                              <input type="number" onkeyup="search_by();" class="form-control filter_by" id="CGPAGreaterThan" >

                         </div>

                     </div>
                   <div class="form-group col-md-2" style="margin-left:0.4%">
                           <label>Major: </label>
                           <div class="form-group">
                              <input type="text"  onkeyup="search_by();" class="form-control filter_by" id="major" >

                         </div>
                     </div>
                  <div class="form-group col-md-2" style="margin-left:0.4%">
                           <label>College: </label>
                           <div class="form-group">
                              <input type="text" onkeyup="search_by();"  class="form-control filter_by" id="college">

                         </div>
                 </div>
               <div class="form-group col-md-1" style="margin-left:1%">
                           <label>Campus: </label>
                           <div class="form-group">
                              <input type="text" onkeyup="search_by();"  class="form-control filter_by" id="campus">

                         </div>
                 </div>
               <div class="form-group col-sm-1" style="margin-left:0.4%; width: 10%; ">
                           <label>IsAdd/DropRequestOnHold: </label>
                           <div class="form-group">
                               <select class="form-control filter_by" id="addDropOnholdStatus" onchange="search_by();">
                                   <option value="All">All</option>
                                   <option value="Yes">Yes</option><!-- comment -->
                                   <option value="No">No</option>
                               </select>              
                         </div>
                     </div>

            </div>
    </div>
    
     <div  style="  padding-top: 0.5%; padding-bottom: 0.5%;  margin-bottom: 0; margin-left: 1%;margin-top: 0.5%; font-size: 16px">

        <i class="fa fa-info-circle" aria-hidden="true"></i><span style="padding-left:1%; ">
          The lightcoral background color of a row indicates either a student is under enroll or there is add/drop request not that has not taken an action by admin . 
        </span>
                  
      </div>
     
    <div class="page-styling" >
          <div class="numofrecordsShown">Number of records shown: <span id="numofRecordsShownForDisplay_Students">0</span></div>

          <div>
                      <fieldset class="form-row">

                                  <table class="sortable" id="studentTable" style='margin-left:0.2%; width: 99.6%'>
                                      <thead class="head-style"><tr><th style="width:8%">-</th> <th>ID</th><th>FirstName</th><th>LastName</th><th>Gender</th>
                                          <th>Major</th><th>College</th><th>Campus</th><th>GPA</th><th>status</th><th>Total <br>EnrolledCHrs.</th>
                                          <th>IsUnderEnroll</th><th>IsAdd/DropRequestOnHold</th>

                                          </tr></thead>
                                          <tbody id="display_students" >

                                          </tbody>

                                  </table>
                        </fieldset>
          </div>
           <div class="showNumberofEntries" style="margin-left:1%; margin-top: 1%">showing <span id="oneEntryForDisplay_Students">0</span> 
               to <span id="numberofDisplayingForDisplay_Students"> 0 </span>
            <span style="padding-left:0.4%"> of </span> <span id="TotalnumberofEntriesForDisplay_Students" style="padding-left:0.4%"> 0 </span>
                             <span style="padding-left:0.4%">entries</span>
            </div> 
          <br>
    </div>
    <?php    require '../studentModals.html';?>

 
 </div>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
   
  <?php 
require '../footer.html';

?>  