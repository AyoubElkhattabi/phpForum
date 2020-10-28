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


    <title><?php echo forum_get_name($_GET['id']);?></title>
    <!--Include ckeditor library-->
    <script src="ckeditor/ckeditor.js"></script>
  
    <?php require_once('inc/header.php'); ?>

<!--START CONTENT-->
<div class="content container-fluid">

  <?php require_once('inc/admin-message.php');?>



  <?php

if(empty($_SESSION['user_info'])){

header('Location: message.php?message=Tu Doit Authentifier Pour Ajouter Un Nouveau Sujet&link=login.php');
exit();

}







if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    

    if(isset($_POST['title']) && isset($_POST['editor'])){

        $isokey = topics_add("1", $_POST['title'] , $_POST['editor'] , $u_id , $_GET['id'] );
        if($isokey == false) { 
            $message = 'ERROR';
            $link = 'forum.php?id='.$_GET['id'];
            header('Location: message.php?message='.$message.'&link='.$link);
        
        }else{

            $message ='Le Sujet Est Ajoute';
            $link = 'forum.php?id='.$_GET['id'];
            header('Location: message.php?message='.$message.'&link='.$link);
        }

        
       

exit();


    }else{
        
    
    }
    
}

?>





 <!--START CATEGORIE AND FORUMS-->
 <!--START forum-->
 <div class="m-3">
     <form method="post" action="" onsubmit="return validate_topic()"> 
<div class="mt-3 mb-3"><span class="text-info title-new-post"><?php echo forum_get_name($_GET['id']); ?>:</span> <span class="text-danger title-new-tt">Nouveau Sujet</span></div>
<div class="mt-3 mb-3"><label>Titre de Sujet : </label>  <input type="text" class="form-control frm-ctr" id="title" name="title" placeholder=""> <span id="titleerror" style="color:red; font-size:18px;">*</span></div>
<div class="editblockr mt-3 mb-3"><textarea name="editor" class="form-control" id="textcontent" rows="10" ></textarea> </div>
<div class="editprofilerow mt-3 mb-3"><button type="submit" class="btn btn-primary btn-lg">Ajouter</button></div>
</form>
</div>


<script src="js/validation.js"></script>
<script>
    CKEDITOR.replace('editor');
</script>


  <!--END forum-->
  
    <!--END CATEGORIE AND FORUMS-->





<?php require_once('inc/footer.php');  db_close();?>