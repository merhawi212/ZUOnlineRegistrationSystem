<?php 

require 'check_session.php';


include 'connection.php';
if(empty( $_SESSION['pinForRegistration'])){
     header("Location:pin.php");
}

include '../header.html';
?>

<script id="courseProjection" type="text/html">
    <tr class="" >
      <td>{{courseName}}</td><td>{{id}}</td><td>{{subject}}</td><td>{{Major}}</td><td>{{CreditHour}}</td>
      <td>  
     <button type='submit' {{status}}  id ="course-id" data-course-id="{{id}}" name='view' onclick="add_Course_ToCart(this);" 
             class='btn btn-primary ' style=" background-color: darkcyan; z-index: 99999">
     ADD  </button></td>
      
    </tr>
</script>

<style>
    body{
        font-family: sans-serif;
        margin: 0;
        padding: 0;
        background-repeat: no-repeat;
    }
    .error{
        color: red;
    }

    button #course-id {
        padding: 0%;
        margin: 0%;    
    }

  
</style>
<body onload="fetch_projection()">
     <div class="individual-page">
        <div id="successNotification">Course is added to the cart successfully  </div>
          <div id="errorNotification">Exceeds Max Course Load!</div>
          <div class="pageName">Course Projection</div>
         <div class="page-styling" >
        <div class="numofrecordsShown">Number of records shown: <span id="numofRecordsShown">0</span></div>

        <div class="container-register">

            
            <div class="" id="coursesTable">
            <fieldset class="form-row">
                    <div class=" col-md-12">

                        <table id="Dtable">
                                <thead class="head-style"> 
                                <tr><th>Course Title</th><th>Course No</th><th>Subject</th>
                                   <th>Major</th> <th>Credit Hrs</th><th style="width:8%">Action</th> </tr>
                             </thead>
                                <tbody id="coursesFromProjection" >

                                </tbody>
                       </table>    


                        <div style="margin-top: 1%">
                        <button class='btn btn-primary float-right' type='submit' id ="GoTOScheduler"   onclick="redirectTOScheduler();"
                          style="background-color: green; z-index: 99999;"> Next </button>

                        </div>

                    
                       </div>


              </fieldset>
        <div class="showNumberofEntries" style="margin-left:1%">showing <span id="oneEntry">0</span> to <span id="numberofDisplaying"> 0 </span>
                           <span style="padding-left:0.4%"> of </span> <span id="TotalnumberofEntries" style="padding-left:0.4%"> 0 </span>
                           <span style="padding-left:0.4%">entries</span>
          </div> 
                <br>
            </div>
          </div>   
         </div>
          <br>
     </div>
          <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="http://code.jquery.com/jquery-2.2.1.min.js"></script>



    

<script>

$(window).load(function() {
   $('.preloader').delay(500).fadeOut('slow');
});
</script>
<?php include '../footer.html' ;?>

<?php // include '../footer.html';?>

 