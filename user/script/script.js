  /* global swal */

function  currentDateTime(){
     var dNow = new Date();
    var localdate=  (dNow.getMonth()+1) + '-' + dNow.getDate()  + '-' + dNow.getFullYear()
            + ' ' + dNow.getHours() + ':' + dNow.getMinutes();
    return localdate;
}
function  submitPin(){
    submitPinForm('registrationNotOpenMessage', 'coursesTable');
//    $('.pinformdiv').css('margin-top', '-6%');
    
}
function submitAddDropPin(){
    submitPinForm('AddDropNotOpenMessage' , 'AddDropPage');
//    $('.pinformdiv').css('margin-top', '-7%');
}
function submitPinForm($message, $pageType){
  var startTime = new Date('11-21-2022 06:00').getTime();
   var endTime =  new Date('11-30-2022 23:59').getTime();
   var current = new Date(currentDateTime()).getTime();
   if(( current > startTime) && (current < endTime)){
        var pin = $("#pin").val();
        if(pin !==''){
            $.ajax({
               method: "POST",
               url: "../server/controller.php",
               dataType: "html",
               data: {request_type: "submit_pin", Pin: pin, type:$pageType},
               success: function (data){
                   if(data === 'success'){
                       var page ='';
                       if ($pageType ==='coursesTable')
                            
                                page=`RegisterClass.php`;
                        else
                            page=`AddDropRequest.php`;
                        window.location.href =page;
//                       $("#pin-form").hide();
//                       $(`#${$pageType}`).show();
                   }else{

                       $("#InvalidPinMessage").show();
                   }

               }
           });
        }
        else{
            $("#InputRequiredMessage").show();
            }
    }
    else{
         $(`#${$message}`).show();
    }
//    $('.pinformdiv').css('margin-top', '-8%');
}

function display_sections(){
    Browse_sections();
  function Browse_sections(course_id='', courseName ='', subject='', instructor ='', major_id=''){
    $.ajax({
        method: "POST",
        url: "../server/controller.php",
        dataType: "json",
        dataSrc:'',
        data: {request_type: "fetch_avaliable_sections",course_Name:courseName, course_ID: course_id,
                subject: subject, instructor_name: instructor, major:major_id},
        success: function(data) {
            var section ='';
            if(data.length === 0) 
                section =`<tr><td colspan="10" style="text-align:center">Search Not Avaliable! Please search again</td></tr>`;
            else
                   section =  sectionFromat(data, 'Browse');
            $("#BrowseSections").html(section);
            $("#numofRecordsShown").html(`<b>${data.length}</b>`);
            if (data.length > 0)
                $("#oneEntry").html(`<b>1</b>`);
           $("#numberofDisplaying").html(`<b>${data.length}</b>`);
            $("#TotalnumberofEntries").html(`<b>${data.length}</b>`);
         }
    });
    }
        $('.filter_by').keyup(function(){
            
         var courseid =  $('#search_course').val();
          var courseName = $("#courseName").val();
         var subject =  $('#subject').val();
         var instructor =  $('#instructor').val();
         var major =  $('#major').val();
          
         
         if(courseid !== '' || subject !=='' || courseName !=='' || instructor !=='' || major !== '' )
         {
          Browse_sections(courseid, courseName,subject, instructor, major);
         }
         else 
         {
          Browse_sections();
         }
        });
        
   }


//$(document).ready(function (){
function fetch_projection(){   
    $.ajax({
        method: "POST",
        url: "../server/controller.php",
        
        dataType: "json",
        data: {request_type: "fetch_avaliable_courses"},
        success: function (data) {
            display_coursesProjection(data);
           $("#numofRecordsShown").html(`<b>${data.length}</b>`);
            if (data.length > 0)
                $("#oneEntry").html(`<b>1</b>`);
           $("#numberofDisplaying").html(`<b>${data.length}</b>`);
            $("#TotalnumberofEntries").html(`<b>${data.length}</b>`);

        }
    });    
}


function fetch_enrolledCourses_InHistory(){
     $.ajax({
        method: "POST",
        url: "../server/controller.php",
        
        dataType: "json",
        data: {request_type: "fetch_enrolled_courses"},
        success: function (data) {
            var section =sectionFromat(data, 'Enrolled');
            $("#enrolled_Courses").append(section);
            $("#numofRecordsShown").html(`<b>${data.length}</b>`);
            if (data.length > 0)
                $("#oneEntry").html(`<b>1</b>`);
           $("#numberofDisplaying").html(`<b>${data.length}</b>`);
            $("#TotalnumberofEntries").html(`<b>${data.length}</b>`);
            
            //display_enrolled_Courses(data);
        }
    });   
}



