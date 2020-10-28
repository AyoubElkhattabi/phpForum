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

//http://localhost/forum/messages.php?m=read&type=sent
//http://localhost/forum/messages.php?m=read&type=inbox

//http://localhost/forum/messages.php?m=send&uid=10
require_once('session.php'); 
require_once('inc/top-header.php');


if(empty($_SESSION['user_info'])) exit();


?>



    <title>Message</title>
  
    <?php require_once('inc/header.php'); ?>

<!--START CONTENT-->
<div class="content container-fluid">

  <?php require_once('inc/admin-message.php');?>




<?php

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['btnsendmessage'])){
        print_array($_POST);
        $sendmessage = message_send($_POST['subject'] , $_POST['text']  , $u_id , $_POST['to'] , 0);
        if($sendmessage == true) {echo 'message envoyer'; header("location: message.php?message=Message Envoyer&link=messages.php?m=read%26type=inbox");}
        else echo 'error';
    }else if(isset($_POST['addmsgwithparrent'])){

        print_array($_POST);
        $sendmessage = message_send($_POST['subject'] , $_POST['text']  , $u_id , $_POST['to'] ,$_POST['idparentmsg']);
        if($sendmessage == true) {echo 'message envoyer'; header("location: message.php?message=Message Envoyer&link=messages.php?m=read%26type=inbox");}

    }
  
    
    exit();
}
?>





 <!--START CATEGORIE AND FORUMS-->
 <!--START forum-->

 <div class="forumpage">


<?php

