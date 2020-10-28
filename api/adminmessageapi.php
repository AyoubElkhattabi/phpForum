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

function adminmessage_check_exist(){
    global $db_handle;
    $query = sprintf("SELECT * FROM adminmessage");
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows == 0) return 0;
    else return $num_rows;
}

function adminmessage_add($state,$text,$backgroundcolor,$fontcolor){
    global $db_handle;
    $query = sprintf("INSERT INTO adminmessage(state,message,backgroundcolor,fontcolor) VALUES (%s,'%s','%s','%s')",$state,$text,$backgroundcolor,$fontcolor);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    return true;
}

function adminmessage_get(){
    global $db_handle;
    $query = sprintf("SELECT * FROM  adminmessage");
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $message = mysqli_fetch_array($query_result);
    return $message;
}

function adminmessage_update($state,$text,$backgroundcolor,$fontcolor){
    global $db_handle;
    $query = sprintf("UPDATE adminmessage SET state = %s, message = '%s' ,backgroundcolor = '%s',fontcolor = '%s'  ",$state,$text,$backgroundcolor,$fontcolor);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    return true;
}

?>