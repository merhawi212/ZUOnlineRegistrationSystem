
    function display_students(id='', CGPA='', major='', college='', campus='', addDropOnholdStatus=''){
     $.ajax({
        method: "POST",
        url: "../server/controller_2.php",
        dataType: "json",
        data: {request_type: "fetch_students",student_id:id, CGPA:CGPA, major:major, 
                    college:college, campus:campus , AddDropOnholdStatus:addDropOnholdStatus},
        success: function(data) {
            var students ='';
            if (data.length ===0){
                students = `<tr><td colspan="13" style="text-align:center">No records found</td>`;
                 $("#oneEntryForDisplay_Students").html(`<b>0</b>`);
                
            }
            else{
             students = studentFormat(data);
              $("#oneEntryForDisplay_Students").html(`<b>1</b>`);
            }
            $('#display_students').html(students);
            $("#numofRecordsShownForDisplay_Students").html(`<b>${data.length}</b>`);
            $("#numberofDisplayingForDisplay_Students").html(`<b>${data.length}</b>`);
             $("#TotalnumberofEntriesForDisplay_Students").html(`<b>${data.length}</b>`);
            notification('enroll', 'Enroll');

            
            
         }
    });
}

function search_by(){
        var student_id =  $('#std_id').val();
        var CGPA = $("#CGPAGreaterThan").val();
         var major =  $('#major').val();
         var college =  $('#college').val();
         var campus =  $('#campus').val();
         var AddDropOnholdStatus =  ($('#addDropOnholdStatus').val() ==='All')?'':$('#addDropOnholdStatus').val();
        
          display_students(student_id, CGPA, major, college, campus , AddDropOnholdStatus);
        
   }
function get_studentInfo(submit){
    var studentid = $(submit).attr("data-student-id");
    $('#studentName').html(studentid);
   getCourseProjection(studentid);
    AddDropRequest(studentid);
    fetch_enrolledCourses_InHistory(studentid);
    
}
function   getCourseProjection(studentid){
     $.ajax({
        method: "POST",
        url: "../server/controller.php",
        dataType: "json",
        data: {request_type: "fetch_CourseProjection", id:studentid},
        success: function(data) {
             var course = '';
            if (data.length ===0){
                 course +=   `<tr><td colspan="6" style="text-align:center">No records found</td>`;
            }
           else {
            $.each(data, function(key, value){
             course +=   `<tr><tr><td>${value.courseName}</td><td>${value.id}</td>`;
            course +=   `<td>${value.subject}</td><td>${value.Major}</td>`;
            var isEnrolled = (value.status ==='Enrolled')?'disabled':'';
             course += `<td>${value.CreditHour}</td><td>${value.status}</td> <td><button  type="submit" class="btn btn-primary" data-courseID="${value.id}"  id ="course"  
                        onclick="get_courseClasses(this)" style="background-color: #138D75; z-index: 999;font-size:14px; cursor: pointer;" 
                   ${isEnrolled} > <i class="fa fa-eye"; style="font-size:10px; padding: 0; margin:0"></i>
                         <span style="" >view <span></button></td></tr>`;
            });
         }
         $('#coursesFromProjection-adminside').html(course);
          if(data.length > 0)
                $("#oneEntryForDisplay_coursesFromProjection").html(`<b>1</b>`);
 
         $("#numofRecordsShownForDisplay_coursesFromProjection").html(`<b>${data.length}</b>`);
         $("#numberofDisplayingForDisplay_coursesFromProjection").html(`<b>${data.length}</b>`);
        $("#TotalnumberofEntriesForDisplay_coursesFromProjection").html(`<b>${data.length}</b>`);
     }
    });
}
function get_courseClasses(submit){
    var courseid = $(submit).attr('data-courseID');
    $('#nav-fourth-tab').css( 'visibility', 'visible');
    $('#nav-fourth').css( 'visibility', 'visible');
    $.ajax({
           method: "POST",
           url: "../server/controller_2.php",
           dataType: "json",
           data: {request_type: "find_courseClasses", courseid:courseid},
           success: function (data) {
                var section ='';
            if (data.length ===0){
              section =   `<tr><td colspan="13" style="text-align:center">No data found</td>`;
              $("#oneEntryForDisplay_Courseclasses").html(`<b>0</b>`);
             
            }
            else {
                section =sectionFromat(data, 'EnrollStudent');
                }
             $("#CourseClasses").html(section);
              if(data.length > 0)
                 $("#oneEntryForDisplay_Courseclasses").html(`<b>1</b>`);
 
            $("#numofRecordsShownForDisplay_Courseclasses").html(`<b>${data.length}</b>`);
            $("#numberofDisplayingForDisplay_Courseclasses").html(`<b>${data.length}</b>`);
           $("#TotalnumberofEntriesForDisplay_Courseclasses").html(`<b>${data.length}</b>`);
               
           }
       });  
}

