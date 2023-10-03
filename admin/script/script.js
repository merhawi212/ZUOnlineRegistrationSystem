
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
             $("#display_Sections").html(section);
            if(data.length > 0)
                $("#oneEntryForDisplay_Sections").html(`<b>1</b>`);
 
            $("#numofRecordsShownForDisplay_Sections").html(`<b>${data.length}</b>`);
            $("#numberofDisplayingForDisplay_Sections").html(`<b>${data.length}</b>`);
             $("#TotalnumberofEntriesForDisplay_Sections").html(`<b>${data.length}</b>`);
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
   function add_Section(){
        var id =  $("#courseid").val();
        var crn = $("#CRN").val();
        var secNo =  $("#section_no").val();
        var faculty_id =$("#fac_id").val();
        var MeetingDay = $("#meetingday").val();
        var time =  $("#meetingtime").val();
        var location = $("#meetinglocation").val(); 
        if (id !=='' && crn !== '' && secNo !=='' && faculty_id !=='' && MeetingDay !=='' 
                && time !=='' & location !==''){
        $.ajax({
            method: "POST",
            url: "../server/controller.php",
            dataType: "html",
            dataSrc:'',
            data: {request_type: "add_section",crn:crn, id:id, secNo:secNo,faculty_id:faculty_id, 
                        meetingDay:MeetingDay, time:time, location:location},
            success: function(data) {
                notification(data, 'add');
                $('#exampleModal_2').modal('hide');
                display_sections();
//                $("#courseid").val('');
            }
        });
    }else{
                var error = `All fieds are required!`;
                   $(`#AddsectionErrorNotification`).html(error).delay(5000).fadeOut();
    }
   }
  function  edit_section(section){
      var crn = $(section).attr("data-section-id");
      $.ajax({
        method: "POST",
        url: "../server/controller.php",
        dataType: "json",
        dataSrc:'',
        data: {request_type: "fetch_selected_section",crn:crn},
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
   function  update_Section(){
    var id =  $("#id").val();
    var crn = $("#crn").val();
    var secNo =  $("#SecNo").val();
    var instructor =$("#Instructor").val();
    var MeetingDay = $("#day").val();
    var time =  $("#time").val();
    var loc = $("#location").val();
              
      $.ajax({
        method: "POST",
        url: "../server/controller.php",
        dataType: "html",
        data: {request_type: "update_section", id:id, crn:crn, secNo:secNo,
                            instructor:instructor, meetingDay:MeetingDay, time:time, loc:loc},
        success: function(data) {
             notification(data, 'update');
            $('#exampleModal').modal('hide');
            display_sections();
            
         }
    });
   
  }
  
  
  function  delete_section(submit){
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
                     url: "../server/controller.php",
                     dataType: "html",
                     data: {request_type: "delte_section",  crn:crn},
                     success: function(data) {
                         notification(data, 'delete');
                         $('#exampleModal').modal('hide');
                         display_sections();

                      }
                 });
            }
        });
  }

  
  function  notification(data ='', actionType=''){

      if(data ==='success'){
                var x = document.getElementById(`${actionType}successNotification`);
                x.className = "show";
                setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
            }
            else{
                 var x = document.getElementById(`${actionType}errorNotification`);
                x.className = "show";
                setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
            }
  }
  
   function sectionFromat(data, requestType=''){
        var section = '';

        var type =requestType;
        var i = 1;
        $.each(data, function(key, value){
             section +=   `<tr><td>${value.courseName}</td><td>${value.id}</td>`;
            if (type ==='Enrolled' || type === 'AddDrop' || type ==='Browse' ||
                    type === 'RetriveAddDropRequested' || type === 'EnrollStudent'){       
                 section +=   `<td>${value.Major}</td>`;
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
            }
                var seatStatus = 'Available';
                var isStatusEditable ='';
                var conflict = '';
                if (value.conflict === 'conflict' && value.RequestType ==='Add' ){
                    isStatusEditable ='disabled';
                    
                    conflict = 'conflict';
                }
                var isSeatsLeft = '';
                if(value.SeatLeft === 0){
                        seatStatus = 'NotAvailable';
                        isSeatsLeft ='disabled';
                    }
                section +=  `<td>${value.RoomLocation} </td>`;
                var editFunName = "edit_section(this)";
                var deleFunName = "delete_section(this)";
                if (value.campus !==''){
                    section +=  `<td>${value.campus} </td>`;
                    editFunName ="classScheduler_edit_section(this)";
                    deleFunName ="deleteClassFromCreatedClasses(this)";
                    
                }
                 section += `<td class="${seatStatus}  ${conflict}">${value.SeatLeft} seats of <span>${value.RoomCapacity}</span></td>`;
                if (type ==='Enrolled'){
                      section +=  `<td>${value.EnrolledDateTime}</td><td class="enrolledstatus">Enrolled</td><td> <button  type="submit" class="btn btn-primary" data-section-id="${value.CRN}" 
                        id ="deleteSection"   onclick="drop_EnrolledCourse(this);" style="background-color: red; z-index: 99999;"> Drop </button></td>`; 
                      
                  }
                if (type ==='Browse'){
                section += `<td><button  type="submit" class="btn btn-primary" data-section-id="${value.CRN}"  id ="editSection"  
                                onclick="${editFunName};" style="background-color: green; z-index: 99999;" 
                                    data-toggle="modal" data-target="#exampleModal"> Edit </button></td>`;
                   section += `<td> <button  type="submit" class="btn btn-primary" data-section-id="${value.CRN}"  id ="deleteSection"  
                                onclick="${deleFunName};" style="background-color: red; z-index: 99999;"> Delete </button></td>`;
            
            }    
                if(type === 'RetriveAddDropRequested'){
                    
                          section +=  `<td>${value.RequestType}</td><td>${value.AddDropRequestedTime}</td>
                        
                    <td><select id="selectApprovalActions_${i}" onchange="updateStatusAction(this);"    ${isStatusEditable}  ${isSeatsLeft}>
                     <option value='Requested' data-crn="${value.CRN}"  data-request-type="${value.RequestType}" selected>Requested</option>
                        <option value='Inprogress' data-crn="${value.CRN}" data-request-type="${value.RequestType}" >Inprogress</option>
                        <option value='Approved' data-crn="${value.CRN}" data-request-type="${value.RequestType}">Approved</option>
                        <option value='Rejected' data-crn="${value.CRN}" data-request-type="${value.RequestType}">Rejected</option> </select> </td>`;
                      }
                if (type === 'EnrollStudent'){
                    conflict =(value.conflict ==='conflict')?'conflict':'';
                    isStatusEditable =(conflict ==='conflict')?'disabled':'';
                    
                     section += `<td> <button  type="submit" class="btn btn-primary  ${conflict}" data-section-id="${value.CRN}"  id ="enrollClass"  
                                onclick="enrollToClass(this);" style="background-color: green; z-index: 99999;" ${isStatusEditable} ${isSeatsLeft}> Enroll </button></td>`;
                }     
                 i++;
//       
                    section += `</tr>`;
                     
            });
            return section;
}
