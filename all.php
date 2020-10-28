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
//localhost/forum/all.php?type=topics&id=37
require_once('session.php'); 
require_once('inc/top-header.php');




?>



    <title>xxxxxx</title>
  
    <?php require_once('inc/header.php'); ?>

<!--START CONTENT-->
<div class="content container-fluid">

  <?php require_once('inc/admin-message.php');?>






 <!--START CATEGORIE AND FORUMS-->
 <!--START forum-->

 <div class="forumpage">


<div class="forum-main-forum">







     <!--posts normale-->
     <div class="fixed-topics">
        <div class="scStickyThreads"> <i class="fas fa-thumbtack"></i> SUJETS De Ayoub</div>
       
<div class="forum-topic">



<?php





echo '

<div class="forum-topic">


<div class="onepost row">

	<div class="postinfo d-flex col-5">
		<div class="image-post-user"><img src="https://www.bigstockphoto.com/images/homepage/module-6.jpg"> </div>
		<div class="post-info">
			<a class="title-frm" href="topic.php?id=9">
				<h4> jfgjgjg jgjg j gjg j</h4>
			</a>
			<a href="profile.php?id=37"> <span class="username--staff">root</span></a>
			<span class="at"><span>À</span> <span>2020-04-25 18:24:08</span></span>
		</div>
	</div>



	<div class="col-1 text-right">
	</div>
	<div class="poststatistics col-2">
		<div>
			<div class="numx"> <span>Views :</span> <span class="static-num">0</span> </div>
			<div class="numx"> <span>Commentaire :</span> <span class="static-num">0</span> </div>
		</div>
	</div>



	<div class="postlastcomment col-3">
	</div>


	<div class="col-1">bbbbb</div>


</div>
</div>

';




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