function enrollToClass(submit){
    $(`.successNotification`).html('');
    $(`.errorNotification`).html('');
    var crn = $(submit).attr('data-section-id');
    $.ajax({
           method: "POST",
           url: "../server/controller_2.php",
           dataType: "html",
           data: {request_type: "enroll_student", crn:crn},
           success: function (data) {
            
//            if(data ==='success'){
////                 var studentid = $('#studentName').text();
////                get_studentInfo(studentid);
//                $(`.successNotification`).html('student enrolled to class successfully').delay(5000).fadeOut('slow');
//               
//            }
//            else{
//                $(`.errorNotification`).html('Exceeds Max CourseLoad').delay(5000).fadeOut('slow');
//            }
          $('#exampleModal_2').modal('hide');
            display_students();
               notification(data, 'Enroll');
       }
       });  
}
function drop_EnrolledCourse(submit){
    $(`.successNotification`).html('');
    $(`.errorNotification`).html('');
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
                    url: "../server/controller_2.php",
                    dataType: "html",
                    data: {request_type:"drop_course",CRN: crn},
                     success: function(data){
//                      if(data === 'success'){
////                          var studentid = $('#studentName').text();
////                          get_studentInfo(studentid);
//                          $(`.successNotification`).html('course droped successfully').delay(5000).fadeOut('slow');
//
//                      }
//                      else{
//                       $(`.errorNotification`).html('unable to drop').delay(5000).fadeOut('slow');
//
//                      }
                         
                            display_students();
                    $('#exampleModal_2').modal('hide');
                       notification(data, 'Enroll');

                              
                }
                });
            }
        });
        return false;
   
}
function  AddDropRequest(studentid){
  $.ajax({
     method: "POST",
     url: "../server/controller_2.php",
     dataType: "json",
     data: {request_type: "fetch_AddDropRequested_courses", id:studentid},
     success: function(data) {
          var course ='';
         if (data.length ===0){
              course +=   `<tr><td colspan="13" style="text-align:center">No records available</td>`;
              $('#AddDrop_Courses').html(course);
         }else {
          course = sectionFromat(data, 'RetriveAddDropRequested' );
         $('#AddDrop_Courses').html(course);
         var i = 1;
         $.each(data, function(key, value){
             $(`#selectApprovalActions_${i} option[value='${value.AddDropReqStatus}']`).attr('selected', 'selected');
             i++;
         });
         if(data.length > 0)
                $("#oneEntryForDisplay_AddDrop_Courses").html(`<b>1</b>`);
 
            $("#numofRecordsShownForDisplay_AddDrop_Courses").html(`<b>${data.length}</b>`);
            $("#numberofDisplayingForDisplay_AddDrop_Courses").html(`<b>${data.length}</b>`);
           $("#TotalnumberofEntriesForDisplay_AddDrop_Courses").html(`<b>${data.length}</b>`);
     }


      }
 });
}
function fetch_enrolledCourses_InHistory(studentid){
        $.ajax({
           method: "POST",
           url: "../server/controller.php",
           dataType: "json",
           data: {request_type: "fetch_enrolled_courses", id:studentid},
           success: function (data) {
                var section ='';
            if (data.length ===0){
              section +=   `<tr><td colspan="13" style="text-align:center">No records available</td>`;
              $("#oneEntryForDisplay_enrolled_Courses").html(`<b>0</b>`);
             
            }
            else {
                section +=sectionFromat(data, 'Enrolled');
                }
             $("#enrolled_Courses").html(section);
              if(data.length > 0)
                 $("#oneEntryForDisplay_enrolled_Courses").html(`<b>1</b>`);
 
            $("#numofRecordsShownForDisplay_enrolled_Courses").html(`<b>${data.length}</b>`);
            $("#numberofDisplayingForDisplay_enrolled_Courses").html(`<b>${data.length}</b>`);
           $("#TotalnumberofEntriesForDisplay_enrolled_Courses").html(`<b>${data.length}</b>`);
               
           }
       });  
    
 }
 
 function save_AddDropAction(){
     
 }
 
 function updateStatusAction(submit){
      var crn = $(submit).find(':selected').attr('data-crn'); 
      var x = $(submit).find(':selected').attr('data-request-type'); 
      var status = $(submit).find(':selected').val();
      $.ajax({
           method: "POST",
           url: "../server/controller_2.php",
           dataType: "html",
           data: {request_type: "update_AddDropApproval", crn:crn, status:status, requestType:x},
           success: function (data) {
                notification(data, 'AddDropApprovalRequest');
           }
       });  
   
 }
 
