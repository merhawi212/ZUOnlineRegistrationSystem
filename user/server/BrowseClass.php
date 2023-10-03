<?php 
require 'check_session.php';
include 'connection.php';
if(empty($_SESSION["login"])){
    header("Location:login.php");
    
}

include '../header.html';
?>

<style>
    #container-BrowseClass{
        margin: 1%;
        margin-top: 2%;
     
        
    } 

    
</style>
<body onload="display_sections()">
 <div class="individual-page">
           <div class="pageName">Browse Classes</div>
        <div id="container-BrowseClass">
            <div id="filter-control" class="form-row">
                <div class="form-group col-md-2" style="margin-left:0%">
                      <label>Course No: </label>
                      <div class="form-group">
                          <input type="text"  class="form-control filter_by" id="search_course" placeholder="Quick search...MTH215">

                    </div>
                </div>
                   <div class="form-group col-md-2" style="margin-left:0%">
                      <label>Course Name: </label>
                      <div class="form-group">
                         <input type="text"  class="form-control filter_by" id="courseName" placeholder="Quick search... Data Analytics">

                    </div>
                </div>
                 <div class="form-group col-md-2" style="margin-left:0%">
                      <label>Subject: </label>
                      <div class="form-group">
                         <input type="text"  class="form-control filter_by" id="subject" placeholder="Quick search... Information Tech">

                    </div>
                </div>
              <div class="form-group col-md-2" style="margin-left:0%">
                      <label>Major: </label>
                      <div class="form-group">
                         <input type="text"  class="form-control filter_by" id="major" placeholder="Major name ">

                    </div>
                </div>
             <div class="form-group col-md-2" style="margin-left:0%">
                      <label>Instructor: </label>
                      <div class="form-group">
                         <input type="text"  class="form-control filter_by" id="instructor" placeholder="Instructor name ">

                    </div>
                </div>

            </div>

    <div class="page-styling" >
        <div class="numofrecordsShown">Number of records shown: <span id="numofRecordsShown">0</span></div>
 

            <div id="coursesTable">
                <fieldset class="form-row">
                        <div class=" col-md-12">
                          <!--id = Dtable-->
                            <table class="sortable" id="tBrowseClass" style="z-index:99999">
                                <thead class="head-style"><tr> <td>Course Title</td><td>Course No</td><td>Subject</td>
                                    <td>Major</td><td>Credit Hrs</td> <td>CRN</td><td>Section No</td>
                                    <td>Instructor</td><td>MeetingDay</td><td>SeatLeft</td>
                                    </tr></thead>
                                    <tbody id="BrowseSections" >

                                    </tbody>

                            </table>
                       </div>
                  </fieldset>
            </div>
        <div class="showNumberofEntries" style="margin-left:1%; margin-top: 1%">showing <span id="oneEntry">0</span> to <span id="numberofDisplaying"> 0 </span>
                           <span style="padding-left:0.4%"> of </span> <span id="TotalnumberofEntries" style="padding-left:0.4%"> 0 </span>
                           <span style="padding-left:0.4%">entries</span>
          </div> 
                <br>
        </div>
        </div>
    <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 </div>
</body>

<script>
    $(window).load(function() {
   $('.preloader').fadeOut('slow');
});
  
</script>
<?php include '../footer.html' ;?>