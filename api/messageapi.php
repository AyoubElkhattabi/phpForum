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
function message_get($condition=''){
    global $db_handle;
    $query = sprintf("SELECT * FROM messages %s",$condition);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows == 0) return 0;
    $messages = array();
    for($i=0;$i<$num_rows;$i++){
        $messages[$i] = mysqli_fetch_array($query_result);
    }
    mysqli_free_result($query_result);
    return $messages;
}

function message_get_by_id($id){
    global $db_handle;
    $query = sprintf("SELECT * FROM messages WHERE m_id = %s",$id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows==0) return 0;
    $message = mysqli_fetch_array($query_result);
    return $message;
}

function message_send($subject , $text , $from , $to , $parent){

    global $db_handle;
    $query = sprintf("INSERT INTO messages (m_subject , m_text , m_from , m_to , m_parent) VALUES ('%s' , '%s' , %s , %s , %s)",$subject , $text , $from , $to , $parent);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    return true;
}

function message_get_inread_messages_count($u_id){
    global $db_handle;
    $query = sprintf("SELECT COUNT(*) as count FROM messages WHERE m_to = %s AND m_isread=0",$u_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $count = mysqli_fetch_array($query_result);

    return $count['count'];

}

function message_set_message_read($id){
    global $db_handle;
    $query = 'UPDATE messages SET m_isread = 1 WHERE m_id = '.$id;
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    return true;
}

function message_delete($u_id,$m_id){
    global $db_handle;
    $message = message_get_by_id($m_id);
    $query = NULL;
    if($u_id != $message['m_from'] && $u_id != $message['m_to'] ) return 0;
    if($u_id == $message['m_from']) $query=sprintf("UPDATE messages SET m_isdeletedbyowner = 1 WHERE m_id = %s",$m_id);
    if($u_id == $message['m_to'])   $query=sprintf("UPDATE messages SET m_isdeletedbyreceiver = 1 WHERE m_id = %s",$m_id);
    echo $query;
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    return true;
}


?>