/* global swal */
 function display(){
     fetch_GAschedule();
     load_UnAddedCourses_ToCart_FromProjection();
     load_AddedCourseToCartToFilter();
}

 function fetch_GAschedule(){
   $.ajax({
     url:"../server/controller_2.php",
     method:"POST",
     dataType: "html",
     data:{request_type:"get_default_Schedule"},
     success:function(data){
       $("#display_schedule").html(data);
       getTrackerResult('optschedule');
        
     }
    });
   
     
 }
 
 function load_UnAddedCourses_ToCart_FromProjection(){
        $('#courseID').html('');
          $.ajax({
                type:"POST",
                url:"controller_2.php",
                dataType:"json",
                data:{request_type:"load_courses_data_fromProjection"},
                success: function(data){
                     var res = '';
                  res += `<option value="" selected="selected">Search Course</option>`;
                $.each(data, function(key, value){
                   res += `<option value="${value.id}">${value.courseName}</option>`;
                });
                 $('#courseID').append(res);
            }
   });
 }
  function generate_Schedule(){
     var selected = [];
    $('select[name="course_Instructor[]"] option:selected').each(function() {
                selected.push($(this).val());            
    });
    var days = 0;
    $('input:checkbox[name=day]:checked').each(function() 
    {
       days += parseInt($(this).val()) ;
    });
    if(selected.length ===0)
        selected='';
    if(days ===0)
        days =31;
    
    var StartTime = ($('input[name=startTime]').val()==="")?"8:00":$('input[name=startTime]').val();
    var EndTime = ($('input[name=endTime]').val()==="")?"18:00":$('input[name=endTime]').val();
    $('.preloader').delay(800).fadeOut('slow');
    $.ajax({
     url:"../server/controller_2.php",
     method:"POST",
     dataType: "html",
     data:{request_type:"bulid_Schedule_based_On_Input",instructor_ids:selected,days:days,
                        startTime:StartTime, endTime:EndTime},
     success:function(data){
               $("#display_schedule").html(data);
                getTrackerResult('optschedule');
     }
    });

 }
    

function add_Course_ToCart_BySearch(){
    var course_id = $("#courseID").find("option:selected").val();
    $.ajax({
          type: "POST",
          url: "../server/controller.php", // there is another request from script.js thus request type is to controller.php
          dataType: "html",
          data: {request_type:"store_Selected_Course_ID",courses_ID: course_id},
           success: function(data){
               if(data === 'success'){
                var x = document.getElementById("AddedSuccessNotification");
                    x.className = "show";
                    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
                    fetch_GAschedule();
                    load_UnAddedCourses_ToCart_FromProjection();
                    load_AddedCourseToCartToFilter();
                    $('#courseID option').prop('selected');
                   
             }else{
                 var x = document.getElementById("errorNotification");
                    x.className = "show";
                    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
                    $('#courseID option').prop('selected');
                 
             }
        
        }
      });
    
}

function delete_section(submit){
     swal({
                title: "Are you sure?",
                text: "You want to delet this section from cart",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
           .then(function (isOkay) {
            if (isOkay) {
               var course_id =  $(submit).attr("data-course-id");
  
                $.ajax({
                       type: "POST",
                       url: "../server/controller_2.php",
                       dataType: "html",
                       data: {request_type:"delete_section_By_courseID",course_id: course_id},
                        success: function(data){

                          $("#display_schedule").html(data);

                             var x = document.getElementById("deletesuccessNotification");
                             x.className = "show";
                             setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
                              $("#display_schedule").html(data);           
                              load_UnAddedCourses_ToCart_FromProjection();
                              load_AddedCourseToCartToFilter();
//                              fetch_GAschedule();
                   }
                   }); 
            }
           });
  
  
}

function load_AddedCourseToCartToFilter() {
   $('#courseID_inCart').multiselect({nonSelectedText:'Select Course(s)', buttonWidth:'100%'});
 $.ajax({
     url:"../server/controller_2.php",
     method:"POST",
     dataType: "json",
     data:{request_type:"load_courses_data_from_cart"},
     success:function(data)
     {
         var result = '';
         $.each(data, function(key, value){
            result += `<option value="${value.id}">${value.id}</option>`;
         });
          $('#courseID_inCart').html(result);
           $('#courseID_inCart').multiselect('rebuild');
//         
     }
 });
 
}

$(function (){
    $('#Instructors').multiselect({
  nonSelectedText: 'Select Instructor(s)',
  buttonWidth:'100%'
 });
 $('#courseID_inCart').change(function(option, checked){
   $('#Instructors').html('');
   $('#Instructors').multiselect('rebuild');
   var selected = $(this).val();
   if(selected.length > 0)
   {
    $.ajax({
     url:"../server/controller_2.php",
     method:"POST",
     dataType: "json",
     data:{request_type:"load_instructors", courses_ids:selected},
     success:function(data)
     {
      var result = '';
         $.each(data, function(key, value){
            result += `<option value="${value.InstructorID}">${value.Instructor}</option>`
         });
      $('#Instructors').html(result);
      $('#Instructors').multiselect('rebuild');
     }
    });
   }
  });
  
 });
 

 function enroll(ids){
     swal({
                title: "Are you sure?",
                text: "You want to registere these section. Please make sure that this is irreversible",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
           .then(function (isOkay) {
            if (isOkay) {
                var submit_ids= $(ids).attr("data-CRN-ids");
                $.ajax({
                   method: "POST",
                   url: "../server/controller_2.php",
                   dataType: "html",
                   data: {request_type:"enroll_course_By_CRN", CRN_IDs: submit_ids},
                   success: function(data){
                       if(data === 'success'){
                           var x = document.getElementById("successNotification");
                             x.className = "show";
                             setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
                            $('#viewEnrolledCourse').show();
                            $('.optschedule').prop('disabled', true);
                       }
                           
//                       window.location.href ="EnrolledCourses.php";

                   }

               });
            }
        });
}

