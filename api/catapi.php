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
function cat_add($status,$name,$description,$order='100',$monitor='0'){

    global $db_handle;
    $query = sprintf("INSERT INTO categories (cat_status,cat_name,cat_description,cat_order,cat_monitor) VALUES (%s,'%s','%s',%s,%d)",$status,$name,$description,$order,$monitor);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return false;
    return true;

}
function cat_get($condition=''){

    global $db_handle;
    $query = sprintf("SELECT * FROM CATEGORIES %s",$condition);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows == 0) return 0;
    $cat = array();
    for($i=0;$i<$num_rows;$i++){
        $cat[$i] = mysqli_fetch_array($query_result);
    }
    mysqli_free_result($query_result);
    return $cat;

}
function cat_delete($id){

    global $db_handle;
    $query = sprintf("DELETE FROM categories WHERE cat_id = %s",$id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return false;
    return true;

}
function cat_get_by_id($id){
    global $db_handle;
    $query = sprintf("SELECT * FROM categories WHERE cat_id = %s",$id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return false;
    $cat = mysqli_fetch_array($query_result);
    return $cat;
}
function cat_update($id,$status,$name,$description,$order,$monitor){
    global $db_handle;
    $query = sprintf("UPDATE categories SET cat_status = %s , cat_name = '%s' , cat_description = '%s',cat_order = %s, cat_monitor = %s WHERE cat_id = %s",$status,$name,$description,$order,$monitor,$id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return false;
    return true;

}
function cat_add_monitor($u_id,$cat_id){

    global $db_handle;
    $query = sprintf("UPDATE categories SET cat_monitor = %s WHERE cat_id = %s",$u_id,$cat_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    return true;

}
function cat_delete_monitor($cat_id){
    global $db_handle;
    $query = sprintf("UPDATE categories SET cat_monitor = NULL WHERE cat_id = %s",$cat_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    return true;
}
function cat_get_monitor_id($id){
    global $db_handle;
    $query = sprintf("SELECT cat_monitor FROM categories  WHERE cat_id = %s",$id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows==0) return 0;
    $monitor = mysqli_fetch_array($query_result);
    return $monitor[0];    
}
function cat_get_monitor_count_cat($u_id){ // hadi katraja3 lina 3adad diyal les categories li fihom l uer monitor
    global $db_handle;
    $query = sprintf("SELECT COUNT(*) as 'count' from categories where cat_monitor = %s",$u_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows==0) return 0;
    $count = mysqli_fetch_array($query_result);
    return $count['count'];

}

function cat_get_monitor_by_topic($id){
    global $db_handle;
    $query = sprintf("SELECT c.cat_monitor as 'id' FROM topics t INNER JOIN forums f ON f.f_id = t.f_id INNER JOIN categories c ON c.cat_id = f.cat_id WHERE t.t_id=%s",$id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows==0) return 0;
    $monitorId = mysqli_fetch_array($query_result);
    return $monitorId['id'];    
}



?>