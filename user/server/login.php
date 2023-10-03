<?php  
session_start();
 include 'connection.php';
 
 date_default_timezone_set('Asia/dubai');

//     $salt = createSalt();
//function createSalt()
//{
//    $text = md5(uniqid(rand(), TRUE));
//    return substr($text, 0, 3);
//}
// $password1 = '';
//     $hash=hash('sha256', $password1);

//$hash1 = hash('sha256', $salt . $hash);

//$hash2=substr($hash1, 0, -14);


$err=" ";
if(isset($_POST["submit"])){  
  
    if(!empty($_POST['username']) && !empty($_POST['password'])) {  
        $user= $_POST['username'];  
    //    md5
        $pass=  $_POST['password'];
        $username =' ';
        if (preg_match('/@/', $user))
            $username = substr($user, 0, strpos($user, "@"));
        else 
            $username = $user;

         $query= "SELECT * FROM student_logincredential WHERE Std_ID = '$username'";  
        $result= mysqli_query($connection, $query);
         $numrows=mysqli_num_rows($result); 
//         echo $numrows;
	if($numrows == 0){
            $err= "Invalid username";  
	}
       else {   
            $row = mysqli_fetch_array($result);
            $hash = hash('sha256', $row['salt'] . hash('sha256', $pass));
            
            if($row['std_password'] === $hash){
                $_SESSION["login"]=$username;
               $now= date('Y-m-d h:i:s', time());

                $_SESSION["LastAccessingTime"]=$now;
                $_SESSION["lastAccessTimeStamp"] = time();
                 $query="update user_log set user_status='active', LastAccessingTime = '$now' "
                         . "WHERE username='$username'"; 
                 $result= mysqli_query($connection, $query);
                 if($result)
                    header("Location: HomePage.php"); 
           } else {
               $err= "Invalid username or password";  
           }
       }
    } 

    else {  
        $err.= "All fields are required!";  
    }  
}  

?>  
<!DOCTYPE html>
<html>
    <head>
        <title>Login-Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../style/login.css" rel="stylesheet" type="text/css"/>
    
    <style>   
        body{
            background:  cadetblue;
        }
  
    </style>  

    <div class="loginForm">

        <h3>E-Registration</h3>
        <form action="" method="POST">  
            <!--<p class = "error" id="require">* required field </p>--> 
            <fieldset class="form-row" >

                <div class="form-group ">

                        <!--<label for="username">Username</label>-->
                  <div class="input-group" >

                          <span class="input-group-addon"><i class="fa fa-user"></i></span>

                   <input name="username" id="username" class=" form-control" type="text"  placeholder="username">

                      </div> 
                    <p class="error">* <?php echo $err;?> </p>
                </div>
            </fieldset>

             <fieldset class="form-row">
                    <div class="form-group">
                  <!--<label for="password">Password</label>-->
                  <div class="input-group-append" style="width:114%">

                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                 <input type="password" name="password" class="form-control" id="password" placeholder="password">
                  </div>
                   <p class="error">* <?php echo $err;?> </p>
                </div>
         </fieldset>      

         <input type="submit" value="Login" name="submit" id="submit" style="border-radius: 8%;"/>

        </form>  
    </div>
   
</body>  
</html>   