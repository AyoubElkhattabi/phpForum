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
        if(isset($_GET['t_id']) && !empty($_GET['t_id'])){

                //hadi kanjibo biha l forum id 3la 7ssab redirection f message.php
                $forum_id = forum_get_id_by_topic($_GET['t_id']);
                

           
            $CanDelete   = can_delete_topic($user['u_id'],$_GET['t_id']);
            if($CanDelete == true){
                $delete = topics_delete($_GET['t_id']);
                if($delete == true) header('location: message.php?message=Le Sujet est supprimer&link=forum.php?id='.$forum_id.'');
                else header('location: message.php?message=error&link=forum.php?id='.$forum_id.'');
                
            }

        }

    }
    

    
    
}
else {
    echo 'error';
}




?>