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
$db_host      ='localhost';
$db_name      ='forum';
$db_username  ='root';
$db_password  ='';
$db_handle = mysqli_connect( $db_host , $db_username , $db_password , $db_name );

if(!$db_handle){
    mysqli_close($db_handle);
    die('Connection Problem ... ');
}




function db_close(){
    global $db_handle;
    mysqli_close($db_handle);
}

//db_close();
?>