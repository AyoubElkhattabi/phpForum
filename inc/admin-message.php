 
 
  <!-- START Admin Message -->

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

  $msgexist = adminmessage_check_exist();
  
  if($msgexist!=NULL && $msgexist!=0 ){
    $msg= adminmessage_get();
        if($msg['state']!=0){

            echo '
            <div class="index-message" style="color: '.$msg['fontcolor'].';background-color: '.$msg['backgroundcolor'].';">'.$msg['message'].'</div>
            ';
        }
}
  
  ?>
  
 <!-- END  Admin Message -->