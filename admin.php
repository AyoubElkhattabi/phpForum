<?php 
//--------------------- Copyright Block ----------------------
/* 

KechForum: forum (ver 0.1)
Copyright (C) 2019-2020 PrayTimes.org

Developer: ELKHADDARI AYOUB
License: GNU LGPL v3.0

TERMS OF USE:
	Permission is granted to use this code, with or 
	without modification

This program is distributed in the hope that it will 
be useful, but WITHOUT ANY WARRANTY. 

PLEASE DO NOT REMOVE THIS COPYRIGHT BLOCK.
 
*/ 
require_once('session.php'); 
require_once('inc/top-header.php');

session_start();

if(isset($_SESSION['user_info'])){

  if($_SESSION['user_info']['u_role']  !="admin"){
    header("location: index.php");
    exit();
  }
}else{
  header("location: index.php");
  exit();
}



     //title
     echo'
    </head>
  <body>
    <!--start page admin-->
<div class="container-fluid">
    <!--title of menu-->

    <div>
      
    ';
   
  
echo'
  </div>

<!--end title of menu-->
<!--start content -->
<div class="row">
    <!--start menu-->
    <div class="menu col-3">
        <div><a href="admin.php?id=1"><h1>categories</h1></a></div>
        <div><a href="admin.php?id=2"><h1>forums</h1></a></div>
        <div><a href="admin.php?id=3"><h1>Roles</h1></a></div>
        <div><a href="admin.php?id=4"><h1>Admin Message</h1></a></div>


    </div>
    <!--end menu-->

    <!-- content of menu link-->
<div class="col-9">
';
  

//<!-- start contenu diyal pag menu-->
if(isset($_GET['id']) ){
    switch($_GET['id']){

    case "1" : require('admin/categories.php'); break;
    case "2" : require('admin/forums.php'); break;
    case "3" : require('admin/role.php'); break;
    case "4" : require('admin/adminmessage.php'); break;

    default : break;
    }

}

//<!-- end contenu d page menu-->

echo'
</div>


</div>
<!--end content-->
</div>
<!--end diyal fluid-->





    <!--end page admin-->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../js/jquery-3.4.1.slim.min.js"></script>
    <script src="../js/popper.min.js" ></script>
    <script src="../js/bootstrap.min.js"></script>
    <!--Fontawsom js-->
    <script src="../js/all.min.js"></script>
    <script src="../js/fontawesome.min.js"></script>
  </body>
</html>


';

?>