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
 
 ?>
    <title>Message</title>
  
    <?php require_once('inc/header.php'); ?>

<!--START CONTENT-->
<div class="content container-fluid">

  <?php require_once('inc/admin-message.php');?>


 <!--START Message-->

    <div class="d-flex justify-content-center login-form">


    <div class="box-message">
    <?php

    if($_SERVER['REQUEST_METHOD'] ==='GET'){
      if(isset($_GET['message']) && isset($_GET['link'])){

        $message = $_GET['message'];
        $link    = $_GET['link'];
        echo '<p class="text-center">'.$message.'</p>';
       echo '<meta http-equiv="refresh" content="2;url='.$link.'" />';
      }
    }
   

    ?>

    
    </div>



    </div>

  <!--END login-->
<?php require_once('inc/footer.php');?>