// function drop_EnrolledCourse(submit){
//        swal({
//                title: "Are you sure?",
//                text: "you want to drop this course",
//                icon: "warning",
//                buttons: true,
//                dangerMode: true,
//            })
//           .then(function (isOkay) {
//            if (isOkay) {
//                var crn = $(submit).attr("data-section-id");
//                $.ajax({
//                    type: "POST",
//                    url: "../server/controller.php",
//                    dataType: "html",
//                    data: {request_type:"drop_section",CRN: crn},
//                     success: function(data){
//                      if(data === 'success'){
//
//                      }
//                        fetch_enrolledCourses();
//                          var x = document.getElementById("deletesuccessNotification");
//                          x.className = "show";
//                          setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);        
//                }
//                });
//            }
//        });
//        return false;
//   
//}
function studentFormat(data){
        var student = '';

        $.each(data, function(key, value){
            var isOnHold = 'ActionNotNeeded';
            if (value.IsunderEnroll ==='Yes' || value.IsAddDropRequested ==='Yes'){
                isOnHold = 'needsAction';
             }
             student +=   `<tr class ="${isOnHold}"><td><button  type="submit" class="btn btn-primary" data-student-id="${value.ID}"  id ="student"  
                               onclick="get_studentInfo(this)" style="background-color: #138D75; z-index: 999;font-size:14px; cursor: pointer;" 
                            data-toggle="modal" data-target="#exampleModal_2"> <i class="fa fa-eye"; style="font-size:10px; padding: 0; margin:0"></i>
                                <span style="">view <span></button></td><td><a href='#' data-student-id="${value.ID}" 
                                    onclick="get_studentInfo(this)" data-toggle="modal" data-target="#exampleModal_2" 
                                style=' cursor: pointer; z-index:9999'>${value.ID}</a></td><td>${value.fname}</td>
                        <td>${value.lname}</td><td>${value.gender}</td><td>${value.major}</td><td>${value.college}</td><td>${value.campus}</td>
                       <td>${value.CGPA}</td> <td>${value.status}</td><td>${value.enrolledCHrs}</td> <td>${value.IsunderEnroll}</td><td>${value.IsAddDropRequested}</td>`; 
            student += `</tr>`;
                     
            });
         return student;
}
