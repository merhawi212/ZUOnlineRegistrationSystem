<?php
require 'check_session.php';

include 'connection.php';
include '../header.html';
?>
<style>
    #ExistingaddDropCourses{
        margin: 1%;
        margin-top: 2%;
    }
</style>
 <div class="individual-page">
     <div class="pageName">My Add/Drop Page</div>
         
        <div id="ExistingaddDropCourses">
        <div id="filter-control" class="form-row" style="margin-left:0.0%; width: 99.8%">
                <div class="form-group col-md-2">
                      <label>Course No: </label>
                      <div class="form-group">
                          <input type="text"  class="form-control filter_AddDropBy" id="search_course" placeholder="Quick search...MTH215">

                    </div>
                </div>
                   <div class="form-group col-md-2" style="margin-left:0%">
                      <label>Course Name: </label>
                      <div class="form-group">
                         <input type="text"  class="form-control filter_AddDropBy" id="courseName" placeholder="Data Analytics">

                    </div>
                </div>
                 <div class="form-group col-md-2" style="margin-left:0%">
                      <label>CRN: </label>
                      <div class="form-group">
                         <input type="text"  class="form-control filter_AddDropBy" id="crn" placeholder="22111">

                    </div>
                </div>
              <div class="form-group col-md-2" style="margin-left:0%">
                      <label>Major: </label>
                      <div class="form-group">
                         <input type="text"  class="form-control filter_AddDropBy" id="major" placeholder="Major name ">

                    </div>
                </div>
             
                <div class="form-group col-md-1" style="margin-left:0%">
                      <label>Status: </label>
                      <div class="form-group">
                          <select class="form-control filter_AddDropBy" id="status">
                              <option value="All">All</option>
                              <option value="Requested">Requested</option>
                               <option value="Inprogress">Inprogress</option>
                              <option value="Aproved">Aproved</option>
                              <option value="Rejected">Rejected</option>
                          </select>
                    </div>
                </div>
            <div class="form-group col-md-1" style="margin-left:0%">
                      <label>RequestType: </label>
                      <div class="form-group">
                          <select class="form-control filter_AddDropBy" id="reqType">
                              <option value="All">All</option>
                              <option value="Add">Add</option>
                               <option value="Drop">Drop</option> 
                          </select>
                    </div>
                </div>
            </div>

        <div class="page-styling" >  
         <div class="numofrecordsShown" >Number of records shown: <span id="numofRecordsShown">0</span></div>

        <div class=" form-group col-md-12">
            <table id="ExistingAddDropRequestTable">
                    <thead class="head-style"> <td style="width:12%">CourseTitle</td><td>CourseNo</td>
                     <td>Subject</td><td>Major</td><td style="width:4%">CHrs.</td> <td>CRN</td><td>Sec No</td>
                     <td>Instructor</td><td>MeetingTime</td> <td>SeatsLeft</td><td style="width:5%">ReqType</td>
                    <td>ReqDateTime</td> <td>Status</td>
            </thead>
                    <tbody id="AddDropTableHistory" >
                    <td colspan="13" style="text-align: center">Data is not available!</td>
                    </tbody>

            </table>
       </div>
          <div class="showNumberofEntries" style="margin-left:1%; margin-top: 1%">showing <span id="oneEntry">0</span> to <span id="numberofDisplaying"> 0 </span>
                           <span style="padding-left:0.4%"> of </span> <span id="TotalnumberofEntries" style="padding-left:0.4%"> 0 </span>
                           <span style="padding-left:0.4%">entries</span>
          </div> 
         <br>
 </div>

 </div>
 </div>


  <script>

      fetch_AddDropRequestHistory();
  function fetch_AddDropRequestHistory(course_id='', courseName ='', crn='', 
                                                major_id='', requestType='', status=''){
        $.ajax({
            type: "POST",
            url: "../server/controller_2.php", 
            dataType: "json",
            data: {request_type:"get_existingAddDropRequest", CourseID:course_id, 
                        CourseName:courseName, CRN:crn, Major:major_id, ReqType:requestType, status:status},
             success: function(data){
                    var section = '';  
                     if(data.length === 0) 
                           section =`<tr><td colspan="13" style="text-align:center">Data Is Not Avaliable!</td></tr>`;
                     else
                        section = sectionFromat(data, 'RetriveAddDropRequested');

                    $("#AddDropTableHistory").html(section);
                     $("#numofRecordsShown").html(`<b>${data.length}</b>`);
                    if (data.length > 0)
                        $("#oneEntry").html(`<b>1</b>`);
                    $("#numberofDisplaying").html(`<b>${data.length}</b>`);
                    $("#TotalnumberofEntries").html(`<b>${data.length}</b>`);

             }
             });
        }
        var  courseid, courseName, crn,major;
        $('.filter_AddDropBy').keyup(function(){
            
           var courseid =  $('#search_course').val();
         var  courseName  = $("#courseName").val();
         var  crn =  $('#crn').val();
        var major =  $('#major').val();
         if(courseid !== '' || crn !=='' || courseName !=='' ||  major !== '' )
         {
          fetch_AddDropRequestHistory(courseid, courseName,crn, major);
         }
         else 
         {
          fetch_AddDropRequestHistory();
         }
        });
        
        $('.filter_AddDropBy').change( function(){
             var reqType =  ($('#reqType').val()==='All')?'':$('#reqType').val();
             var status =  ($('#status').val()==='All')?'':$('#status').val();
             if(reqType !== '' || status !=='' )
            {
                fetch_AddDropRequestHistory('', '','', '', reqType, status);
            }
            else 
            {
                fetch_AddDropRequestHistory();
            }
        });
        

  $(window).on('load', function(){
   $('.preloader').delay(800).fadeOut('slow');
 
});
  </script>
  <script src="http://code.jquery.com/jquery-2.2.1.min.js"></script>
  <?php include '../footer.html' ;?>