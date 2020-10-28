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
function forums_get($condition=''){

    global $db_handle;
    $query = sprintf("SELECT * FROM forums %s",$condition);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows == 0) return 0;
    $forums = array();
    for($i=0;$i<$num_rows;$i++){
        $forums[$i] = mysqli_fetch_array($query_result);
    }
    mysqli_free_result($query_result);
    return $forums;

}
function forums_get_by_id($id){
    global $db_handle;
    $query= sprintf("SELECT * FROM forums WHERE f_id = %s",$id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return false;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows == 0) return false;
    $result = mysqli_fetch_array($query_result);
    return $result;
}
function forums_get_posts_number($idforum){
    global $db_handle;
    $query = sprintf("SELECT COUNT(*) FROM `topics` WHERE f_id = %d ",$idforum);
    $query_result = mysqli_query($db_handle,$query);
    $result = mysqli_fetch_array($query_result );
    return $result[0];
}
function forum_get_comments_number($idforum){
    global $db_handle;
    $query = sprintf("SELECT COUNT(*) FROM replays r INNER JOIN topics t on r.t_id = t.t_id INNER JOIN forums f on f.f_id = t.f_id  WHERE f.f_id =%d",$idforum);
    $query_result = mysqli_query($db_handle,$query);
    $result = mysqli_fetch_array($query_result );
    return $result[0];
}
function forum_get_last_post($idforum){ //return  just t.t_id , t.t_createat , t.t_subject , t.t_addby
    global $db_handle;
    $query = sprintf("SELECT t.t_id , t.t_createat , t.t_subject , t.t_addby FROM topics t WHERE t.t_ishidden = 0 AND t.f_id = %s ORDER BY t.t_id DESC LIMIT 1 ",$idforum);
  //  $query = sprintf("SELECT t.t_id , t.t_createat , t.t_subject , t.t_addby FROM topics t INNER JOIN forums f on t.f_id = f.f_id  where t.t_ishidden = 0 and f.f_id = %d",$idforum);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows==0) return 0;
    $lastpost = mysqli_fetch_array($query_result);
    return $lastpost;

}
function forums_add($status , $title , $description , $order , $image='' , $catid){
    global $db_handle;
    $query = sprintf("INSERT INTO forums (f_status , f_title , f_description , f_order , f_image , cat_id) VALUES (%s,'%s','%s',%s,'%s',%s)",$status , $title , $description , $order , $image , $catid);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return false;
    return true;

}
function forums_get_by_cat_id($id){

    global $db_handle;
    $query = sprintf("SELECT * FROM forums WHERE cat_id = %s",$id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows == 0) return 0;
    $forums = array();
    for($i=0;$i<$num_rows;$i++){
        $forums[$i] = mysqli_fetch_array($query_result);
    }
    mysqli_free_result($query_result);
    return $forums;
}
function forums_delete($id){
    global $db_handle;
    $query = sprintf("DELETE FROM forums WHERE f_id = %s",$id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return false;
    return true;
}
function forums_update($id , $status , $title , $description , $order , $image='' , $catid){
    global $db_handle;
    $query = sprintf("UPDATE forums SET f_status = %s , f_title = '%s' , f_description = '%s' , f_order = %s , f_image = '%s' , cat_id = %s WHERE f_id = %s",$status,$title,$description,$order,$image,$catid,$id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return false;
    return true;
}
function forum_get_name($id){
    global $db_handle;
    $query = sprintf("SELECT f_title  FROM forums WHERE f_id = %s",$id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $title = mysqli_fetch_array($query_result);
    return $title[0];
}
function forum_get_description($id){
    global $db_handle;
    $query = sprintf("SELECT f_description  FROM forums WHERE f_id = %s",$id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $description = mysqli_fetch_array($query_result);
    return $description[0];
}
function forum_get_name_by_topic($id){
    global $db_handle;
    $query = sprintf("SELECT f.f_title FROM forums f INNER JOIN topics t ON  t.f_id = f.f_id WHERE t_id = %s",$id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $name = mysqli_fetch_array($query_result);
    return $name[0];
}
function forum_get_id_by_topic($id){
    global $db_handle;
    $query = sprintf("SELECT f_id  FROM topics  WHERE t_id = %s",$id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $id = mysqli_fetch_array($query_result);
    return $id[0];
}
function forum_get_monitor_by_forum($f_id){
    global $db_handle;
    $query = sprintf("SELECT c.cat_monitor as 'id' FROM  forums f  INNER JOIN categories c ON c.cat_id = f.cat_id WHERE f.f_id=%s",$f_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows==0) return 0;
    $monitorId = mysqli_fetch_array($query_result);
    return $monitorId['id'];    
}
function forums_check_if_user_has_hide_topic($f_id,$u_id){ // hadi kata3tina wach l user 3ando chi mawadi3 m5fiya f lforum
    global $db_handle;
    $query = sprintf("SELECT count(*) as 'count' FROM topics_hidden h INNER JOIN topics t on h.t_id = t.t_id INNER JOIN forums f on f.f_id = t.f_id WHERE f.f_id = %s AND h.u_id=%s",$f_id,$u_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $count = mysqli_fetch_array($query_result);
    if($count['count']==0) return false;
    return true;
    
}

?>