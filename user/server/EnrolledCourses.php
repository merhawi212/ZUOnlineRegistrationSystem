<?php
require 'check_session.php';

include 'connection.php';
include '../header.html';
?>


<style>
     body{
        font-family: sans-serif;
        margin: 0;
        padding: 0;
    }
    td.rstatus{
        color: green;
    }
 
    #tEnrolled_Classes .head-style th{
        padding-left: 0.6%;
    }
</style>
<body onload="fetch_enrolledCourses_InHistory()">
     <div class="individual-page mh-100">
       <div class="pageName">View Enrolled Courses</div>
         <div class="page-styling" >
        <div class="container-register">
            
            <div class="numofrecordsShown">Number of records shown: <span id="numofRecordsShown">0</span></div>
                <fieldset class="form-row">
                        <div class=" col-md-12">
                            <table id="tEnrolled_Classes" style="z-index:99999" >
                                    <thead class="head-style"> <th>Course Title</th><th>Course No.</th><th>Subject</th> 
                                     <th>Major</th><th>CreditHrs.</th> <th>CRN</th><th>Section No</th>
                                     <th>Instructor</th><th>MeetingTime</th><th>EnrolledDateTime</th> <th>Status</th>
                                   
                            </thead>
                                    <tbody id="enrolled_Courses" >

                                    </tbody>

                            </table>
                       </div>
                  </fieldset>
            
        </div>
          <div class="showNumberofEntries" style="margin-left:1%">showing <span id="oneEntry">0</span> to <span id="numberofDisplaying"> 0 </span>
                           <span style="padding-left:0.4%"> of </span> <span id="TotalnumberofEntries" style="padding-left:0.4%"> 0 </span>
                           <span style="padding-left:0.4%">entries</span>
          </div> 
             <br>
         </div>
     </div>
    <script>
     $(window).load(function() {
   $('.preloader').fadeOut('slow');
});
  </script>
  <script src="http://code.jquery.com/jquery-2.2.1.min.js"></script>

<?php include '../footer.html' ;?>
