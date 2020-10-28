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
require_once('./api/db.php');
require_once('./api/usersapi.php');
require_once('./api/catapi.php');
require_once('./api/forumapi.php');
require_once('./api/topicsapi.php');
require_once('./api/commentsapi.php');


function print_array($array){
  echo '<pre>';print_r($array);echo '</pre>';
}
function getRandomImageForUser($uid){
        $userinfo = users_get_by_id($uid);
             $userimg = '';
             $gender = array();
             $gender[0] = 'f-';$gender[1]='m-';
             if($userinfo['u_image']!=NULL){

               $userimg = $userinfo['u_image'];
                
             }else{
               // $userimg = $userinfo['u_image'];
               if($userinfo['u_gender'] ==NULL || trim($userinfo['u_gender'])=='')    $userimg = 'img/avatar/'.$gender[rand(0,1)].rand(1,6).'.png';
                else if ($userinfo['u_gender']==1) $userimg = 'img/avatar/'.$gender[1].rand(1,6).'.png';
                else if ($userinfo['u_gender']==0) $userimg = 'img/avatar/'.$gender[0].rand(1,6).'.png';
             }

             return $userimg;
}
function encode_decode($str,$type){


      
  $ciphering = "BF-CBC"; 
   
  $iv_length = openssl_cipher_iv_length($ciphering); 
  $options = 0;  
  $iv = '1234567891011121'; 
  $key = "OfPpToFpPt"; 

  if($type=='encryption'){
     $encryption = openssl_encrypt($str, $ciphering, $key, $options, $iv); 
     return $encryption;
  }else if($type=='decryption'){

        $decryption=openssl_decrypt ($str, $ciphering, $key, $options, $iv);
        return $decryption;
  }else{
     return 'type false';
  }
     

}
function get_user_role($id){
  $user = users_get_by_id($id);
  if($user['u_role'] == 'mlev1') return 'Membre régulier';
  else if ($user['u_role'] == 'mlev2') return 'Moderator';
  else if($user['u_role'] == 'mlev3') return 'Monitor';
  else if($user['u_role'] == 'admin') return 'Administrateur';
  else{ return 'role note found';}
}
function getAge($then) {
  $then_ts = strtotime($then);
  $then_year = date('Y', $then_ts);
  $age = date('Y') - $then_year;
  if(strtotime('+' . $age . ' years', $then_ts) > time()) $age--;
  return $age;
}
function breadcrumb($page,$id){
  $breadcrumb = '';
  if($page=='home'){
     $breadcrumb = '
     <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page">Home</li>
        </ol>
    </nav>
     
     ';
  }else if ($page=='forum'){
    $forumName = forum_get_name($id);
    $breadcrumb = '
                <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">'.$forumName.'</li>
              </ol>
            </nav>
    
    ';

  }else if($page=='topic'){

    $forumName = forum_get_name_by_topic($id);
    $topicName = topics_get_name_by_id($id);
    $idforum = forum_get_id_by_topic($id);
    $breadcrumb = '
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
      <li class="breadcrumb-item"><a href="forum.php?id='.$idforum.'">'.$forumName.'</a></li>
      <li class="breadcrumb-item active" aria-current="page">'.$topicName.'</li>
    </ol>
  </nav>
    ';

  }



  return $breadcrumb;
}
function can_edite_topic($u_id,$t_id){
    if($u_id!=0){

          // check if user is owner of post
          $topic = topics_get_by_id($t_id);
          //if($topic['t_addBy'])
          if($topic['t_addBy'] == $u_id && $topic['t_isClose']==0 ){return true;}
          // check if user is admin 
          $isAdmin = get_user_role($u_id);
          if($isAdmin=='Administrateur'){return true;} 

          //check if user monitor in categorie of topic
          $monitor = cat_get_monitor_by_topic($t_id);
          if($u_id == $monitor){return true;} 

          //check if user is moderator
          $forum_id = forum_get_id_by_topic($t_id);
          $isModerator = forum_check_if_user_moderator($u_id,$forum_id);
          if($isModerator == true){return true;} 
          

    }
        // if not user owner post or monitor or moderator or admin 
        return false;

}
function can_pin_unpin_topic($u_id,$t_id){

  if($u_id!=0){

    
    // check if user is admin 
    $isAdmin = get_user_role($u_id);
    if($isAdmin=='Administrateur'){return true;} 

    //check if user monitor in categorie of topic
    $monitor = cat_get_monitor_by_topic($t_id);
    if($u_id == $monitor){return true;} 

    //check if user is moderator
    $forum_id = forum_get_id_by_topic($t_id);
    $isModerator = forum_check_if_user_moderator($u_id,$forum_id);
    if($isModerator == true){return true;} 


  }
  // if not user owner post or monitor or moderator or admin 
  return false;

}
function can_hide_show_topic($u_id,$t_id){

  if($u_id!=0){

    
    // check if user is admin 
    $isAdmin = get_user_role($u_id);
    if($isAdmin=='Administrateur'){return true;} 

    //check if user monitor in categorie of topic
    $monitor = cat_get_monitor_by_topic($t_id);
    if($u_id == $monitor){return true;} 

    //check if user is moderator
    $forum_id = forum_get_id_by_topic($t_id);
    $isModerator = forum_check_if_user_moderator($u_id,$forum_id);
    if($isModerator == true){return true;} 

 }
  // if not user owner post or monitor or moderator or admin 
  return false;

}
function can_open_close_topic($u_id,$t_id){

  if($u_id!=0){

    
    // check if user is admin 
    $isAdmin = get_user_role($u_id);
    if($isAdmin=='Administrateur'){return true;} 

    //check if user monitor in categorie of topic
    $monitor = cat_get_monitor_by_topic($t_id);
    if($u_id == $monitor){return true;} 

    //check if user is moderator
    $forum_id = forum_get_id_by_topic($t_id);
    $isModerator = forum_check_if_user_moderator($u_id,$forum_id);
    if($isModerator == true){return true;} 

 }
  // if not user owner post or monitor or moderator or admin 
  return false;

}
function can_delete_topic($u_id,$t_id){

  if($u_id!=0){

    
    // check if user is admin 
    $isAdmin = get_user_role($u_id);
    if($isAdmin=='Administrateur'){return true;} 

  }
  // if not user owner post or monitor or moderator or admin 
  return false;

}
function topic_edite_pin_hide_remove($u_id,$t_id){
            $CanEdite     = can_edite_topic($u_id,$t_id);
            $CanPinUnpin  = can_pin_unpin_topic($u_id,$t_id);
            $CanHideShow  = can_hide_show_topic($u_id,$t_id);
            $CanDelete    = can_delete_topic($u_id,$t_id);
            $CanOpenClose = can_open_close_topic($u_id,$t_id);
            if($CanEdite == true){
               echo '<button class="smallbtnfortopics"><a href="editepost.php?id='.$t_id.'&edite=topic" class="bbt"><i class="fas fa-edit" style="color:green;"></i></a></button>';
            }
            if($CanPinUnpin== true){
               echo '<button class="smallbtnfortopics"><a href="fixpost.php?t_id='.$t_id.'" class="bbt"><i class="fas fa-thumbtack" style="color:teal;"></i></a></button>';
            }
            if($CanHideShow == true){
               echo '<button class="smallbtnfortopics"><a href="hidepost.php?t_id='.$t_id.'" class="bbt"><i class="fas fa-eye-slash" style="color:#8c2be6;"></i></a></button>';
            }
            if($CanOpenClose == true){
              echo '<button class="smallbtnfortopics"><a href="closepost.php?t_id='.$t_id.'" class="bbt"><i class="fas fa-unlock-alt" style="color:black;"></i></a></button>';
            }
            if($CanDelete == true){
                echo '<button class="smallbtnfortopics"><a href="deletepost.php?t_id='.$t_id.'" class="bbt"><i class="fas fa-trash-alt" style="color:red;"></i></a></button>';
            }

}
function can_add_reply($u_id,$t_id){
  $topic = topics_get_by_id($t_id);
  if($topic['t_isClose']==0){return true;}
  else{
    if(can_pin_unpin_topic($u_id,$t_id)==true){return true;} // li ya9dar ydir fix rah y9dar ykoun admin ola moderator ola monitor
  }
  return false;

}
// 3andna 2 can show hodden topic wa7da katkoun fwast topic o lo5ra katkoun f wast l forum 
// can show hidden topic in topic not forum
function can_show_hidden_topic($u_id,$t_id){
  if($u_id!=0){
    
    //check if user allowed to show topic from table 'topics_hidden'
     $isAllowed = topics_check_user_hide_topic_exist($u_id,$t_id);
     if($isAllowed == true) {return true;}
     // check if user is admin 
     $isAdmin = get_user_role($u_id);
     if($isAdmin=='Administrateur'){return true;} 

     //check if user monitor in categorie of topic
     $monitor = cat_get_monitor_by_topic($t_id);
     if($u_id == $monitor){return true;} 

     //check if user is moderator
     $forum_id = forum_get_id_by_topic($t_id);
     $isModerator = forum_check_if_user_moderator($u_id,$forum_id);
     if($isModerator == true){return true;} 
    
  }

  return false;
}
// can show hidden topic in forum
function can_show_hidden_topic_F($u_id,$f_id){
  if($u_id!=0){
    
    //check if user allowed to show topic from table 'topics_hidden'
     $isAllowed = forums_check_if_user_has_hide_topic($f_id,$u_id);
     if($isAllowed == true) {return true;}

     // check if user is admin 
     $isAdmin = get_user_role($u_id);
     if($isAdmin=='Administrateur'){return true;} 

     //check if user monitor in categorie of topic
     $monitor = forum_get_monitor_by_forum($f_id);
     if($u_id == $monitor){return true;} 

     //check if user is moderator
     $isModerator = forum_check_if_user_moderator($u_id,$f_id);
     if($isModerator == true){return true;} 
    
  }

  return false;
}
function check_if_user_hight_level_in_forum($u_id,$f_id){
  if($u_id!=0){
    
     // check if user is admin 
     $isAdmin = get_user_role($u_id);
     if($isAdmin=='Administrateur'){return true;} 

     //check if user monitor in categorie of topic
     $monitor = forum_get_monitor_by_forum($f_id);
     if($u_id == $monitor){return true;} 

     //check if user is moderator
     $isModerator = forum_check_if_user_moderator($u_id,$f_id);
     if($isModerator == true){return true;} 
    
  }

  return false;

}
function can_add_users_to_hidden_topic($u_id,$t_id){
  if($u_id!=0){
    
     // check if user is admin 
     $isAdmin = get_user_role($u_id);
     if($isAdmin=='Administrateur'){return true;} 

     //check if user monitor in categorie of topic
     $monitor = cat_get_monitor_by_topic($t_id);
     if($u_id == $monitor){return true;} 

     //check if user is moderator
     $forum_id = forum_get_id_by_topic($t_id);
     $isModerator = forum_check_if_user_moderator($u_id,$forum_id);
     if($isModerator == true){return true;} 
    
  }

  return false;
}
function string_to_users_array_id($str){// exemple user1,user2,user3 ==> array(73,77,55) return ima array ola 0
  if(trim($str)!=''){
    $users = explode(",",$str);
    
    for($i=0;$i<count($users);$i++){
        $users[$i] = trim($users[$i]);
    }
    // hna radi nkouno 3alajna string o sta5eajna kola user bo7do 

    // daba 5assna ntcheckiw 3la kola user 
    $users_id = array();
    for($i=0;$i<count($users);$i++){
      $user = users_get_by_username($users[$i]);
      if($user!=0 && $user!=NULL) {$users_id[$i] = $user['u_id'];}
      else{$users_id[$i] = 0;}
    } 
    // daba rah jbadna ga3 les id li 3andna  mais fi7alat mal9ach luser kay7at f blassto 0 idan 5assni nm7i les champs li fihom valeur 0
    for($i=0;$i<count($users_id);$i++){
      if($users_id[$i] == 0) unset($users_id[$i]);
    }
    if(count($users_id)==0) return 0;

    // 5ASSNI n9alab wach user bra yda5al rasso o nman3o   /*mn ba3d */
    
      return array_unique($users_id); // array_unique kat7ayad lina les valeur li m3awdin ktar mn mara kat5ali ri wa7da
  }

  return 0;
}
function user_can_control_user($u_id1,$u_id2){ //1:li bra yt7akam /2: li bra yt7akam fih
            $RoleForUser    = get_user_role($u_id1);
            $RoleForProfile = get_user_role($u_id2);
            if($RoleForUser==$RoleForProfile){ 
                return false;
            }else if($RoleForUser == 'Administrateur'){
              return  true;
            }else if($RoleForUser =='Monitor' && $RoleForProfile!='Administrateur' ){
              return  true;
            }/*else if($RoleForUser =='Moderator' && $RoleForProfile=='Membre régulier'){
              return  true;
            }*/else{
              return  false;
            }

}

