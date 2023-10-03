<?php 
require 'check_session.php';
require '../head.html';

?> 
<style>
    .NotAvailable{
        color: red;
    }
    #sections-page{
        background-color: white;
        /*border:*/ 
        padding: 1%;
    }
     .modal-body .form-group label{
        font-weight: bold;
    }
    #exampleModal{
        z-index: 2147483647;
    }
    .modal-body .form-group{
        display: flex;
        margin: 1%;
    }
    .modal-body .form-group label {
        width: 16%;
        margin-right: 2%;
    }
    .modal-body .form-group input {
        margin-left: 4%;
        width: 80%;
    }
     #exampleModal_2, exampleModal_1{
        margin-top: 4%;
    }
    #filter-control{padding-top: 2%}
</style>
<body onload="display_sections()" >
     <div class="individual-page">
        
       <div class="pageName">Manage Running Classes</div>
        
       <div id="updatesuccessNotification">section is successfully updated</div>
        <div id="updateerrorNotification">unable to update</div> 
        <div id="deletesuccessNotification">section is deleted successfully </div>
        <div id="deleteerrorNotification">unable to delete</div> 
        <div id="addsuccessNotification">section is added successfully</div>
        <div id="adderrorNotification">unable to add</div> 
         <div class="page-styling" >
          <?php require '../filterGroupsForSectionsAndDataInputs.html';?>
         </div>
       <div class="page-styling" >
        <div class="numofrecordsShown">Number of records shown: <span id="numofRecordsShownForDisplay_Sections">0</span></div>
          <div style="width:10%; display: flex ; right: 0; margin-bottom: 0.5%; margin-left: 88%;">
            <button  type='submit' class='btn btn-primary' id ="addSection"
               style="  background-color: #138D75; z-index: 9999; border-radius: 5%" 
               data-toggle="modal" data-target="#exampleModal_2" > Add Section </button>
          </div>
      
        <div>
            <fieldset class="form-row" style="margin-left:0.2%; width: 100%">

                        <table class="sortable" id="CourseTable" style=" width: 99.6%">
                            <thead class="head-style"><tr> <th>Course Title</th><th>Course No</th>
                                <th>Major</th><th>CHrs.</th> <th>CRN</th><th>Section No</th>
                                <th>Instructor</th><th>MeetingDay</th><th>Location</th><th>SeatLeft</th><th> - </th><th> - </th>
                                </tr></thead>
                                <tbody id="display_Sections" >

                                </tbody>

                        </table>
              </fieldset>
            
        </div>   
         <div class="showNumberofEntries" style="margin-left:1%; margin-top: 1%">showing <span id="oneEntryForDisplay_Sections">0</span> to <span id="numberofDisplayingForDisplay_Sections"> 0 </span>
                           <span style="padding-left:0.4%"> of </span> <span id="TotalnumberofEntriesForDisplay_Sections" style="padding-left:0.4%"> 0 </span>
                           <span style="padding-left:0.4%">entries</span>
          </div> 
        <br>
        </div>       
          

    </div>
    
    
   <?php    require '../manageSectionModals.html';?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  <?php 
require '../footer.html';

?>  

 