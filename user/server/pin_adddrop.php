<?php  
require 'check_session.php';
include 'connection.php';
include '../header.html';

?>
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

</style>
 <div  id="pin-form" style="background:white">
            <div  style="  margin-bottom: 0%; width: 100% ">

                    <i class='fas fa-exclamation-triangle' style="color: #F0871E"></i><span style="padding-left:1%; ">
                         Pin will deactivated outside the add/drop week.
                        </span>
                     <br>
    
             </div>


            <div id="InputRequiredMessage" class="alert alert-danger" role="alert">
                <strong> Input required!</strong>
            </div>
            <div id="AddDropNotOpenMessage" class="alert alert-danger" role="alert">
                <strong> Invalid pin!</strong> Add/Drop weeks is not open or closed at the moment!
            </div>
           <div id="InvalidPinMessage" class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Invalid pin!</strong> You must enter valid pin!
          </div>
     <br>
        <div class="pinformdiv">

                              <label for="pin">Pin <span style="color:red"> *</span> <br> </label>
                              <input type="password" name="pin" value="" class="form-control" id="pin" maxlength="4" required>

                    <button type="submit" id="submit" name="submit" onclick="submitAddDropPin();" class="btn btn-primary">Submit</button>

        </div>
  </div>
<?php // include '../footer.html' ;?>