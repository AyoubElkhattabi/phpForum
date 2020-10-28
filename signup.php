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
if($_SESSION['user_info']!=false) {
    header('Location: index.php');
            exit();}

// chek if user comming from post request post methode
if(isset($_POST['btnsignup'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $error_message='';
    $error = NULL;

    //check username 
    $u = users_get_by_username($username);
    $e = users_get_by_email($email);
    if($u!=0){$error_message .='Ce nom d utilisateur existe déjà';  $error = 1;}
    if($e!=0){ $error_message .='Ce Email existe déjà' ;  $error = 1;}
    if($e==0 && $u==0){
        $add_user_results = users_add($username,$password,$email);
        if($add_user_results ==true){ 
            $error_message ='Votre compte a été bien ajouté';  $error = 0; 
        // daba radi y5assni najouti l username l history 
        // get id of new user
        $_id_user = users_get_id_using_usernamepassword($username,$password);
        // add to history 
        users_add_username_to_history($_id_user,$username);
        }
        if($add_user_results == false){ $error_message ="sqlerror";  $error = 1;}
    }   
}
?>
    <title>Créer mon compte</title>
  
    <?php require_once('inc/header.php'); ?>

<!--START CONTENT-->
<div class="content container-fluid">

  <?php require_once('inc/admin-message.php');?>


 <!--START login-->

    <div class="d-flex justify-content-center login-form">
        <div class="user_card">
            <div class="d-flex justify-content-center">
                <div class="brand_logo_container">
                    <i class="fas fa-user-plus brand_logo"></i>
                  
                </div>
            </div>

            <?php
                    if(isset($_POST['btnsignup'])){
                    if($error==1)
                    echo '
                    <div class="alert alert-danger fade show" role="alert" style="top: 96px;">'
                    .$error_message.
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    ';
                    

                    if($error==0)
                    echo '
                    <div class="alert alert-primary fade show" role="alert" style="top: 96px;">'
                    .$error_message.
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    ';
                   
                }
                db_close();
            ?>
            <div class="d-flex justify-content-center form_container">
                <form  class="signupform"action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return validation_change_username()">
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" name="username" id="username" class="form-control" value="" placeholder="nom utilisateur">
                        <span class="signuperror col-12" id="username_error"></span>

                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" id="password" name="password" class="form-control input_pass" value="" placeholder="mot de passe">
                        <span class="signuperror col-12" id="password_error"></span>

                        
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" name="repassword" id="repassword" class="form-control input_pass" value="" placeholder="Re - mot de passe">
                        <span class="signuperror col-12" id="repassword_error"></span>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-at"></i></span>
                        </div>
                        <input type="text" name="email" id="email" class="form-control" value="" placeholder="email" >
                        <span class="signuperror col-12" id="email_error"></span>
                        
                    </div>
                    <div class="d-flex justify-content-center mt-3 login_container">
                         <!-- <input type="submit" name="btnsignup" class="btn login_btn" value="Créer mon compte">-->
                        <button type="submit" name="btnsignup" class="btn login_btn">Créer mon compte</button>
               </div>
                </form>
            </div>
        </div>
    </div>
<script src="js/signup.js"></script>
  <!--END login-->
<?php require_once('inc/footer.php');?>