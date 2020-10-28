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
            exit();
}

// chek if user comming from post request post methode
$isokey = false;
if(isset($_POST['btnlogin'])){

    $username = $_POST['username'];
    $password = $_POST['password'];
    // kan9albo 3la username
    $result = users_get_by_username($username);
    // ila mal9ahch 
    if(gettype($result)=='array'){
        if(strcmp($password,$result['u_password']) == 0){
            $isokey==true;
            $_SESSION['user_info'] =$result;
            header('Location: index.php');
            exit();
        }    
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
                    <i class="fas fa-user brand_logo" ></i>
                  
                </div>
            </div>

            <?php
            
                    if(isset($_POST['btnlogin'])){
                    if($isokey==false)
                    echo '
                    <div class="alert alert-danger fade show" role="alert" style="top: 96px;">nom utilisateur ou mot de passe incorrect<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    ';
                   
                   
                }
                
                
            ?>
            <div class="d-flex justify-content-center form_container">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return true">
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" name="username" class="form-control input_user" value="" placeholder="nom utilisateur">
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" name="password" class="form-control input_pass" value="" placeholder="mot de passe">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customControlInline">
                            <label class="custom-control-label" for="customControlInline">Remember me</label>
                        </div>
                    </div>
                        <div class="d-flex justify-content-center mt-3 login_container">
                 <button type="submit" name="btnlogin" class="btn login_btn">Login</button>
               </div>
                </form>
            </div>
    
            <div class="mt-4">
                <div class="d-flex justify-content-center links">
                    Don't have an account? <a href="#" class="ml-2">Sign Up</a>
                </div>
                <div class="d-flex justify-content-center links">
                    <a href="#">Forgot your password?</a>
                </div>
            </div>
        </div>
    </div>

<?php require_once('inc/footer.php');?>