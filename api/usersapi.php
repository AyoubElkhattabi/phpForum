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
function users_get($condition=''){
    global $db_handle;
    $query = sprintf("SELECT * FROM USERS %s",$condition);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows == 0) return "there is no users ";
    $users = array();
    for($i=0;$i<$num_rows;$i++){
        $users[$i] = mysqli_fetch_array($query_result);
    }
    mysqli_free_result($query_result);
    return $users;
}
function users_get_count(){
    global $db_handle;
    $query = sprintf("SELECT COUNT(*) as count FROM USERS");
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows==0) return 0; 
    $count = mysqli_fetch_array($query_result);
    return $count['count'];
}
function users_get_count_pagination($records){
    $page_count = (int) ceil(users_get_count()/$records);
    return $page_count;
}
function users_get_by_page($records,$page){
    global $db_handle;
    $num_rows = users_get_count();
    
    if($num_rows > 0){
        $page_count = (int) ceil($num_rows/$records);
        $start = ($page-1)*$records;
        $end   = $records;
        $query=sprintf("SELECT * FROM users ORDER BY u_id desc LIMIT %s,%s ",$start,$end);
        $query_result = mysqli_query($db_handle,$query);
        $numberOfPosts = mysqli_num_rows($query_result);
        $users = array();
        for($i=0;$i<$numberOfPosts;$i++){
            $users[$i] = mysqli_fetch_array($query_result);
        }
        return $users;
    }
     
    return NULL;
}
function users_get_by_id($id){

    global $db_handle;
    $query = sprintf("SELECT * FROM USERS WHERE u_id = %d",$id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows==0) return 0; 
    $user = mysqli_fetch_array($query_result);
    return $user;
}
function users_get_by_username($username){ // null sql error / 0 not found / array found

    global $db_handle;
    $query = sprintf("SELECT * FROM USERS WHERE u_username = '%s'",$username);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows==0) return 0; 
    $user = mysqli_fetch_array($query_result);
    return $user;
}
function users_get_by_email($email){
    global $db_handle;
    $query = sprintf("SELECT * FROM USERS WHERE u_email = '%s'",$email);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows==0) return 0; 
    $user = mysqli_fetch_array($query_result);
    return $user;
}
function users_add($username,$password,$email){  // return true if add or false if not  
    global $db_handle;
    $query = sprintf("INSERT INTO USERS (u_username,u_password,u_email) VALUE ('%s','%s','%s')",$username,$password,$email);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return false;
    return true;
}
function users_get_id_using_usernamepassword($username,$password){
    global $db_handle;
    $query = sprintf("SELECT u_id FROM USERS WHERE u_username = '%s' AND u_password = '%s'",$username,$password);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows==0) return 0; 
    $user = mysqli_fetch_array($query_result);
    return $user['u_id'];
}
function users_add_username_to_history($u_id , $username ){
    global $db_handle;
    $query = sprintf("INSERT INTO username_history (u_id,username) VALUE ('%s','%s')",$u_id,$username);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return false;
    return true;
}
function users_updateinfo($id,$country=NULL,$city=NULL,$birthDay=NULL,$realName=NULL,$marStatus=NULL,$gender=NULL,$image=NULL,$bio=NULL){


    global $db_handle;
    $query = 'UPDATE USERS SET ';
    $fields = array();
    if($country!=NULL)   $fields[@count($fields)]  = "u_country = '$country',";
    if($city!=NULL)      $fields[@count($fields)]  = "u_city = '$city',";
    if($birthDay!=NULL)  $fields[@count($fields)]  = "u_birthDay = '$birthDay',";
    if($realName!=NULL)  $fields[@count($fields)]  = "u_realName = '$realName',";
    if($marStatus!=NULL) $fields[@count($fields)]  = "u_marStatus = '$marStatus',";
    if($gender!=NULL)    $fields[@count($fields)]  = "u_gender = $gender,";
    if($image!=NULL)     $fields[@count($fields)]  = "u_image = '$image',";
    if($bio!=NULL)       $fields[@count($fields)]  = "u_bio = '$bio',";

    for($x=0;$x<count($fields);$x++){
        $query .= $fields[$x];
        
    }

    $query = rtrim($query, ",");
    $query .= ' WHERE u_id = '.$id;
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    return true;


}
function users_delete($id){
    global $db_handle;
    $query = sprintf("DELETE FROM USERS WHERE u_id = %d",$id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL ;
    return true;
}
function users_get_topics_number($id){

    global $db_handle;
    $query = sprintf("SELECT COUNT(*) as 'count' from topics where t_addBy  = %s",$id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result); 
    $user = mysqli_fetch_array($query_result);
    return $user['count'];
}
function users_get_comments_number($id){

    global $db_handle;
    $query = sprintf("SELECT COUNT(*) as 'count' from replays where u_id  = %s",$id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result); 
    $user = mysqli_fetch_array($query_result);
    return $user['count'];
}
function users_get_admins(){
    global $db_handle;
    $query = "SELECT * FROM users WHERE u_role = 'admin' ";
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows==0) return 0;
    $admins = array();
    for($i=0;$i<$num_rows;$i++){
        $admins[$i] = mysqli_fetch_array($query_result);
    }
    return $admins;
}
function users_add_new_role($role,$id){
    global $db_handle;
    $query = sprintf("UPDATE users SET u_role = '%s' WHERE u_id = %s",$role,$id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    return true;
}
function users_get_date_last_post($u_id){
    global $db_handle;
    $query = sprintf("SELECT t_createAt FROM topics WHERE t_addBy = %s  ORDER BY t_id DESC LIMIT 1 ",$u_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows==0) return NULL;
    $date = mysqli_fetch_array($query_result);
    return $date['t_createAt'];
}
function users_get_date_last_comment($u_id){
    global $db_handle;
    $query = sprintf("SELECT r_date FROM replays WHERE u_id  = %s  ORDER BY r_id DESC LIMIT 1 ",$u_id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows==0) return NULL;
    $date = mysqli_fetch_array($query_result);
    return $date['r_date'];
}
function users_ban_user($u_id , $bannedBy , $banreason){
    global $db_handle;
    $query = sprintf("UPDATE users SET u_isBanned = 1 , u_bannedBy = %s , u_banDate = NOW() ,  u_banReason = '%s' WHERE u_id = %s",$bannedBy , $banreason,$u_id );
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    return true;
}
function users_unban_users($u_id , $unbannedBy){
    global $db_handle;
    $query = sprintf("UPDATE users SET u_isBanned = 0 , u_bannedBy = %s , u_banDate = NOW()  WHERE u_id = %s",$unbannedBy , $u_id );
    $query_result = mysqli_query($db_handle,$query);
    
    if(!$query_result) return NULL;
    return true;
}
function users_get_uid_by_username_from_history($username){
    global $db_handle;
    $query = sprintf("SELECT * FROM username_history WHERE username = '%s'",$username);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows == 0) return 0; // ya3ni had username 3amro tasta3mal
    $usernamehistory = mysqli_fetch_array($query_result);
    return $usernamehistory;
}
function users_update_username($u_id , $username){

    $user_history = users_get_uid_by_username_from_history($username);
    if(is_null($user_history)) return NULL; 

    $helper = gettype($user_history);
    if($helper == 'integer') $helperx = true;
    else if($helper == 'array' && $user_history['u_id'] == $u_id) $helperx = true;
    if($helperx == true){
       global $db_handle;
       $query = sprintf("UPDATE USERS SET u_username = '%s' WHERE u_id = %s",$username,$u_id);
       $query_result = mysqli_query($db_handle,$query);
       if(!$query_result) return NULL;
        // cond
        if($helper == 'integer') users_add_username_to_history($u_id , $username);
       return true;  
    }

    return false;
}
function users_update_password($u_id , $password){
    global $db_handle;
    $query = sprintf("UPDATE users set u_password = '%s' WHERE u_id = %s",$password,$u_id );
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    return true;
}
function users_check_if_email_exist($email){ // if is exist return id of user else return 0
    global $db_handle;
    $query = sprintf("SELECT * FROM users WHERE u_email = '%s'",$email);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows==0) return 0;
    $user = mysqli_fetch_array($query_result);
    return $user['u_id'];
}
function users_update_email($u_id , $email){
    $isexist = users_check_if_email_exist($email);
    if($isexist!=NULL && $isexist!=0) return false;
    global $db_handle;
    $query = sprintf("UPDATE users set u_email = '%s' WHERE u_id = %s",$email,$u_id );
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    return true;

}
function users_get_username_by_id($id){

    global $db_handle;
    $query = sprintf('SELECT u_username from users where u_id = %s',$id);
    $query_result = mysqli_query($db_handle,$query);
    if(!$query_result) return NULL;
    $num_rows = mysqli_num_rows($query_result);
    if($num_rows == 0 ) return 0;
    $username = mysqli_fetch_array($query_result);
    return $username['u_username'];
}
?>