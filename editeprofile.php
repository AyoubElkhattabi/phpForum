
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
if($_SERVER['REQUEST_METHOD'] === 'GET'){

        if(empty($_SESSION['user_info'])) {header('location: index.php'); exit();}

        if(isset($_GET['id']) && !empty($_GET['id'])){

            // check if user have permission 
            $cancontrole = user_can_control_user($_SESSION['user_info']['u_id'],$_GET['id']);
        
            if($cancontrole == false){
                header('location: index.php');
                exit();
            }
            $user = users_get_by_id($_GET['id']);
            if(empty($user)) {header('location: index.php'); exit();}
            $m = '<input type="hidden" name="notmyprofile" value="1">';
        }else if(empty($_GET) || isset($_GET['updatesuccess'])){
            $user = users_get_by_id($_SESSION['user_info']['u_id']);
            $m = '<input type="hidden" name="myprofile" value="1">';
        }

}
  



?>











    <title>index</title>
  
    <?php require_once('inc/header.php'); ?>

<!--START CONTENT-->
<div class="content container-fluid">

  <?php require_once('inc/admin-message.php');?>


  
  

  







 <!--START CATEGORIE AND FORUMS-->
 

 <div class="main ">

 




<h3 class="text-center" style="color:#41B8F3">Information Personnelle<h3>

  <form method="POST" action="updateprofile.php?action=updateinfo"> 

  <input type="hidden" name="id" value="<?php echo $user['u_id'];?>">
  <div class="editprofile ">

  <div class="row editprofilerow">
  
  <div class="editblockl col-3"><span class="labeln">Nom réel :</span></div>
  <div class="editblockr col-3"><input type="text" name="nomreel" class="form-control" placeholder="Nom réel" value="<?php echo $user['u_realName'];?>"></div>

    <div class="editblockl col-3"><span class="labeln">Date de Naissance :</span></div>
    <div class="editblockr col-3"><input type="date" name="birthdate" class="form-control" placeholder="date de naissance" value="<?php echo $user['u_birthDay'];?>"></div>
</div>
   <div class="row editprofilerow">
  <div class="editblockl col-3"><span class="labeln">Ville :</span></div>
  <div class="editblockr col-3"><input type="text" name="ville" class="form-control" placeholder="Ville" value="<?php echo $user['u_city'];?>"></div>

  <div class="editblockl col-3"><span class="labeln">Pays :</span></div>
  <div class="editblockr col-3"><input type="text" name="pays" class="form-control" placeholder="Pays" value="<?php echo $user['u_country'];?>"></div>
  </div>
  <div class="row editprofilerow">
      <div class="editblockl col-3"><span class="labeln">État civil :</span></div>
      <div class="editblockr col-3"><select class="custom-select" name="marstatus"><option value="0" <?php if($user['u_marStatus']==0) echo 'selected';  ?> >celibataire</option><option value="1"  <?php if($user['u_marStatus']==1) echo 'selected';  ?>>marié</option></select></div>
      <div class="editblockl col-3"><span class="labeln">Sexe :</span></div>
     <div class="editblockr col-3 editsexe"> <label class="labeln">Male</label> <input type="radio" name="sexe" value="1" <?php if($user['u_gender']==1) echo 'checked';  ?>> <label class="labeln">Female</label> <input type="radio" name="sexe" value="0" <?php if($user['u_gender']==0) echo 'checked';  ?>></div>
      </div>
      <div class="row editprofilerow">
         
          <div class="editblockl col-3"><span class="labeln">Image Url :</span></div>
          <div class="editblockr col-7"><input type="text" class="form-control" name="image" placeholder="Image Url" value="<?php echo $user['u_image'];?>"></div>
          </div>
  
          <div class="row editprofilerow">
              <div class="editblockl col-3"><span class="labeln">Biographie :</span></div>
              <div class="editblockr col-9"><textarea class="form-control" id="exampleFormControlTextarea1" name="bio" rows="3"><?php echo $user['u_bio'];?></textarea> </div>
              
              </div>
              <div class="row editprofilerow">
                  <button type="submit" class="btn btn-primary btn-lg btn-block">Mise a jour</button>
                  
                  </div>
  
  
  </div>
</form>

<br> <br>

<h3 class="text-center" style="color:#41B8F3">Changer le Nom d'utilisateur<h3>

  <form method="POST" action="updateprofile.php?action=updateusername" onsubmit="return validation_change_username()"> 

  <input type="hidden" name="id"  value="<?php echo $user['u_id'];?>">
  <div class="editprofile ">

  <div class="row editprofilerow">
  
  <div class="editblockl col-3"><span class="labeln">Nouveau nom d'utilisateur :</span></div>
  <div class="editblockr col-3"><input type="text" name="username" id="vusername" class="form-control" placeholder="nom d'utilisateur" value=""></div>
  <div class="editblockl col-6 text-left"><span class="labeln" style="color:red;" id="usernamemsgerr"></span></div>
</div>
     
<div class="row editprofilerow">
<button type="submit" class="btn btn-primary btn-lg btn-block">Changer</button>
</div>
</div>
</form>

<br><br>
<h3 class="text-center" style="color:#41B8F3">Changer le Mote de passe<h3>

  <form method="POST" action="updateprofile.php?action=updatepassword" onsubmit="return validation_change_password();"> 
  <input type="hidden" name="id" value="<?php echo $user['u_id'];?>">

  <div class="editprofile ">

  <div class="row editprofilerow">
  <div class="editblockl col-3"><span class="labeln">Mot de passe actuel: :</span></div>
  <div class="editblockr col-3"><input type="password" name="password" id="password" class="form-control" placeholder="*******" ></div>
  <div class="editblockr col-6 text-left"><span style="color:red; font-size:16px;" id="errpasswordmsg"></span></div>
</div>
<div class="row editprofilerow">
  <div class="editblockl col-3"><span class="labeln">Nouveau Mot de passe:</span></div>
  <div class="editblockr col-3"><input type="password" name="npassword" id="npassword" class="form-control" placeholder="*******"></div>
  <div class="editblockl col-3"><span class="labeln">Re - Nouveau Mot de passe:</span></div>
  <div class="editblockr col-3"><input type="password" name="rnpassword" id="rnpassword" class="form-control" placeholder="*******"></div>
</div>


     
<div class="row editprofilerow">
<button type="submit" class="btn btn-primary btn-lg btn-block">Changer</button>
</div>
</div>
</form>

<br><br>
<h3 class="text-center" style="color:#41B8F3">Changer E-mail<h3>

  <form method="POST" action="updateprofile.php?action=updateemail" onsubmit="return validation_change_email();"> 
  <input type="hidden" name="id" value="<?php echo $user['u_id'];?>">

  <div class="editprofile ">

  <div class="row editprofilerow">
  
  <div class="editblockl col-3"><span class="labeln">Nouveau Email :</span></div>
  <div class="editblockr col-3"><input type="email" name="email" id="email" class="form-control" placeholder="e-mail@gmail.com" value="<?php echo $user['u_email']; ?>"></div>
  <div class="editblockl col-6 text-left"><span class="labeln" id="erroremailmsg" style="color:red"></span></div>
</div>
     
<div class="row editprofilerow">
<button type="submit" class="btn btn-primary btn-lg btn-block">Changer</button>
</div>
</div>
</form>





  </div>

  </div>
  
  
  <div class="rightSide"></div>
    
  
  
<!--END CATEGORIE AND FORUMS-->




<script src="js/validation.js"></script>
<?php require_once('inc/footer.php');  db_close();?>