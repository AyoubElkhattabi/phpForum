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

                $CanOpenClose = can_open_close_topic($user['u_id'],$_GET['t_id']);
            if($CanOpenClose == true){
                // CHECK IF POST FIX OR NOT
                $topic = topics_get_by_id($_GET['t_id']);
                if($topic['t_isClose'] == 0){
                    $isClose = topics_close($user['u_id'],$_GET['t_id']);
                    if($isClose==true)  header('location: message.php?message=Le Sujet est fermé&link=forum.php?id='.$forum_id.'');
                    else                header('location: message.php?message=error1&link=forum.php?id='.$forum_id.'');
                }else if($topic['t_isClose'] == 1){
                    $Open = topics_open($_GET['t_id']);
                    if($Open==true) header('location: message.php?message=Le Sujet est ouvert&link=forum.php?id='.$forum_id.'');
                    else             header('location: message.php?message=error2&link=forum.php?id='.$forum_id.'');

                }

                

            }

        }

    }
    

    
    
}
else {
    echo 'error';
}





?>