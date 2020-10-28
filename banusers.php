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

require_once('inc/top-header.php');
require_once('session.php'); 
require_once('inc/top-header.php');
if(isset($_GET['id']) && !empty($_GET['id'])){

    if(empty($_SESSION['user_info'])){exit('error5');}
    $user = users_get_by_id($_GET['id']);
    if($user == 0 || $user == NULL){exit('error1');}

    $cancontrol = user_can_control_user($_SESSION['user_info']['u_id'],$_GET['id']);
    if($cancontrol == false)  exit('error2');

}else{

    exit('error3');
}


?>

    <title>index</title>
  
    <?php require_once('inc/header.php'); ?>

<!--START CONTENT-->
<div class="content container-fluid">

  <?php require_once('inc/admin-message.php');?>



  


 <!--START CATEGORIE AND FORUMS-->
 

<?php
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if(isset($_POST['ban'])){

        $x = users_ban_user($_GET['id'] , $_SESSION['user_info']['u_id'] , $_POST['banreason']);
        if($x!=true)
        echo 'error787';

    }else if(isset($_POST['unban'])){

        $x = users_unban_users($_GET['id'] , $_SESSION['user_info']['u_id']);
        if($x != true)
        echo 'error747';

    }
    $user = users_get_by_id($_GET['id']);
}

?>

<form method="POST">
    
    <div class="editprofile" style="text-align: center; height: 173px;">
      
     <div style="background-color:#185886; margin-bottom: 10px; color:white; padding:10px; text-align:center">Bloquer/debloquer <span style="color:red"><?php echo $user['u_username'];?></span></div>
            
     <?php
        
  
            if($user['u_isBanned'] == 1){
                echo'
                <input type="hidden" name="unban" value="'.$user['u_id'].'">
                <button type="submit" class="btn btn-warning">Débloquer</button>
                ';
            }else {
            echo ' 
                <input type="hidden" name="ban" value="'.$user['u_id'].'">
              <label> Raison de bloqué : </label>  
            <textarea name="banreason" style="position: relative;bottom: -23px;">
            </textarea>
            <button type="submit" class="btn btn-warning">Bloquer</button>
            ';
            }
            ?>
      </div>
    
    </form>
  
  
<!--END CATEGORIE AND FORUMS-->





<?php require_once('inc/footer.php');  db_close();?>