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

if(!isset($_POST['username']) || !isset($_POST['password']) ||!isset($_POST['repassword']) || !isset($_POST['email']) ){
    die('Bad Access');
}



/*check if username and email if exists*/
$error_message = '';
$userexists  = users_get_by_username($_POST['username']);
if($userexists == 0) echo 'makaynch had username'; else echo'username kyn';
$emailexists = users_get_by_email($_POST['email']);
if($emailexists == 0) echo 'makaynch had email'; else echo'email kyn';


?>