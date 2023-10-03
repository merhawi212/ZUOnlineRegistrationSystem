 function display(){
    fetch_GeneratedSchedule();
}
$(function (){
    $("#saveClassSchedule").prop('disabled', true);
});
 function GenerateClassSchedule(){
       $("#display_classSchedule").html(`<tr><td colspan="11" style="text-align:center;">Processing...Please wait!</tr>`);
   $.ajax({
     url:"../server/controller_3.php",
     method:"POST",
     dataType: "html",
     data:{request_type:"generate_class_schedule"},
     success:function(data){
         $("#saveClassSchedule").prop('disabled', false);
          if(data === '\n\n\n') {
            var  section =`<tr><td colspan="11" style="text-align:center; color:red">Oops took more time or there might be conflict(s)! Please try again</tr>`;
              $("#display_classSchedule").html(section);
              $("#saveClassSchedule").prop('disabled', true);
            }
            else{
                var classes = jQuery.parseJSON( data );
                $("#display_classSchedule").html(classes[0]);
                var numberofClasses =classes[1];
                 if(numberofClasses > 0)
                    $("#oneEntryForDisplay_NewGenerated_Classes").html(`<b>1</b>`);
 
                $("#numofRecordsShownForDisplay_NewGenerated_Classes").html(`<b>${numberofClasses}</b>`);
                $("#numberofDisplayingForDisplay_NewGenerated_Classes").html(`<b>${numberofClasses}</b>`);
                 $("#TotalnumberofEntriesForDisplay_NewGenerated_Classes").html(`<b>${numberofClasses}</b>`);

                //$("#saveClassSchedule").prop('disabled', false);
            }
     }
    });
   
     
 }

  function fetch_GeneratedSchedule(){
   Browse_sections();
  function Browse_sections(course_id='', courseName ='', subject='', instructor ='', major_id=''){
    $.ajax({
        method: "POST",
        url: "../server/controller_3.php",
        dataType: "json",
        dataSrc:'',
        data: {request_type: "fetch_generated_class_schedule",course_Name:courseName, course_ID: course_id,
                subject: subject, instructor_name: instructor, major:major_id},
        success: function(data) {
            var section ='';
            if(data.length === 0) 
                section =`<tr><td colspan="10" style="text-align:center">No record available</td></tr>`;
            else
                   section =  sectionFromat(data, 'Browse');
             $("#display_created_Classes").html(section);
             if(data.length > 0)
                $("#oneEntryForDisplay_Created_Classes").html(`<b>1</b>`);
 
            $("#numofRecordsShownForDisplay_Created_Classes").html(`<b>${data.length}</b>`);
            $("#numberofDisplayingForDisplay_Created_Classes").html(`<b>${data.length}</b>`);
             $("#TotalnumberofEntriesForDisplay_Created_Classes").html(`<b>${data.length}</b>`);

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
  
  function saveClassSchedule(){
//      tableRow
      var data = [];
      data = $("input[name='tableRow[]']").map(function (){
           return $(this).val();
          
      }).get();
       $.ajax({
     url:"../server/controller_3.php",
     method:"POST",
     dataType: "html",
     data:{request_type:"save_genereted_classSchedule", data:data },
     success:function(data){
       $("#display_classSchedule").html(data);
       $("#saveClassSchedule").prop('disabled', false);
     }
    });
  }
   function add_NewClassToGeneratedClasses(){
        var id =  $("#courseid").val();
        var crn = $("#CRN").val();
        var secNo =  $("#section_no").val();
        var faculty_id =$("#fac_id").val();
        var MeetingDay = $("#meetingday").val();
        var time =  $("#meetingtime").val();
        var campus = $("#campus").val(); 
        var location = $("#meetinglocation").val();  
        if (id !=='' && crn !== '' && secNo !=='' && faculty_id !=='' && MeetingDay !=='' 
                && time !=='' & location !=='' && campus !== ''){
        $.ajax({
            method: "POST",
            url: "../server/controller_3.php",
            dataType: "html",
            dataSrc:'',
            data: {request_type: "add_sectionToGeneratedClasses",crn:crn, id:id, secNo:secNo,faculty_id:faculty_id, 
                        meetingDay:MeetingDay, time:time, location:location, campus:campus},
            success: function(data) {
                notification(data, 'add');
                $('#exampleModal_2').modal('hide');
              fetch_GeneratedSchedule();
//                $("#courseid").val('');
            }
        });
    }else{
                var error = `All fieds are required!`;
                   $(`#AddsectionErrorNotification`).html(error).delay(5000).fadeOut();
    }
   }
  function classScheduler_edit_section(section){
      var crn = $(section).attr("data-section-id");
      $.ajax({
        method: "POST",
        url: "../server/controller_3.php",
        dataType: "json",
        dataSrc:'',
        data: {request_type: "fetch_selected_section_ToEdit",crn:crn},
        success: function(data) {
                var section = data[0];
             $("#name").val(section.courseName);
             $("#id").val(section.id);
             $("#crn").val(section.CRN);
             $("#Major").val(section.Major);
             $("#SecNo").val(section.section_No);
             $("#Instructor").val(section.InstructorID);
             $("#day").val(section.MeetingDay);
             $("#time").val(section.StartTime + ' - ' + section.EndTime );
             $("#location").val(section.RoomLocation);
             
         }
    });
   
  
  }
  
   function  update_GeneratedClasses(){
    var id =  $("#id").val();
    var crn = $("#crn").val();
    var secNo =  $("#SecNo").val();
    var instructor =$("#Instructor").val();
    var MeetingDay = $("#day").val();
    var time =  $("#time").val();
    var loc = $("#location").val();
              
      $.ajax({
        method: "POST",
        url: "../server/controller_3.php",
        dataType: "html",
        data: {request_type: "update_GeneratedClasses", id:id, crn:crn, secNo:secNo,
                            instructor:instructor, meetingDay:MeetingDay, time:time, loc:loc},
        success: function(data) {
             notification(data, 'update');
            $('#exampleModal').modal('hide');
            fetch_GeneratedSchedule();
            
         }
    });
   
  }
  
  
   function  deleteClassFromCreatedClasses(submit){
       swal({
                title: "Are you sure?",
                text: "You want to delete this section. Please make sure that this is irreversible",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
           .then(function (isOkay) {
                if (isOkay) {
                    var crn = $(submit).attr("data-section-id");
                    $.ajax({
                     method: "POST",
                     url: "../server/controller_3.php",
                     dataType: "html",
                     data: {request_type: "delte_sectionFromCreatedClasses",  crn:crn},
                     success: function(data) {
                         notification(data, 'delete');
                         $('#exampleModal').modal('hide');
                         fetch_GeneratedSchedule();

                      }
                 });
            }
        });
  }


function display_inputData(){
    
    get_courses();
    get_instructors();
    get_Rooms();
    get_meetingTimes();
    $('.filter_by').keyup(function(){
        var courseid =  $('#search_course').val();
          var courseName = $("#courseName").val();
         var instructor =  $('#instructor').val();
         var major =  $('#major').val();
         if(courseid !== ''  || courseName !=='' || major !==''  )
         {
         get_courses(courseid, courseName, major);
         
         }
         else if (instructor  !== '') {
             get_instructors(instructor);
        }
         else 
         {
          get_courses();
          get_instructors();
         }
    });

    
}


function get_courses(courseid='', coursename='', major=''){
    $.ajax({
        method: "POST",
        url: "../server/controller_3.php",
        dataType: "json",
        data: {request_type: "fetch_courses", CourseID:courseid, CourseName:coursename, major:major},
        success: function(data) {
            var  section = '';
           if(data.length === 0) {
              section =`<tr><td colspan="11" style="text-align:center;> No records available</tr>`;
              
                        }
            else{
                section = courseFormat(data);
            }
            $("#display_courses").html(section);
             if(data.length > 0)
                $("#oneEntryForDisplay_Courses").html(`<b>1</b>`);
 
            $("#numofRecordsShownForDisplay_Courses").html(`<b>${data.length}</b>`);
            $("#numberofDisplayingForDisplay_Courses").html(`<b>${data.length}</b>`);
             $("#TotalnumberofEntriesForDisplay_Courses").html(`<b>${data.length}</b>`);
           

         }
     });
}


function edit_course(section){
      var id = $(section).attr("data-course-id");
      $.ajax({
        method: "POST",
        url: "../server/controller_3.php",
        dataType: "json",
        dataSrc:'',
        data: {request_type: "fetch_selected_course_ToEdit",id:id},
        success: function(data) {
                var course = data[0];
             $("#course_id").val(course.course_id);
             $("#Course_Name").val(course.courseName);
             $("#max_students").val(course.maxnumofStudents);
             $("#Major").val(course.Major);
             $("#credit_Hours").val(course.CreditHour);
             $("#DXB").val(course.numofclassesinDXB);
             $("#ADM").val(course.numofclassesinADM);
             $("#ADF").val(course.numofclassesinADF);
             
         }
    });
   
  
  }
  
 function  update_Course(){
    var id =  $("#course_id").val();
    var name = $("#Course_Name").val();
    var max_students =  $("#max_students").val();
    var Major =$("#Major").val();
    var credit_Hours = $("#credit_Hours").val();
    var DXB =  $("#DXB").val();
    var ADM =  $("#ADM").val();
    var ADF = $("#ADF").val();
              
      $.ajax({
        method: "POST",
        url: "../server/controller_3.php",
        dataType: "html",
        data: {request_type: "update_Courses", id:id, name:name, max_students:max_students,
                            major:Major, credit_Hours:credit_Hours, dxb:DXB, adm:ADM, adf:ADF},
        success: function(data) {
             notification(data, 'updatecourse');
            $('#exampleModal').modal('hide');
            get_courses();
            
         }
    });
   
  }
   function add_Course(){
        var id =  $("#courseid").val();
        var name =    $("#CourseName").val();
        var subject =    $("#subject").val();   
        var maxstudents =  $("#maxstudents").val();
        var major =     $("#major_id").val();
        var creditHours =  $("#creditHours").val();
        var DXB =    $("#dxb").val();
        var ADM  = $("#adm").val();
        var ADF =   $("#adf").val();
        
        if (id !=='' && name !== '' && subject !== '' && maxstudents !=='' && major !=='' && creditHours !=='' 
                && DXB !=='' & ADM !=='' && ADF !== ''){
        $.ajax({
            method: "POST",
            url: "../server/controller_3.php",
            dataType: "html",
            data: {request_type: "add_course", id:id, name:name, subject:subject, max_students:maxstudents,
                            major:major, credit_Hours:creditHours, dxb:DXB, adm:ADM, adf:ADF},
            success: function(data) {
                notification(data, 'addcourse');
                $('#exampleModal_2').modal('hide');
                get_courses();
            }
        });
    }else{
                var error = `All fieds are required!`;
                   $(`#AddcourseErrorNotification`).html(error).delay(5000).fadeOut();
    }
   }
   
   function  delete_course(submit){
       swal({
                title: "Are you sure?",
                text: "You want to delete this course. Please make sure that this is irreversible",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
           .then(function (isOkay) {
                if (isOkay) {
                    var id = $(submit).attr("data-coure-id");
                    $.ajax({
                     method: "POST",
                     url: "../server/controller_3.php",
                     dataType: "html",
                     data: {request_type: "delete_course",  id:id},
                     success: function(data) {
                         notification(data, 'deletecourse');       
                         get_courses();

                      }
                 });
            }
        });
        
  }
function get_instructors(instructorname=''){
     $.ajax({
        method: "POST",
        url: "../server/controller_3.php",
        dataType: "json",
        data: {request_type: "fetch_instructors", InstructorName:instructorname},
        success: function(data) {
            var  section = '';
           if(data.length === 0) {
              section =`<tr><td colspan="11" style="text-align:center;> No records available</tr>`;
              
                        }
            else{
                section = instructorFormat(data);
            }
            $("#display_instructors").html(section);
            if(data.length > 0)
                $("#oneEntryForDisplay_Instructors").html(`<b>1</b>`);
 
            $("#numofRecordsShownForDisplay_Instructors").html(`<b>${data.length}</b>`);
            $("#numberofDisplayingForDisplay_Instructors").html(`<b>${data.length}</b>`);
             $("#TotalnumberofEntriesForDisplay_Instructors").html(`<b>${data.length}</b>`);

         }
     });
}
function edit_instructor(submit){
    var id = $(submit).attr("data-instructor-id");
      $.ajax({
        method: "POST",
        url: "../server/controller_3.php",
        dataType: "json",
        data: {request_type: "fetch_selected_instructor_ToEdit",id:id},
        success: function(data) {
                var instructor = data[0];
                var courseids ='';
                  for (var x = 0; x < instructor.course_ID.length; x++) {
                      if(x < (instructor.course_ID.length -1))
                        courseids += instructor.course_ID[x] + ', ';
                    else
                        courseids += instructor.course_ID[x]; 
                 }
                 courseids.slice(0, -2);
             $("#faculty_id").val(instructor.faculty_ID);
              $("#fname").val(instructor.fname);
              $("#lname").val(instructor.lname);
             $("#course_ID").val(courseids);
             $("#college").val(instructor.college_id);
             $("#campus").val(instructor.branch);
            
             
         }
    });
}

function update_InstructorCourse(){
    var faculty_id = $("#faculty_id").val();
  
   var courseid =$("#course_ID").val();
  
     $.ajax({
        method: "POST",
        url: "../server/controller_3.php",
        dataType: "html",
        data: {request_type: "update_faculty_course",faculty_id:faculty_id, courseid:courseid},
        success: function(data) {
               $('#exampleModal_4').modal('hide');
                get_instructors();  
         }
    }); 
}

function add_QualifiedCourse(){
   var faculty_id = $("#fac_id").val();
   var courseid = $("#Course_ID").val();
  
   if (faculty_id !=='' && courseid !=='' ){
     $.ajax({
            method: "POST",
            url: "../server/controller_3.php",
            dataType: "html",
            data: {request_type: "add_course_instructor",faculty_id:faculty_id, courseid:courseid},
            success: function(data) {
                   $('#exampleModal_4').modal('hide');
                    get_instructors();   
             }
        });
    }else{
                var error = `All fieds are required!`;
                   $(`#AddInstructorcourseErrorNotification`).html(error).delay(5000).fadeOut();
    }
   }
function delete_instructor(submit){
    var faculty_id = $(submit).attr("data-instructor-id"); 
  
     $.ajax({
        method: "POST",
        url: "../server/controller_3.php",
        dataType: "html",
        data: {request_type: "delete_faculty_course",faculty_id:faculty_id},
        success: function(data) {
               $('#exampleModal_4').modal('hide');
                get_instructors();  
         }
    }); 
}
function get_Rooms(){
     $.ajax({
        method: "POST",
        url: "../server/controller_3.php",
        dataType: "json",
        data: {request_type: "fetch_rooms"},
        success: function(data) {
            var  room = '';
           if(data.length === 0) {
              room =`<tr><td colspan="6" style="text-align:center;> No records available</tr>`;
              
                        }
            else{
                room = roomFormat(data);
            }
            $("#display_rooms").html(room);
            if(data.length > 0)
                $("#oneEntryForDisplay_Rooms").html(`<b>1</b>`);
 
            $("#numofRecordsShownForDisplay_Rooms").html(`<b>${data.length}</b>`);
            $("#numberofDisplayingForDisplay_Rooms").html(`<b>${data.length}</b>`);
             $("#TotalnumberofEntriesForDisplay_Rooms").html(`<b>${data.length}</b>`);

         }
     });
}
function  edit_room(submit){
  var id = $(submit).attr("data-room-id");
      $.ajax({
        method: "POST",
        url: "../server/controller_3.php",
        dataType: "json",
        data: {request_type: "fetch_selected_room_ToEdit",id:id},
        success: function(data) {
                var room = data[0];
             $("#Room_ID").val(room.room_id);
              $("#Room_Location").val(room.location);
              $("#Room_Capacity").val(room.capacity);
             $("#Room_Campus").val(room.campus);                   
         }
    });  
}
function update_room(){
   var roomid = $("#Room_ID").val();
   var location = $("#Room_Location").val();
   var capacity = $("#Room_Capacity").val();
   var campus = $("#Room_Campus").val();
     $.ajax({
        method: "POST",
        url: "../server/controller_3.php",
        dataType: "html",
        data: {request_type: "update_room",roomid:roomid, location:location, capacity:capacity, campus:campus},
        success: function(data) {
               $('#exampleModal_roomEdit').modal('hide');
                get_Rooms();  
         }
    }); 
}
 function add_room(){
   var roomid = $("#room_id").val();
   var location = $("#room_location").val();
   var capacity = $("#room_capacity").val();
   var campus = $("#room_campus").val();
   if (roomid !=='' && location !=='' && capacity !== '' && campus !==''){
     $.ajax({
            method: "POST",
            url: "../server/controller_3.php",
            dataType: "html",
            data: {request_type: "add_room",roomid:roomid, location:location, capacity:capacity, campus:campus},
            success: function(data) {
                   $('#exampleModal_roomAdd').modal('hide');
                    get_Rooms();  
             }
        });
    }else{
                var error = `All fieds are required!`;
                   $(`#AddroomErrorNotification`).html(error).delay(5000).fadeOut();
    }
   }
function delete_room(submit){
    var id = $(submit).attr("data-room-id");
      $.ajax({
        method: "POST",
        url: "../server/controller_3.php",
        dataType: "html",
        data: {request_type: "delete_room",id:id},
        success: function(data) {
                get_Rooms();  
                      
         }
    });  
}


function get_meetingTimes(){
     $.ajax({
        method: "POST",
        url: "../server/controller_3.php",
        dataType: "json",
        data: {request_type: "fetch_meetingTimes"},
        success: function(data) {
            var  meetingTimes = '';
           if(data.length === 0) {
              meetingTimes =`<tr><td colspan="6" style="text-align:center;> No records available</tr>`;
              
                        }
            else{
                meetingTimes = meetingTimesFormat(data);
            }
            $("#display_meetingTimes").html(meetingTimes);
            if(data.length > 0)
                $("#oneEntryForDisplay_MeetingTimes").html(`<b>1</b>`);
 
            $("#numofRecordsShownForDisplay_MeetingTimes").html(`<b>${data.length}</b>`);
            $("#numberofDisplayingForDisplay_MeetingTimes").html(`<b>${data.length}</b>`);
             $("#TotalnumberofEntriesForDisplay_MeetingTimes").html(`<b>${data.length}</b>`);

         }
     });
}
function edit_meetingTimes(submit){
    var id = $(submit).attr("data-meetingTimes-id");
      $.ajax({
        method: "POST",
        url: "../server/controller_3.php",
        dataType: "json",
        data: {request_type: "fetch_selected_meetingTimes",id:id},
        success: function(data) {
                var meetingTime = data[0];
             $("#meetingTimes_ID").val(meetingTime.meetingTime_id);
              $("#Days").val(meetingTime.days);
              $("#StartTime").val(meetingTime.startTime);
             $("#EndTime").val(meetingTime.endTime);                   
         }
    });  
}
function update_meetingTimes(){
        var meetingTimesID = $("#meetingTimes_ID").val();
        var days =   $("#Days").val();
        var  startTime = $("#StartTime").val();
         var endTime = $("#EndTime").val();
         $.ajax({
            method: "POST",
            url: "../server/controller_3.php",
            dataType: "html",
            data: {request_type: "update_meetingTimes",meetingTimesID:meetingTimesID, days:days, startTime:startTime, endTime:endTime},
            success: function(data) {
                   $('#exampleModal_MeetingTimesEdit').modal('hide');
                  get_meetingTimes();
             }
        }); 
}
 function add_meetingTimes(){
   var meetingTimesID = $("#meetingTimes_id").val();
   var days = $("#days").val();
   var startTime = $("#startTime").val();
   var endTime = $("#endTime").val();
   if (meetingTimesID !=='' && days !=='' && startTime !== '' && endTime !==''){
     $.ajax({
            method: "POST",
            url: "../server/controller_3.php",
            dataType: "html",
            data: {request_type: "add_meetingTimes",meetingTimesID:meetingTimesID, days:days, startTime:startTime, endTime:endTime},
            success: function(data) {
                   $('#exampleModal_MeetingTimesAdd').modal('hide');
                    get_meetingTimes();  
             }
        });
    }else{
                var error = `All fieds are required!`;
                   $(`#AddMeetingTimesErrorNotification`).html(error).delay(5000).fadeOut();
    }
   }
   function delete_meetingTimes(submit){
    var id = $(submit).attr("data-meetingTimes-id");
      $.ajax({
        method: "POST",
        url: "../server/controller_3.php",
        dataType: "html",
        data: {request_type: "delete_meetingTimes",id:id},
        success: function(data) {
                get_meetingTimes(); 
                      
         }
    });  
}
function meetingTimesFormat(data){
     var meetingTimes = '';
    $.each(data, function (key, value){ 
        meetingTimes +=`<tr><td>${value.meetingTime_id}</td><td><ul>`;
       
                var days = {1:'M', 2:'T', 4:'W', 8:'T', 16:'F'};
                  for(var key in days){
                   var val = days[key];
                   if((value.days & key) > 0){
                          meetingTimes += `<li class="active">${val}</li>`;
                       }else{
                         meetingTimes += `<li>${val}</li>`;
                       }

                    }
                meetingTimes +=`</ul></td><td>${value.startTime}</td> - 
                        <td>${value.endTime}</td>
    <td><button  type="submit" class="btn btn-primary" data-meetingTimes-id="${value.meetingTime_id}"  id ="edit_meetingTimes"  
                          onclick="edit_meetingTimes(this);" style="background-color: green; z-index: 999;" 
                              data-toggle="modal" data-target="#exampleModal_MeetingTimesEdit"> Edit </button></td> 
             <td> <button  type="submit" class="btn btn-primary" data-meetingTimes-id="${value.meetingTime_id}"  id ="delete_meetingTimes"  
                          onclick="delete_meetingTimes(this);" style="background-color: red; z-index: 999;"> Delete </button></td><tr>`;
    });
    return meetingTimes;
}
function roomFormat(data){
    var room = '';
    $.each(data, function (key, value){ 
        
       room += `<tr><td>${value.room_id}</td><td>${value.location}</td><td>${value.capacity}</td><td>${value.campus}</td>     
            <td><button  type="submit" class="btn btn-primary" data-room-id="${value.room_id}"  id ="edit_room"  
                          onclick="edit_room(this);" style="background-color: green; z-index: 999;" 
                              data-toggle="modal" data-target="#exampleModal_roomEdit"> Edit </button></td> 
             <td> <button  type="submit" class="btn btn-primary" data-room-id="${value.room_id}"  id ="delete_room"  
                          onclick="delete_room(this);" style="background-color: red; z-index: 999;"> Delete </button></td>
            </tr>`;
    });
    return  room;
}

function instructorFormat(data){
    var instructor = '';
    $.each(data, function (key, value){ 
        
       instructor += `<tr><td>${value.faculty_ID}</td><td>${value.fname}</td><td>${value.lname}</td>
                   <td>`; 
        for (var x in value.course_ID) {
            if(x < (value.course_ID.length -1))
                 instructor += `${value.course_ID[x]}, `;
             else
                 instructor += `${value.course_ID[x]}`;
        }
        instructor += ` </td><td>${value.college_id}</td><td>${value.branch}</td>
                    
                  <td><button  type="submit" class="btn btn-primary" data-instructor-id="${value.faculty_ID}"  id ="edit_course"  
                                onclick="edit_instructor(this);" style="background-color: green; z-index: 999;" 
                                    data-toggle="modal" data-target="#exampleModal_4"> Edit </button></td> 
           <td> <button  type="submit" class="btn btn-primary" data-instructor-id="${value.faculty_ID}"  id ="delete_coure"  
                                onclick="delete_instructor(this);" style="background-color: red; z-index: 999;"> Delete </button></td>
            </tr>`;
    });
    return  instructor;
}

function courseFormat(data){
    var course = '';
    $.each(data, function (key, value){ 
        
       course += `<tr><td>${value.course_id}</td><td>${value.courseName}</td><td>${value.Major}</td>
                    <td>${value.CreditHour}</td><td>${value.maxnumofStudents}</td><td>${value.numofclassesinDXB}</td>
                    <td>${value.numofclassesinADF}</td><td>${value.numofclassesinADM}</td><td>${value.numberofClasses}</td>
                  <td><button  type="submit" class="btn btn-primary" data-course-id="${value.course_id}"  id ="edit_course"  
                                onclick="edit_course(this);" style="background-color: green; z-index: 999;" 
                                    data-toggle="modal" data-target="#exampleModal"> Edit </button></td> 
           <td> <button  type="submit" class="btn btn-primary" data-coure-id="${value.course_id}"  id ="delete_coure"  
                                onclick="delete_course(this);" style="background-color: red; z-index: 999;"> Delete </button></td>
            </tr>`;
    });
    return  course;
}