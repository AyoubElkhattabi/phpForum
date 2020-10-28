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
session_start();
require_once('inc/top-header.php');
if(isset($_SESSION['user_info']) && !empty($_SESSION['user_info'])) {
    $user=$_SESSION['user_info'];
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        if(isset($_GET['r_id']) && !empty($_GET['r_id'])){

                //hadi kanjibo biha l forum id 3la 7ssab redirection f message.php
                $reply = comments_get_by_id($_GET['r_id']);
                if(empty($reply) || is_null($reply)) exit('error4423');
               
           $u_id = $_SESSION['user_info']['u_id'];
            $CanDelete   = can_edite_delete_reply($_GET['r_id']);
            if($CanDelete == true){
                $delete = comments_delete($_GET['r_id']);
                if($delete == true) header('location: message.php?message=Le commentaire est supprimer&link=topic.php?id='.$reply['t_id'].'');
                else header('location: message.php?message=error&link=topic.php?id='.$reply['t_id'].'');
                
            }else{

                exit('err');
            }

        }

    }
    

    
    
}
else {
    echo 'error';
}




?>