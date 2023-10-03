<?php  
require 'check_session.php';
//include 'connection.php';
include '../header.html';

?>
<div class="form-group col-sm-1" style="margin-left:0.4%; width: 10%; ">
    <label>Select Term: </label>
    <div class="form-group">
        <select class="form-control filter_by" id="term" onchange="search_selectDB();">
            <option value="All">All</option>
            <option value="course_registration_system">Term202322-Spring 2023</option><!-- comment -->
            <option value="term202221">Term202221 -Fall 2022</option>
        </select>         
        <div id='dbname'></div>
     </div>
   </div>
<script><!-- comment -->
    search_selectDB();
    function  search_selectDB(){
    var db = $('#term').val();
    $.ajax({
        method: "POST",
        url: "connection.php",
        
        dataType: "html",
        data: {request_type: "select_db", dbtype:db},
        success: function (data) {
            if (data !=='')
                window.location.href ="BrowseClass.php";
//                $('#dbname').html(data);
          

        }
    });  
    }
    </script>