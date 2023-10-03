<?php
require 'check_session.php';

include 'connection.php';

if(empty($_SESSION['pinForAddDrop'])){
     header("Location:pin_adddrop.php");
}
include '../header.html';
?>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
 -->

<style>
     body{
        font-family: sans-serif;
        margin: 0;
        padding: 0;
    }
    td.rstatus{
        color: green;
    }
    td.NotAvailable{
        color: red;
    }
    button.drop-section{
        background-color:  lightcoral; 
        border-radius: 10%;
    }
    button.drop-section:hover{
        background-color: red;
    }
   
   
    .container-addDrop{
        margin-top: 6%;
    }
    .timeConflict{
        display: none;
    }
td.disabled:hover #EnrollCourse{
    display: none;
}
 td.disabled:hover:before{
     content: 'Conflict!';
     font-size:  12px;
     z-index: 2147483647;
     color: red; 
        /*visibility: visible;*/
    }

    #pin-form{
        display: none;
    }
  
    #DropRequestErrorNotification, #AddRequestErrorNotification{
        margin-left: 20%;
        width: 30%;
        background-color: lightcoral;
        font-weight: bold;
        
        
    }
     .modal-xl {
    max-width: 1540px;
    }
    .modal{
        margin-top: 5%;
    }
    #dropCourse {
        background-color: red;  opacity: 0.8;
     color: white}
    
    #dropCourse:hover{
        background-color:  red;
        opacity: 1;
    }
    #addcourse{background-color: green;  opacity: 0.8;}
     #addcourse:hover{background-color: green;  opacity: 1;}
    
</style>
<body  onload='fetch_addDropIncart(); '>
     <div class="individual-page">
         <div class="pageName">Add/Drop Request Page</div>
         
          <div id="models" class="ModalButtonsToAddDrop" style=" margin-bottom: 2%; padding: 2.4% ">
                <div  style=" width: 60% ">
                     <i class='fas fa-exclamation-triangle' style="color: #F0871E"></i><span style="color:red; padding-left:1%; font-size: 14px">
                        You must not request Add/Drop course(s) more than one time! System will not allow you to do that.
                     </span>
                 </div>     
               <?php require '../AddDropRequestModels.html'; ?>

         </div>
         <div id="AddDropPage" >
               <div id="successNotification">Add/Drop is submitted successfully </div>
               
             <div class="page-styling" >
            <div class="numofrecordsShown" style="margin-top:1%">Number of records shown: <span id="numofRecordsShown">0</span></div>


                   <div class="addDropRequestPage ">

                           <div class=" form-group col-md-12">
                               <table id="ExistingAddDropRequestTable" style="z-index:99999">
                                   <thead class="head-style"> <td>Course Title</td><td>Course No</td><td>Subject</td><td>Major</td><!-- comment -->
                                   <td>Credit Hrs</td> <td>CRN</td><td>Section No</td> <td>Instructor</td><td>MeetingTime</td> <td style="width:8%">RequestType</td>
                                        <td style="width:8%">Action</td>
                               </thead>
                                       <tbody id="AddDrop_Courses_cart" >
                                       <td colspan="11" style="text-align: center">No records available</td>
                                       </tbody>

                               </table>
                               <br> 
                       </div>
                       <div class="showNumberofEntries" style="margin-left:1%">showing <span id="oneEntry">0</span> to <span id="numberofDisplaying"> 0 </span>
                           <span style="padding-left:0.4%"> of </span> <span id="TotalnumberofEntries" style="padding-left:0.4%"> 0 </span>
                           <span style="padding-left:0.4%">entries</span>
                       </div>
                       
                       <div class=" form-group" style="margin-top:-2%; float: right; margin-right: 1%" >
                           <button type="submit" id="submitAddDropRequest" name="submit" onclick="submitAddDropRequest();" 
                                    class="btn btn-primary"  style="background:green;   margin-top: 1%">Submit Request</button>

                       </div>
                   </div>

               <br>

           </div>
              <br> <br> <br>
         </div>
     </div>
   
  <?php include '../footer.html' ;?>
 <script>
   
    
 function fetch_addDropIncart(){
    var type ='saveAddDropRequestTocart';
    $("#submitAddDropRequest").prop('disabled', true);
    $.ajax({
           method: "POST",
           url: "controller_2.php",
           dataType: "json",
           data: {request_type:"fetch_addDropCart"},
           success: function(data){
               var section ='';
            if(data.length === 0) {
                section =`<tr><td colspan="11" style="text-align:center">No records available</td></tr>`;
                
            }
            else{
                 section =sectionFromat(data, type);
                 $("#submitAddDropRequest").prop('disabled', false);
                 getTrackerResult('submitAddDropRequest');
                 $("#oneEntry").html(`<b>1</b>`);
                 
                 
             }
             $("#AddDrop_Courses_cart").html(section);
              $("#numofRecordsShown").html(`<b>${data.length}</b>`);
              $("#numberofDisplaying").html(`<b>${data.length}</b>`);
               $("#TotalnumberofEntries").html(`<b>${data.length}</b>`);
             
            
             
           }
       });
}
 $(function (){   
 fetch_enrolledCourses();
   function fetch_enrolledCourses(){
     $.ajax({
        method: "POST",
        url: "controller.php",
        
        dataType: "json",
        data: {request_type: "fetch_enrolled_courses"},
        success: function (data) {
            var section =sectionFromat(data, 'enrolledCoursesTODrop');
             $("#AddDrop_Courses").html(section);
             if (data.length > 1)
                  $("#oneEntryofDropToRequest").html(`<b>1</b>`)
            $("#numofRecordsShownDropToRequest").html(`<b>${data.length}</b>`);  
            $("#numberofDisplayingofDropToRequest").html(`<b>${data.length}</b>`);
            $("#TotalnumberofEntriesofDropToRequest").html(`<b>${data.length}</b>`);
             
        }
    });   
    }

    });
