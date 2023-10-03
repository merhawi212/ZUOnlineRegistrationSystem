<?php 
require 'check_session.php';
include 'connection.php';
include '../header.html';
?>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<link href="../style/style_2.css?2" rel="stylesheet" type="text/css"/>
<style>
    .carousel-inner img{
        width: 50%;
    }
/*    .w-100{
        width: 90%!important;
        margin-left: 5%;
    }*/
.top-menuContainer{
    margin-bottom: 0!important;
    padding-bottom: 0!important;
}
.bcontainer{
    margin: 0;
    padding: 0;

/*margin: 1%;
 padding: 1%;
 background: white;
 border-radius: 1%;*/
  min-height: 75vh;
 overflow: hidden;

}
#carouselExampleIndicators{
    margin: 0%!important;
}
.top-menuContainer .collapse .navbar-nav a.nav-link:hover{color: white!important}
</style>
<div class ="bcontainer" >
 <img src="../image/godigital.gif" class="d-block w-100" alt=""/>

<!--<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
     
      <img src="../image/godigital.gif" class="d-block w-100" alt=""/>
      <div class="carousel-caption d-none d-md-block" style="margin-top:-40%; margin-left: -40%; ">
    <h5>E-Registration</h5>
    
  </div>
   
    </div>
    <div class="carousel-item">
     
      <img src="../image/now-open.png"  class="d-block w-100" alt=""/>
    </div>

  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>-->
<!--    <p>ZU E-Registration</p> -->
</div>
<?php include '../footer.html' ;?>

