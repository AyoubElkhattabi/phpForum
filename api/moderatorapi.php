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
function moderator_get_by_forum($id){

    global $db_handle;
    $query = sprintf("SELECT u_id FROM moderators WHERE f_id = %s",$id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows==0) return 0; 
    $moderators = array();
    for($i=0;$i<$num_rows;$i++){
        $moderators[$i] = mysqli_fetch_array($query_result);
    }
    
    return $moderators;
}
function moderator_Exist_in_forum($u_id,$f_id){
    global $db_handle;
    $query = sprintf("SELECT * FROM moderators WHERE u_id = %s AND f_id = %s",$u_id,$f_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows==0) return false;
    return true;

}
function moderator_Exist($u_id){
    global $db_handle;
    $query = sprintf("SELECT * FROM moderators WHERE u_id = %s",$u_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows==0) return false;
    return true;

}
function moderator_add($u_id,$f_id){
    global $db_handle;
    $query = sprintf("INSERT INTO moderators (u_id , f_id) VALUES (%s , %s)",$u_id,$f_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    return true;
}
function moderator_delete($u_id,$f_id){
    global $db_handle;
    $query = sprintf("DELETE FROM moderators WHERE  u_id = %s AND f_id = %s",$u_id,$f_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    return true;
}
function moderator_number_forum_count($u_id){ // hadi kata3tina ch7al mn forum mochrif fih l user
    global $db_handle;
    $query = sprintf("SELECT COUNT(*) as 'count' from moderators where u_id = %s",$u_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows==0) return 0;
    $count = mysqli_fetch_array($query_result);
    return $count['count'];

}
function forum_check_if_user_moderator($u_id,$f_id){
    global $db_handle;
    $query = sprintf("SELECT u_id  FROM moderators  WHERE f_id = %s",$f_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows==0) return false;
    for($i=0;$i<$num_rows;$i++){
        $res = mysqli_fetch_array($query_result);
        if($res['u_id'] == $u_id) return true;  
    }
    return false;
}







?>