$(document).ready(function (){
    load_sections();
});
        function load_sections(course_id=''){
        $.ajax({
                type: "POST",
                url: "controller.php", 
                dataType: "json",
                data: {request_type:"get_sections_by_CourseID",course_ID: course_id},
                 success: function(data){
                        var section = '';  
                         if(data.length === 0) 
                               section =`<tr><td colspan="9" style="text-align:center">No records available</td></tr>`;
                           
                         else{
                            section = sectionFromat(data, 'addToEnroll');
                              $("#oneEntryofAddToRequest").html(`<b>1</b>`);
                        }
                       
                         $("#sections").html(section);
                         $("#numofRecordsShownAddToRequest").html(`<b>${data.length}</b>`);  
                        $("#numberofDisplayingofAddToRequest").html(`<b>${data.length}</b>`);
                         $("#TotalnumberofEntriesofAddToRequest").html(`<b>${data.length}</b>`);
                         
                        
                 }
        });
        }
       

 $("#AddBycourseID").change(function (){
            var course_id = $("#AddBycourseID").find("option:selected").val();
            load_sections(course_id);
            $('.saveAddDropCourseRequest').prop("disabled", true);
        });
        
    $('.saveAddDropCourseRequest').prop("disabled", true);


$(document).ready(function (){
    $('#AddBycourseID').html('');
       $.ajax({
            type:"POST",
            url:"controller_2.php",
            dataType:"json",
            data:{request_type:"load_UnEnrolled_courses"},
            success: function(data){
                 var res = '';
              res += `<option value="" selected="selected">Search Course</option>`;
              $.each(data, function(key, value){
                 res += `<option value="${value.id}">${value.courseName}</option>`;
              });
               $('#AddBycourseID').append(res);
            }
   });
 });
 
 </script>

 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <script>
  $(window).on('load', function(){
   $('.preloader').delay(800).fadeOut('slow');
 
});
  </script>
  <script src="http://code.jquery.com/jquery-2.2.1.min.js"></script>