if(isset($_GET['m'])){
    if($_GET['m'] == 'read'){

        echo '
        <div class="crud">
            <a href="messages.php?m=read&type=inbox"><i class="fas fa-envelope"></i> message a été reçu </a>
            <a href="messages.php?m=read&type=sent"><i class="far fa-envelope"></i> message a été envoyé </a>
        </div>
        ';

        if(isset($_GET['message'])){

            if(!empty($_GET['message'])){

                $message = message_get_by_id($_GET['message']);
                
                if($message == NULL || $message == 0) exit('no message to show');
                if($message['m_from'] != $u_id && $message['m_to'] != $u_id ) {exit('no message to show');}
                if($message['m_from'] == $u_id && $message['m_isdeletedbyowner'] ==1) {exit('no message to show');}
                if($message['m_to'] == $u_id && $message['m_isdeletedbyreceiver'] ==1) {exit('no message to show');}
                if($message['m_isread'] == 0 && $message['m_to'] == $u_id) {message_set_message_read($message['m_id']);}
                $from = users_get_by_id($message['m_from']);
                $to = users_get_by_id($message['m_to']);
                $image = getRandomImageForUser($message['m_from']);
                echo '
                <div>
                <div class="forumpage">

                <h2 class="headtotle text-center" style="margin: 20px 0;">'.$message['m_subject'].'</h2>
                <div class="main-post row">
                <div class="author-info col-2">
                
                <div class="post-img-author">
                <a href="profile.php?id='.$from['u_id'].'">
                <img class="post-img-author-x" src="'.$image.'" alt="'.$from['u_username'].'">
                <span class="username-author">'.$from['u_username'].'</span>
                </a>
                </div>
                <div class="author-info-details">
                <div class="m-title">'.get_user_role($from['u_id']).'</div>
                
                </div>
                </div>
                  
                <div class="postcontent col-10">
                <div class="post-date">
                  <span class="dateofpost">Envoyer À : '.$message['m_date'].'</span> <hr>
                  
                </div>
                ';

                if($message['m_parent'] !=0){

                            $parrentmsg = message_get_by_id($message['m_parent']);
                            $pfrom = users_get_by_id($parrentmsg['m_from']);
                            $pto = users_get_by_id($parrentmsg['m_to']);
                            $pimage = getRandomImageForUser($parrentmsg['m_from']);
                            echo '
                            <div>
                            <div class="forumpage">

                            
                            <div class="main-post row">
                            <div class="author-info col-2">
                            
                            <div class="post-img-author">
                            <a href="profile.php?id='.$pfrom['u_id'].'">
                            <img class="post-img-author-x" src="'.$pimage.'" alt="'.$pfrom['u_username'].'">
                            <span class="username-author">'.$pfrom['u_username'].'</span>
                            </a>
                            </div>
                            <div class="author-info-details">
                            <div class="m-title">'.get_user_role($pfrom['u_id']).'</div>
                            
                            </div>
                            </div>
                            
                            <div class="postcontent col-10">
                            <div class="post-date">
                            <span class="dateofpost">Envoyer À : '.$parrentmsg['m_date'].'</span> <hr>
                            
                            </div>
                            
                            <!--content-->
                            '.
                            $parrentmsg['m_text']
                            .'<!-- end content-->
                            </div>
                            
                            </div>
                            
                            </div>

                            </div>
                                        
                                        
                                        ';

                }

                echo'
                <!--content-->
                '.
                $message['m_text']
                .'<!-- end content-->
                </div>
                
                </div>
                
                </div>

                </div>
                ';



                            if($message['m_from'] != $u_id){

                                            echo '
                            
                            
                                            <div class="main-post row">
                                    <div class="author-info col-2">
                                    <div class="post-img-author">
                                    <img class="post-img-author-x" src=".\img\user.png" alt="admin">
                                    </div>
                            
                                    </div>
                                    <div class="postcontent col-10 add-comment">
                                    <form method="post" action="" onsubmit="">
                                    <input type="hidden" name="idparentmsg" value="'.$message['m_id'].'">
                                    <input type="hidden" name="to" value="'.$message['m_from'].'">
                                    <input type="hidden" name="subject" value="Message par '.$u_username.' à '.users_get_username_by_id($message['m_from']).'">
                                    <textarea class="form-control" id="reply" name="text" rows="3"></textarea> 
                                    <button style="width: 50%;margin: auto;margin-top: auto;display: block;margin-top: 15px;" type="submit" name="addmsgwithparrent" class="btn btn-primary commenter-button" >Envoyer Le Message</button> <span style="color:red; font-size:16px;" id="commentserror"></span>
                                    </form>
                                    </div>
                                    </div>
                                            
                                            ';
                
                                
                            }


            }
        }




        if(isset($_GET['type'])){
            $messages = NULL;
            if($_GET['type'] == 'inbox'){
               // echo 'hna radi ybano inbox'; // hna radi n3amar l variable messages
                $messages = message_get(' WHERE m_to = '.$u_id.' AND m_isdeletedbyreceiver = 0 ORDER BY m_id DESC');
                //print_array($messages);
            }else if($_GET['type'] == 'sent'){
                //echo 'hna radi ybano sent'; // hna radi n3amar l variable messages
                $messages = message_get(' WHERE m_from = '.$u_id.' AND m_isdeletedbyowner = 0 ORDER BY m_id DESC');
               // print_array($messages);
            }

            if($messages!=NULL || $messages==0 ){ // radi nraja3ha != null mn ba3d


                echo '
                
                <table class="table table-striped" style="margin-top: 1rem;">
                                    <thead>
                                    <tr>
                                        <th style="width:170px;">Date</th>
                                        <th style="width:150px;">Par</th>
                                        <th style="width:150px;">À</th>
                                        <th>Message</th>
                                        <th style="width:100px;">Operation</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                ';

                // radi ndir foreach 3la $messages
                


                foreach($messages as $message){
                    $new='';
                    if($u_id == $message['m_to']){ // check if msg is new or viewed
                        if($message['m_isread'] == 0){
                            $new = '<span style="color:red">   [NEW]</span>';
                        }
                    }
                    echo '
                    
                                    <tr>
                                        <td>'.$message['m_date'].'</td>
                                        <td><a href="#">'.users_get_username_by_id($message['m_from']).'</a></td>
                                        <td><a href="#">'.users_get_username_by_id($message['m_to']).'</a></td>
                                        <td><a href="messages.php?m=read&message='.$message['m_id'].'">'.$message['m_subject'].$new.'</a></td>
                                        <td><a href="deletemessage.php?id='.$message['m_id'].'" style="color:red"><i class="fas fa-trash-alt"></i></a></td>
                                    </tr>  

                    ';

                }

                echo '
                </tbody>
                </table>
                ';
            }



        }

    }else if($_GET['m'] == 'send'){

        if(isset($_GET['uid'])){

            if(!empty($_GET['uid'])){

                $user = users_get_by_id($_GET['uid']);
                if(is_array($user)){

                   // print_array($user);
                    echo '
                    <form method="POST" action="">
                    <div class="m-3">
                    <input type="hidden" name="to" value="'.$user['u_id'].'">
                    <div class="mt-3 mb-3"><span class="text-info title-new-post">Message À : </span> <span class="text-danger title-new-tt" style="font-size: 20px;">'.$user['u_username'].'</span></div>
                    <div class="mt-3 mb-3"><label>Sujet de Message: </label>  <input type="text" class="form-control frm-ctr" name="subject" id="inputPassword2" placeholder="" value="Message par '.$u_username.' à '.$user['u_username'].'"></div>
                    <div class="editblockr mt-3 mb-3"><textarea class="form-control" id="exampleFormControlTextarea1" rows="10" name="text"></textarea> </div>
                    <div class="editprofilerow mt-3 mb-3"><button type="submit" name="btnsendmessage" class="btn btn-primary btn-lg">Envoyer</button></div>
                    </div>
                    </form>
                    </div>
                    ';
                }

            }

        }

    }
}


?>






  <!--END forum-->
  
  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <?php
        /*
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
        */
        ?>
    </ul>
  </nav>
  
    <!--END CATEGORIE AND FORUMS-->




</div>
<?php require_once('inc/footer.php');  db_close();?>