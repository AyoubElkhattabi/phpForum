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

function topics_get($condition=''){
    global $db_handle;
    $query =sprintf("SELECT * FROM topics %s",$condition);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows == 0) return 0;
    $topics = array();
    for($i=0;$i<$num_rows;$i++){
        $topics[$i] = mysqli_fetch_array($query_result);
    }
    return $topics;
}
function topics_get_count_fixed($idforum){
    global $db_handle;
    $query = sprintf("SELECT * FROM TOPICS WHERE  f_id = %s AND t_isFixed = 1 AND t_isHidden = 0",$idforum);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return 0;
    return  mysqli_num_rows($query_result);
}
function topics_get_fixed($idforum){
    global $db_handle;
    $num_rows = topics_get_count_fixed($idforum);
    if($num_rows > 0){
        $query=sprintf("SELECT * FROM TOPICS WHERE  f_id = %s AND t_isFixed = 1 AND t_isHidden = 0",$idforum);
        $query_result = mysqli_query($db_handle,$query);
        $topics = array();
        for($i=0;$i<$num_rows;$i++){
            $topics[$i] = mysqli_fetch_array($query_result);
        }
        return $topics;
    }
     
    return NULL;
}
function topics_get_count_normal($idforum){
    global $db_handle;
    $query = sprintf("SELECT * FROM TOPICS WHERE  f_id = %s AND t_isFixed = 0 AND t_isHidden = 0",$idforum);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return 0;
    return  mysqli_num_rows($query_result);
}
// hadi radi y5assha pagination mais machi daba apres
// order desc
function topics_get_normal($idforum){
    global $db_handle;
    $num_rows = topics_get_count_normal($idforum);
    if($num_rows > 0){
        $query=sprintf("SELECT * FROM TOPICS WHERE  f_id = %s AND t_isFixed = 0 AND t_isHidden = 0 ORDER BY t_id desc",$idforum);
        $query_result = mysqli_query($db_handle,$query);
        $topics = array();
        for($i=0;$i<$num_rows;$i++){
            $topics[$i] = mysqli_fetch_array($query_result);
        }
        return $topics;
    }
     
    return NULL;
}
function topics_pagination_get_numbers($idforum,$records){
    global $db_handle;
    $num_rows = topics_get_count_normal($idforum);
    $page_count = (int) ceil($num_rows/$records);
    return $page_count;
}
function topics_get_by_page($idforum,$page,$records){
    global $db_handle;
    $num_rows = topics_get_count_normal($idforum);
    
    if($num_rows > 0){
        $page_count = (int) ceil($num_rows/$records);
        $start = ($page-1)*$records;
        $end   = $records;
        $query=sprintf("SELECT * FROM TOPICS WHERE  f_id = %s AND t_isFixed = 0 AND t_isHidden = 0 ORDER BY t_id desc LIMIT %s,%s ",$idforum,$start,$end);
        $query_result = mysqli_query($db_handle,$query);
        $numberOfPosts = mysqli_num_rows($query_result);
        $topics = array();
        for($i=0;$i<$numberOfPosts;$i++){
            $topics[$i] = mysqli_fetch_array($query_result);
        }
        return $topics;
    }
     
    return NULL;
}
function topics_add($t_status  , $t_subject , $t_text , $t_addBy , $f_id ){
    global $db_handle;
    $query = sprintf("INSERT INTO topics (t_status , t_subject , t_text ,  t_addBy , f_id) VALUE (%s,'%s','%s',%s,%s)",$t_status  , $t_subject , $t_text , $t_addBy , $f_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return false;
    return true;
}
function topics_delete($id){
    global $db_handle;
    $query = sprintf("DELETE FROM topics WHERE t_id = %s",$id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return false;
    return true;
}
function topics_get_by_id($id){
    global $db_handle;
    $query = sprintf("SELECT * FROM topics WHERE t_id = %s",$id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows==0) return 0;
    $topic = mysqli_fetch_array($query_result);
    return $topic;

}
function topics_get_name_by_id($id){
    global $db_handle;
    $query = sprintf("SELECT t_subject FROM topics t WHERE t_id = %s",$id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $name = mysqli_fetch_array($query_result);
    return $name[0];
}
function topics_views_increment($p_id){
    global $db_handle;
    $query = sprintf("UPDATE topics SET t_views = (t_views+1) where t_id = %s",$p_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    return false;
}
function topics_fix($u_id,$t_id){
    global $db_handle;
    $query = sprintf("UPDATE topics SET t_isFixed = 1 , t_fixedBy = %s , t_fixedDate = NOW() where t_id = %s ",$u_id,$t_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    return true;

}
function topics_unfix($t_id){
    global $db_handle;
    $query = sprintf("UPDATE topics SET t_isFixed = 0  WHERE t_id = %s ",$t_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    return true;
}
function topics_update($t_subject,$t_text,$t_id){
    global $db_handle;
    $query = sprintf("UPDATE topics SET t_subject = '%s' ,t_text = '%s' WHERE  t_id = %s",$t_subject,$t_text,$t_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    return true;
}
function topics_close($u_id,$t_id){
    global $db_handle;
    $query = sprintf("UPDATE topics SET t_isClose = 1 , t_closeBy = %s , t_closeDate = NOW() where t_id = %s ",$u_id,$t_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    return true;

}
function topics_open($t_id){
    global $db_handle;
    $query = sprintf("UPDATE topics SET t_isClose = 0  WHERE t_id = %s ",$t_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    return true;
}
//////////////////////

function topics_hide($u_id,$t_id){
    global $db_handle;
    $query = sprintf("UPDATE topics SET t_isHidden = 1 , t_hideBy  = %s ,  t_hiddenDate = NOW() where t_id = %s ",$u_id,$t_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    return true;
}
function topics_show($t_id){
    global $db_handle;
    $query = sprintf("UPDATE topics SET t_isHidden = 0  WHERE t_id = %s ",$t_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    return true;
}
function topics_check_user_hide_topic_exist($u_id , $t_id){
    global $db_handle;
    $query = sprintf("SELECT * FROM topics_hidden WHERE u_id = %s AND t_id = %s",$u_id , $t_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows == 0) return false;
    return true;
}
function topics_add_user_to_hide_topic($u_id , $t_id , $addedby){ 
    $isexist = topics_check_user_hide_topic_exist($u_id , $t_id);
    if($isexist == true) return false;
    global $db_handle;
    $query = sprintf("INSERT INTO topics_hidden(u_id , t_id , addedby) VALUES (%s,%s,%s)",$u_id , $t_id, $addedby);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    return true;
}
function topics_add_multiple_users_to_hide_topic($users,$t_id,$addedby){
    if(!empty($users)){
        foreach($users as $u_id){
            $isexist = topics_check_user_hide_topic_exist($u_id , $t_id);
            if($isexist==false){$x=topics_add_user_to_hide_topic($u_id , $t_id , $addedby);} 
        }
        return true;
    }else{
        return false;
    }

}
function topics_remove_user_from_hide_topic($u_id , $t_id){
    $isexist = topics_check_user_hide_topic_exist($u_id , $t_id);
    if($isexist != true) return false;
    global $db_handle;
    $query = sprintf("DELETE FROM topics_hidden WHERE u_id = %s AND t_id = %s",$u_id , $t_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    return true;
}
function topics_remove_all_user_from_hide_topic($u_id , $t_id){
    global $db_handle;
    $query = sprintf("DELETE FROM topics_hidden WHERE t_id = %s",$t_id);
    $query_result = mysqli_query($db_handle,$query_result);
    if(!$query_result) return NULL;
    return true;
}
function topics_get_hide($idforum){
    global $db_handle;
        $query=sprintf("SELECT * FROM TOPICS WHERE  f_id = %s AND  t_isHidden = 1 ORDER BY t_id desc",$idforum);
        $query_result = mysqli_query($db_handle,$query);
        if(!$query_result) return NULL;
        $num_rows = mysqli_num_rows($query_result);
        if($num_rows == 0) return NULL;
        $topics = array();
        for($i=0;$i<$num_rows;$i++){
            $topics[$i] = mysqli_fetch_array($query_result);
        }
        return $topics;
}
function topics_get_count_hide($idforum){
    global $db_handle;
    $query = sprintf("SELECT * FROM TOPICS WHERE  f_id = %s AND t_isHidden = 1",$idforum);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return 0;
    return  mysqli_num_rows($query_result);
}
function topics_get_hide_topic_for_mlv1($u_id,$f_id){
    global $db_handle;
    $query = sprintf("SELECT t.* FROM topics_hidden h INNER JOIN topics t on h.t_id = t.t_id INNER JOIN forums f on f.f_id = t.f_id WHERE h.u_id = %s AND f.f_id = %s AND t.t_isHidden =1",$u_id,$f_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows==0) return false;
    $hiddenTopics = array();
    for($i=0;$i<$num_rows;$i++){
        $hiddenTopics[$i] = mysqli_fetch_array($query_result);
    }
    return $hiddenTopics;

}
function topics_get_users_who_can_see_hidden_topic($t_id){
    global $db_handle;
    $query = sprintf("SELECT * FROM topics_hidden where t_id = %s",$t_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows==0) return 0;
    $row = array();
    for($i=0;$i<$num_rows;$i++){
        $row[$i] = mysqli_fetch_array($query_result);
    }
    return $row;
}
function topics_get_last_5_topics($u_id){
    global $db_handle;
    $query = sprintf('SELECT * FROM topics WHERE t_addBy = %s AND t_isHidden =0 ORDER BY t_id DESC LIMIT 5',$u_id);
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





?>