function add_Course_ToCart(submit){
    var submit_id = $(submit).attr("data-course-id");
      $.ajax({
          type: "POST",
          url: "../server/controller.php",
          dataType: "html",
          data: {request_type:"store_Selected_Course_ID",courses_ID: submit_id},
           success: function(data){
            if(data === 'success'){
                var x = document.getElementById("successNotification");
                    x.className = "show";
                    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
                   fetch_projection();
                   
             }else{
                 var x = document.getElementById("errorNotification");
                    x.className = "show";
                    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
                 
             }
      }
      });
}

function fetch_Schedule(){
    $.ajax({
        method: "POST",
        url: "../server/controller.php",
        dataType: "json",
        data: {request_type:"fetch_schedule"},
        success: function(data){
            display_schedule_result(data);
        }
        
    });
    
   
}


function drop_EnrolledCourse(submit){
        swal({
                title: "Are you sure?",
                text: "you want to drop this course",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
           .then(function (isOkay) {
            if (isOkay) {
                var crn = $(submit).attr("data-section-id");
                $.ajax({
                    type: "POST",
                    url: "../server/controller.php",
                    dataType: "html",
                    data: {request_type:"drop_section",CRN: crn},
                     success: function(data){
                      if(data === 'success'){

                      }
                        fetch_enrolledCourses();
                          var x = document.getElementById("deletesuccessNotification");
                          x.className = "show";
                          setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);        
                }
                });
            }
        });
        return false;
   
}

function delete_section(submit){
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

      }
      });
  
}
function redirectTOScheduler(){

    window.location.href ="Scheduler.php";
   
}

function  updateButtonStatus(){
    if ($('.enrollCourse').filter(':checked').length >= 1){
        $('.saveAddDropCourseRequest').attr('disabled',false);
        var courseid = $('.enrollCourse').filter(':checked').attr("data-course-id");
        var selected = [];
        $(`[data-course-id=${courseid}]`).each(function (){
            selected.push($(this).val());
//            $('input:checkbox[name=AddCourse]:unchecked')?$('input:checkbox[name=AddCourse]:unchecked').css(disabled=true):"";
        });
     }else
          $('.saveAddDropCourseRequest').attr('disabled',true);
}

