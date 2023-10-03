<?php 
require 'check_session.php';
require '../head.html';

?>


<style>
    #ExistingaddDropCourses{
        margin: 1%;
        /*margin-top: %;*/
        background: white;
        height: 72vh;
        border-radius:  1%;
    }
  
</style>

    
 <div id="ExistingaddDropCourses">
        <div id="filter-control" class="form-row" style="margin-left:2%">
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


        <div class=" form-group col-md-12">
            <table id="ExistingAddDropRequestTable" style="z-index:99999">
                    <thead class="head-style"> <th style="width:12%">CourseTitle</th><th>CourseNo</th>
                     <th>Subject</th><th>Major</th><th style="width:4%">CHrs.</th> <th>CRN</th><th>Sec No</th>
                     <th>Instructor</th><th>MeetingTime</th> <th>SeatsLeft</th><th style="width:5%">ReqType</th>
                    <th>ReqDate</th> <th>Status</th>
            </thead>
                    <tbody id="AddDropTableHistory" >
                    <td colspan="13" style="text-align: center">Data is not available!</td>
                    </tbody>

            </table>
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
        

     $(window).load(function() {
   $('.preloader').fadeOut('slow');
});
  </script>
  <script src="http://code.jquery.com/jquery-2.2.1.min.js"></script>
  
  
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                      <a class="nav-item nav-link active" id="nav-first-tab" data-toggle="tab" href="#nav-first" role="tab" aria-controls="nav-first" aria-selected="true">Current Classes </a>
                      <a class="nav-item nav-link" id="nav-second-tab" data-toggle="tab" href="#nav-second" role="tab" aria-controls="nav-second" aria-selected="false">Generate Classes</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-first" role="tabpanel" aria-labelledby="nav-first-tab">
                       
                          

                    </div>
                    <div class="tab-pane fade" id="nav-second" role="tabpanel" aria-labelledby="nav-second-tab">
                            
                    </div>
                    
                </div>
                  
