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
function comments_add($r_text, $u_id, $t_id){
    global $db_handle;
    $query = sprintf("INSERT INTO replays(r_text,u_id,t_id) VALUES ('%s',%s,%s)",$r_text,$u_id,$t_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    return true;

}
function comments_count($id){
    global $db_handle;
    $query = sprintf("SELECT COUNT(*)  as count FROM replays WHERE t_id = %s",$id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $count = mysqli_fetch_array($query_result);
    return $count[0];
}
function comments_get_Last($tid){
    global $db_handle;
    $query = sprintf("SELECT * FROM replays WHERE t_id = %s ORDER BY r_id DESC LIMIT 1;",$tid);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $comment = mysqli_fetch_array($query_result);
    return $comment;
}
function comments_get_by_post($id){
    global $db_handle;
    $query = sprintf("SELECT * FROM replays WHERE t_id = %s ORDER BY r_id ASC",$id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows==0) return 0;
    $comments=array();

  
    for($i=0;$i<$num_rows;$i++){
       $comments[$i] = mysqli_fetch_array($query_result); 
    }
    
    return $comments;    
}
function comments_get_by_id($r_id){
    global $db_handle;
    $query = sprintf("SELECT * FROM replays WHERE r_id = %s ",$r_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows=mysqli_num_rows($query_result);
    if($num_rows==0) return 0;
    $comment = mysqli_fetch_array($query_result);
    return $comment;

}
function comments_get_last_5_Post_comments($u_id){
    global $db_handle;
    $query = sprintf('SELECT r.r_id as replayid , t.*  FROM replays r INNER JOIN topics t on r.t_id = t.t_id WHERE r.u_id = %s AND t.t_isHidden = 0 ORDER BY r_id DESC LIMIT 5 ',$u_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows==0) return NULL;
    $topics = array();
    for($i=0;$i<$num_rows;$i++){
        $topics[$i] = mysqli_fetch_array($query_result);
    }
    return $topics;
}
function comments_delete($id){
    global $db_handle;
    $query = sprintf("DELETE FROM replays WHERE r_id = %s",$id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return false;
    return true;
}

function comments_update($r_id , $r_text){
    global $db_handle;
    $query = sprintf("UPDATE replays SET r_text  = '%s' WHERE  r_id = %s",$r_text,$r_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    return true;
}
?>