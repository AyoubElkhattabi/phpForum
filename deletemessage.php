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

if(empty($_SESSION['user_info'])) exit("error");


if(isset($_GET['id'])){
    if(empty($_GET['id'])) exit("error1");
    $message = message_get_by_id($_GET['id']);
    if($message == NULL || $message ==0) exit("error 2");
    $delete = message_delete($_SESSION['user_info']['u_id'],$_GET['id']);
    if($delete == true ) {header("location: message.php?message=Message Supprimé&link=messages.php?m=read%26type=inbox"); exit();}
    if($delete == NULL) {header("location: message.php?message=error 447&link=messages.php?m=read%26type=inbox"); exit();}
    if($delete == 0) {header("location: message.php?message=error 141&link=messages.php?m=read%26type=inbox"); exit();}
}





?>