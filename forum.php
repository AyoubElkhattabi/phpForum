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
require_once('session.php'); 
require_once('inc/top-header.php');

require_once('inc/top-header.php');
require_once('inc/top-header.php');

?>



    <title><?php echo forum_get_name($_GET['id']);?></title>
  
    <?php require_once('inc/header.php'); ?>

<!--START CONTENT-->
<div class="content container-fluid">

  <?php require_once('inc/admin-message.php');?>






 <!--START CATEGORIE AND FORUMS-->
 <!--START forum-->

 <div class="forumpage">
<h2 class="title-forum"><?php echo forum_get_name($_GET['id']); ?></h2>
<div class="discription"><span><?php echo forum_get_description($_GET['id']);?> </span></div>

<div class="bread_crumb"> 
<?php echo breadcrumb('forum',$_GET['id']); ?>
</div>

<!--add new topic box-->
<div class="crud"><a href="newpost.php?id=<?php echo $_GET['id'];?>"><i class="fas fa-folder-plus"></i> Nouveau Sujet </a></div></div>
<!--end add new topic box-->

<div class="forum-main-forum">

<!----------------------------------------------hidden topics------------------------------------------------->
<!-- hidden topics-->


<?php
// awal 7aja 5assni nt2akad wach l forum fih mawadi3 m5fiya
$hideTopicscount = topics_get_count_hide($_GET['id']);
if($hideTopicscount!=0 && (!isset($_GET['page']) || $_GET['page']==1)){ // 5ass ykono 3andna mawadi3 m5fiya o nkono f page ola (pagination) =1
                        $canShowHiddenTopics = can_show_hidden_topic_F($u_id,$_GET['id']); // hna kan3arfo ana user 3ando l7a9 ychouf mawadi3 ma5fiya
                        $hidetopics;
                        if($canShowHiddenTopics == true){
                        
                        // hna radi y5assni nt2akad wach user mlv1 ola mlv2 ola mlv 3 ola user
                        $isHighLevelRole = check_if_user_hight_level_in_forum($u_id,$_GET['id']);
                        if($isHighLevelRole == true){
                            $hidetopics = topics_get_hide($_GET['id']);
                        }
                        //mn ba3d ma t2akat mn anaho l user hight level fi 7alat makanch  idan rah user 3adi 5assni njbad lih lmawadi diyalo li m5abyiin
                        else{
                        
                            //hadi radi njabdo biha rir les topic li m5fiyin o taybano fa9at lluser li da5alna
                        $hidetopics = topics_get_hide_topic_for_mlv1($u_id,$_GET['id']);
                         
                        }
                        echo'
                        <!--posts fixed-->
                        <div class="fixed-topics">
                                <div class="scStickyThreads"> <i class="fas fa-thumbtack"></i> SUJETS Caché</div>
                            
                        <div class="forum-topic-fixed" style="background: #b2d1e8;">
                        <!--one post-->
                        
                        ';
                        
                        
                        
                          
                            foreach($hidetopics as $topic ){
                        
                                    // get info of user 
                                    $userinfo = users_get_by_id($topic['t_addBy']);
                                    // get count replys
                                    $commentsCount = comments_count($topic['t_id']);
                                    // get image 
                                    $userimg = getRandomImageForUser($userinfo['u_id']);
                                    // get info user last comment on post
                                    
                                    $lastComment = comments_get_Last($topic['t_id']);
                                    if($lastComment!=NULL){
                                        $lastUserComment = users_get_by_id($lastComment['u_id']);
                                        $lastCommentUserImg = getRandomImageForUser($userinfo['u_id']);
                        
                                    }
                                    
                                    
                        
                                echo '
                                
                                <div class="onepost row">
                        
                                <div class="postinfo d-flex col-5">
                                    <div class="image-post-user"><img src="'.$userimg.'"> </div>
                                    <div class="post-info">
                                        <a class="title-frm" href="topic.php?id='.$topic['t_id'].'"><h4> '.$topic['t_subject'].'</h4></a>
                                        <a href="profile.php?id='.$userinfo['u_id'].'"> <span class="username--staff">'.$userinfo['u_username'].'</span></a>
                                        <span class="at"><span>À</span> <span>'.$topic['t_createAt'].'</span></span>
                        
                                    </div>
                                </div>
                                <div class="col-1 text-right">
                                
                                ';
                                
                                if($topic['t_isClose'] == 1){
                        
                                    echo '<i class="fas fa-lock" style="color: #37a9e3;"></i>';
                                }
                                
                                
                                
                                echo'
                                <i class="fas fa-thumbtack" style="color: #37a9e3;"></i>
                                </div>
                                <div class="poststatistics col-2">
                                    <div>
                                        <div class="numx"> <span>Views :</span> <span class="static-num">'.$topic['t_views'].'</span> </div>
                                        <div  class="numx"> <span>Commentaire :</span> <span  class="static-num">'.$commentsCount.'</span> </div>
                                    </div>
                        
                                </div>
                                <div class="postlastcomment col-3">
                        
                                
                                ';
                        
                                if($lastComment!=null)
                                echo'
                                    
                                        <img class="lastcommentimg" src="'.$lastCommentUserImg.'" alt="">
                                        <div class="lastcommentinfo">
                                        <a href="profile.php?id='.$lastUserComment['u_id'].'"> <span class="username--staff">'.$lastUserComment['u_username'].'</span></a>
                                    <span class="at"><span>À</span> <span>'.$lastComment['r_date'].'</span></span>
                                    </div>
                                    ';
                                echo'     
                                
                                    </div>
                                    <div class="col-1">
                                    ';
                        
                                    // this area just for admin monitor modirator 
                                    topic_edite_pin_hide_remove($u_id,$topic['t_id']);
                                    
                                    echo'
                        
                                </div>
                                </div>
                                ';
                                
                        
                                
                                
                                
                        
                            }
                            
                        
                        
                        
                        echo'
                        <!--Ebd one post-->
                        
                        
                        
                        
                        
                            </div>
                        
                            </div>
                            <!--end post hidden-->
                        
                        ';
                        }
}



    ?>



