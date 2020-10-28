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

if(empty($_SESSION['user_info'])) exit('error');



if(isset($_GET['action']) && !empty($_GET['action'])){

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        if(($_SESSION['user_info']['u_id'] == $_POST['id']) || user_can_control_user($_SESSION['user_info']['u_id'],$_POST['id']) == true){
            
            $update = false;
            $msg='';
            if($_GET['action'] == 'updateinfo'){

                $update = users_updateinfo($_POST['id'],$_POST['pays'],$_POST['ville'],$_POST['birthdate'],$_POST['nomreel'],$_POST['marstatus'],$_POST['sexe'],$_POST['image'],$_POST['bio']);
                if($update == true) $msg = 'Vos données ont été mises à jour avec succès';
                else $msg = 'error11';
            }
            
            
            else if($_GET['action'] == 'updateusername'){

                $update = users_update_username($_POST['id'] , $_POST['username']);
                if($update == true) $msg = 'your username is updated';
                else $msg = "le nom d'utilisateur est deja utiliser";

            }
            
            
            else if($_GET['action'] == 'updatepassword'){


                 if($_POST['password'] == $_SESSION['user_info']['u_password']){
                    $update = users_update_password( $_POST['id'], $_POST['npassword']);
                    if($update == true) $msg = 'your password is updated';
                    else $msg ='error4747';
                 }
                else $msg = 'old password is incorrect';

            }
            
            
            else if($_GET['action'] == 'updateemail'){
                    $update = users_update_email($_POST['id'] , $_POST['email']);
                    if($update == true){
                        $msg = 'your email is updated';
                    }else{
                        $msg = 'email is exists in our database';
                    }
                
            }
            
            
            else{

                exit('error');
            }
            




            /*if($update == true) */
            header('location: message.php?message='.$msg.'&link='.$_SERVER['HTTP_REFERER']);
            //else header('location: message.php?message=Error&link='.$_SERVER['HTTP_REFERER']);


        }


    }

}
?>