function can_edite_delete_reply($r_id){
  global $u_id;
  if($u_id !=0){
    $reply = comments_get_by_id($r_id);
    $forumid = forum_get_id_by_topic($reply['t_id']);
    // check if user is post owner 
    if(($_SESSION['user_info']['u_id'] == $reply['u_id'])) return true;
   
    // check if user is admin
    $isAdmin = get_user_role($u_id);
    if($isAdmin=='Administrateur'){return true;} 
  
    //check if user monitor in categorie of topic
    // get monitor by topic 
    
    $monitor = forum_get_monitor_by_forum($forumid);
    if($u_id == $monitor){return true;} 
  
    //check if user is moderator
    $isModerator = forum_check_if_user_moderator($u_id,$forumid);
    if($isModerator == true){return true;} 
  }

  return false;
  
}

function can_update_delete_reply($r_id){

   $can = can_edite_delete_reply($r_id);
    if($can==true){
        echo '<button class="smallbtnfortopics"><a href="editepost.php?id='.$r_id.'&edite=reply" class="bbt"><i class="fas fa-edit" style="color:green;"></i></a></button>';
        echo '<button class="smallbtnfortopics"><a href="deletereply.php?r_id='.$r_id.'" class="bbt"><i class="fas fa-trash-alt" style="color:red;"></i></a></button>';
      }

}




?>