<!--end hidden topics-->
<!----------------------------------------------hidden topics------------------------------------------------->



 <!--posts fixed-->
    <div class="fixed-topics">
        <div class="scStickyThreads"> <i class="fas fa-thumbtack"></i> SUJETS FIX</div>
       
<div class="forum-topic-fixed">
<!--one post-->

<?php

$fixedTopicscount = topics_get_count_fixed($_GET['id']);
if($fixedTopicscount!=0){
   
    $fixedtopics = topics_get_fixed($_GET['id']);
    foreach($fixedtopics as $topic ){

            // get info of user 
             $userinfo = users_get_by_id($topic['t_addBy']);
             // get count replys
             $commentsCount = comments_count($topic['t_id']);
             // get image 
             $userimg = getRandomImageForUser($userinfo['u_id']);
             // get info user last comment on post
             
             $lastComment = comments_get_Last($topic['t_id']);
             if($lastComment!=NULL){
                $lastUserComment = users_get_by_id($lastComment['u_id']);
                $lastCommentUserImg = getRandomImageForUser($userinfo['u_id']);

             }
             
             

        echo '
        
        <div class="onepost row">

        <div class="postinfo d-flex col-5">
            <div class="image-post-user"><img src="'.$userimg.'"> </div>
            <div class="post-info">
                <a class="title-frm" href="topic.php?id='.$topic['t_id'].'"><h4> '.$topic['t_subject'].'</h4></a>
                <a href="profile.php?id='.$userinfo['u_id'].'"> <span class="username--staff">'.$userinfo['u_username'].'</span></a>
                <span class="at"><span>À</span> <span>'.$topic['t_createAt'].'</span></span>

            </div>
        </div>
        <div class="col-1 text-right">
        
        ';
        
        if($topic['t_isClose'] == 1){

            echo '<i class="fas fa-lock" style="color: #37a9e3;"></i>';
        }
        
        
        
        echo'
        <i class="fas fa-thumbtack" style="color: #37a9e3;"></i>
        </div>
        <div class="poststatistics col-2">
            <div>
                <div class="numx"> <span>Views :</span> <span class="static-num">'.$topic['t_views'].'</span> </div>
                <div  class="numx"> <span>Commentaire :</span> <span  class="static-num">'.$commentsCount.'</span> </div>
            </div>

        </div>
        <div class="postlastcomment col-3">

        
        ';

        if($lastComment!=null)
        echo'
            
                <img class="lastcommentimg" src="'.$lastCommentUserImg.'" alt="">
                <div class="lastcommentinfo">
                <a href="profile.php?id='.$lastUserComment['u_id'].'"> <span class="username--staff">'.$lastUserComment['u_username'].'</span></a>
               <span class="at"><span>À</span> <span>'.$lastComment['r_date'].'</span></span>
              </div>
               ';
          echo'     
          
            </div>
            <div class="col-1">
            ';

            // this area just for admin monitor modirator 
            topic_edite_pin_hide_remove($u_id,$topic['t_id']);
            
            echo'

        </div>
        </div>
        ';
        

        
        
        

    }
    
}else{

    echo '<p class="text-center">Aucun Sujet</p>';
}


?>
 <!--Ebd one post-->


   


	</div>

    </div>
    <!--end post fixed-->
     



     <!--posts normale-->
     <div class="fixed-topics">
        <div class="scStickyThreads"> <i class="fas fa-thumbtack"></i> SUJETS NORMALE</div>
       