function register_Courses(){

        swal({
                title: "Are you sure?",
                text: "You want to registere the checked section(s). Please make sure that this is irreversible",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
           .then(function (isOkay) {
            if (isOkay) {
                var type ='AddDropWeek';
                var selected = [];
                $('input:checkbox[name=sections]:checked').each(function() 
                {
                    selected.push($(this).val());;
                });
                $.ajax({
                   method: "POST",
                   url: "../server/controller_2.php",
                   dataType: "json",
                   data: {request_type:"enroll_course_By_CRN", CRN_IDs: selected, type:type},
                   success: function(data){
                       if(data === 'success'){
                            var x = document.getElementById("successNotification");
                                x.className = "show";
                                setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
                   
                        }else{
                            var x = document.getElementById("errorNotification");
                               x.className = "show";
                               setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);

                        }

                   }

               });
            }
        });
}


   function  SaveAddDropCourses(submit){
        var selected = [];
        var subType = $(submit).val();
//        $("#AddDrop_Courses_cart").html('');
        $('input:checkbox[name=sections]:checked').each(function() 
        {
            selected.push($(this).val());;
        });
        $(".AddDropRequestErrorNotification").html('');
        $(".addDropCourse").prop('checked', false);
        $.ajax({
           method: "POST",
           url: "../server/controller_2.php",
           dataType: "html",
           data: {request_type:"addDropCart", CRN_IDs: selected, ReqType:subType},
           success: function(data){
              if(data === 'success') {
                    fetch_addDropIncart();
                     load_sections();
                }
               else{
                   var error = `You cannot request for this course! <br> Its already in your request cart`;
                   $(`#${subType}RequestErrorNotification`).html(error).delay(5000).fadeOut();
               }
               $('.saveAddDropCourseRequest').prop("disabled", true);
            }
            
       });
    }
 function remove_addDropCourseRequest(crn){
     var theRowId = $(crn).attr("data-section-id");
     $.ajax({
           method: "POST",
           url: "../server/controller_2.php",
           dataType: "html",
           data: {request_type:"remove_addDropCourseFromCart", CRN:theRowId},
           success: function(data){
              if(data === 'success') {
                    fetch_addDropIncart();
                    load_sections();
                }
            }
        });
    
     
 }
 function submitAddDropRequest(){
      swal({
                title: "Are you sure?",
                text: "you want to submit this Add/Drop course(s) request? Be sure to include all.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
           .then(function (isOkay) {
            if (isOkay) {
                $.ajax({
                      method: "POST",
                      url: "../server/controller_2.php",
                      dataType: "html",
                      data: {request_type:"submit_AddDropRequest"},
                      success: function(data){
                         if(data === 'success'){
                             var x = document.getElementById("successNotification");
                               x.className = "show";
                               setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
                               fetch_addDropIncart();
                           }
                       }
                   });
            }
        });
 }
  function getTrackerResult($type=''){
      $.ajax({
           method: "POST",
           url: "../server/controller_2.php",
           dataType: "json",
           data: {request_type:"track_student"},
           success: function(data){
               var status = '';
               if($type ==='submitAddDropRequest'){
                     status = (data.isPerformedAddDrop==='disabled')?true:false;
                     $(`#${$type}`).attr('disabled', status);
                 }
                else if($type === 'optschedule'){
                     status = (data.isRegistered==='disabled')?true:false;
                     if (status === true)
                         $('#viewEnrolledCourse').show();
                     $(`.${$type}`).attr('disabled', status);
                 }
              
           }
        });
     }
function sectionFromat(data, requestType='', requestSubtype=''){  //request sub type is only used for add/drop request to save in cart
    var section = '';
    var type =requestType;
        $.each(data, function(key, value){
           
             section +=   `<tr><td>${value.courseName}</td><td>${value.id}</td>`;
            if (type ==='Enrolled'  || type ==='Browse' || type === 'saveAddDropRequestTocart' || type === 'RetriveAddDropRequested')       
                 section +=   `<td>${value.subject}</td><td>${value.Major}</td>`;
             section += `<td>${value.CreditHour}</td><td>${value.CRN}</td><td>${value.section_No}</td><td>${value.Instructor}</td><td><ul>`;
                var days = {1:'M', 2:'T', 4:'W', 8:'T', 16:'F'};
                  for(var key in days){
                   var val = days[key];
                   if((value.MeetingDay & key) > 0){
                          section += `<li class="active">${val}</li>`;
                       }else{
                         section += `<li>${val}</li>`;
                       }

                    }
                section +=`<span style="margin-left:2.2%">${value.StartTime}</span> - 
                        <span style="margin-left:1%">${value.EndTime}</span></ul></td>`;
                var seatStatus = 'Available';
                  if(value.SeatLeft === 0)
                        seatStatus = 'NotAvailable';
                  if (type ==='Enrolled' || type === 'enrolledCoursesTODrop'){
                      if (value.enrolledDateTime !=='')
                          section +=  `<td>${value.enrolledDateTime}</td>`;
                      section +=  `<td class="rstatus">Enrolled</td>`;
                  }
                   if (type ==='Browse' || type ==='addToEnroll' ||  type === 'RetriveAddDropRequested')
                      section +=  `<td class="${seatStatus}">${value.SeatLeft} seats of <span>${value.RoomCapacity}</span></td>`;
                   if(type === 'enrolledCoursesTODrop'){
                        section += `<td> <input name="sections" type="checkbox" onclick="updateButtonStatus();" class="enrollCourse addDropCourse" value="${value.CRN}" 
                                        name="sections" data-course-id="${value.id}"> </td>`;
                       
                         //section += `<td><button  type="submit" class="btn btn-primary" data-section-id="${value.CRN}"  id ="deletecourseFromschedule"  
                             //   onclick="drop_EnrolledCourse(this);" style="background-color: red; z-index: 99999;"> Drop </button></td>`;
                         }
                    if(type === 'addToEnroll'){
                            var status = (seatStatus === "NotAvailable")?"disabled":"";
                        section += `<td class="${value.conflict}"> <input ${status}  name="sections" type="checkbox" onclick="updateButtonStatus();" 
                                         class="enrollCourse ${value.conflict} addDropCourse " value="${value.CRN}" name="sections" data-course-id="${value.id}"  
                                     ${value.conflict}></td>`;
                        }      
                    if(type === 'saveAddDropRequestTocart' ){
                             section += `<td>${value.RequestType}</td><td> <button  type="submit" class="btn btn-primary" data-section-id="${value.CRN}"  id ="deletecourseFromschedule"  
                                onclick="remove_addDropCourseRequest(this);" style="background-color: red; z-index: 99999;"> Delete </button></td>`;
                        }
                      if(type === 'RetriveAddDropRequested'){
                          section +=  `<td>${value.RequestType}</td><td>${value.AddDropRequestedTime}</td><td>${value.AddDropReqStatus}</td>`;
                      }
                         
                    section += `</tr>`;
                     
            });
            return section;
}


function showTable(){
            $("#coursesTable").show();
             $("#pin-form").hide();
    }
        

function display_coursesProjection(data){
  
     var html=create_html("courseProjection",data);
    $("#coursesFromProjection").html(html);
   
}
function display_courses(data){
  
     var html=create_html("avaliable-courses",data);
    $("#BrowseCourses").html(html);
}
function display_schedule_result(data){
  
     var html=create_html("posible-schedule",data);
    $("#course_schedule").html(html);
    
}
function display_enrolled_Courses(data){
  
     var html=create_html("enrolled-courses",data);
     $("#enrolled_Courses").html(html);
    
}