<div class="forum-topic">



<?php








$normalTopicscount = topics_get_count_normal($_GET['id']);
if($normalTopicscount!=0){
    $page=1;
   
    if(!isset($_GET['page'])){
        $page=1;

    }else{
        
        $page =  $_GET['page'];

    }

    //$normaltopics = topics_get_normal($_GET['id']);
      $normaltopics = topics_get_by_page($_GET['id'],$page,15);
    foreach($normaltopics as $topic ){

            // get info of user 
             $userinfo = users_get_by_id($topic['t_addBy']);
             // get count replys
             $commentsCount = comments_count($topic['t_id']);
             // get image 
             $userimgs = getRandomImageForUser($userinfo['u_id']);
             // get info user last comment on post
             
             $lastComment = comments_get_Last($topic['t_id']);
             if($lastComment!=NULL){
               $lastUserComment = users_get_by_id($lastComment['u_id']);  
               $lastCommentUserImg = getRandomImageForUser($userinfo['u_id']);
             }
             
             

        echo '
        
        <div class="onepost row">

        <div class="postinfo d-flex col-5">
            <div class="image-post-user"><img src="'.$userimgs.'"> </div>
            <div class="post-info">
                <a class="title-frm" href="topic.php?id='.$topic['t_id'].'"><h4> '.$topic['t_subject'].'</h4></a>
                <a href="profile.php?id='.$userinfo['u_id'].'"> <span class="username--staff">'.$userinfo['u_username'].'</span></a>
                <span class="at"><span>À</span> <span>'.$topic['t_createAt'].'</span></span>

            </div>
            
        </div>
        
        <div class="col-1 text-right">';
        
        
        if($topic['t_isClose'] == 1){

            echo '<i class="fas fa-lock" style="color: #37a9e3;"></i>';
        }
        
        echo'
        </div>
        <div class="poststatistics col-2">
            <div>
                <div class="numx"> <span>Views :</span> <span class="static-num">'.$topic['t_views'].'</span> </div>
                <div  class="numx"> <span>Commentaire :</span> <span  class="static-num">'.$commentsCount.'</span> </div>
            </div>

        </div>


        <div class="postlastcomment col-3">

        
        ';

        if($lastComment!=null){
        echo'
            
                <img class="lastcommentimg" src="'.$lastCommentUserImg.'" alt="">
                <div class="lastcommentinfo">
                <a href="profile.php?id='.$lastUserComment['u_id'].'"> <span class="username--staff">'.$lastUserComment['u_username'].'</span></a>
               <span class="at"><span>À</span> <span>'.$lastComment['r_date'].'</span></span>
               </div>
               ';
               

            }




          echo'     
    </div>
    <div class="col-1">
            ';
                    // this area just for admin monitor modirator 
                    topic_edite_pin_hide_remove($u_id,$topic['t_id']);
                    
 
      echo'       

        </div>

';


// end of area just for admin monitor modirator 
            echo'

        </div>
 
        
        ';

    

    }
    
}else{

    echo '<p class="text-center">Aucun Sujet</p>';
}




?>









</div>
</div>

    </div>
    <!--end post NORMALE-->




</div>
  <!--</div>-->


  <!--END forum-->
  
  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <?php
        $numOfPage = topics_pagination_get_numbers($_GET['id'],15);
        $idforum = $_GET['id'];
        $page = 1;
        if(isset($_GET['page'])) $page = $_GET['page'];
        if($page==1){
            echo'
            <li class="page-item disabled">
        <a class="page-link" href="#" tabindex="-1">Previous</a>
      </li>
            ';
        }else{
            $previous = $_GET['page']-1;
            echo"
            <li class='page-item'>
        <a class='page-link' href='forum.php?id=$idforum&page=$previous' tabindex='-1'>Previous</a>
      </li>";

        }
        
        for($x=1;$x<=$numOfPage;$x++){
            echo"<li class='page-item'><a class='page-link' href='forum.php?id=$idforum&page=$x'>$x</a></li>";
        }

        if($numOfPage==1 || $numOfPage==$page){
        echo"
        <li class='page-item disabled'>
        <a class='page-link' href='#'>Next</a>
        </li>
        ";
        }else if($numOfPage!=1 && $numOfPage!=$page ){

            $next = $page+1;
            echo"
            <li class='page-item'>
            <a class='page-link' href='forum.php?id=$idforum&page=$next'>Next</a>
            </li>
            ";
        }
        ?>
    </ul>
  </nav>
  
    <!--END CATEGORIE AND FORUMS-->





<?php require_once('inc/footer.php');  db_close();?>