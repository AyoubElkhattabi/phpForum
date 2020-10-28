</head>
  <body>
    
        
<div class="all-header">
<!-- START TOP NAV -->
<nav class="navbar navbar-expand-lg navbar-light top-navbar ">
  <div class="container-fluid ">
  
    <ul class="d-flex top-nav-icon">
      <li><a href="#"><i class="fab fa-facebook-square"></i></a></li>
      <li><a href="#"><i class="fab fa-twitter-square"></i></a></li>
      <li><a href="#"><i class="fab fa-youtube-square"></i></a></li>
      <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
      <li><a href="#"><i class="fas fa-rss-square"></i></a></li>
    </ul>
  

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">

    <ul class="navbar-nav navbar-right ml-auto">
      <li  class="nav-item top-nav-item"><a class="nav-link" href="#"><i class="far fa-life-ring"></i>Aide</a></li>
      <li  class="nav-item top-nav-item"><a class="nav-link" href="#"><i class="fas fa-envelope"></i>Contactez-nous</a></li>
      <li  class="nav-item top-nav-item"><a class="nav-link" href="#"><i class="far fa-money-bill-alt"></i>faites un don</a></li>
      <li  class="nav-item top-nav-item"><a class="nav-link" href="#"><i class="fab fa-phoenix-framework"></i>Nos services</a></li>
    </ul>

  </div>
</div>
</nav>
 <!-- END TOP NAV -->
 <!--START HEADER-->
<div class="container-fluid">
<header class="row">
<span class="logo col-md-6 col-sm-12">
<a href="index.php" style="color:white;">
  <i class="fab fa-gripfire"></i>
  </a>
</span>
  
<div class="right-side col-md-6 col-sm-12">
  <div class="log">



<div class="log-button">
  <?php
  if(empty($_SESSION['user_info'])){

    echo"
    <a href='login.php' class='login-btn'>
    <i class='far fa-user'></i>
    Authentifier
    </a>
    <a href='signup.php' class='signup-btn'>
    <i class='fas fa-user-plus'></i>
    Inscrire
    </a>
  ";
  $u_id=0;

  }else{
    $u_id = $_SESSION['user_info']['u_id'];
    $u_username = $_SESSION['user_info']['u_username'];
    $u_image = $_SESSION['user_info']['u_image'];
    $u_profile = 'profile.php?id='.$_SESSION['user_info']['u_id'];
    $u_image = getRandomImageForUser($_SESSION['user_info']['u_id']);
    $msgunreadcount = message_get_inread_messages_count($u_id);
    if($msgunreadcount == 0) $messageunread='';
    else $messageunread = '<div  class="unreadmsg">'.message_get_inread_messages_count($u_id).'</div>';

    
    
    echo"
    <a href='$u_profile' class=' barusername'>
        <img  class='barimg' src='$u_image'>
        <span class='barusername'>$u_username</span>
      </a>
      <a href='messages.php?m=read&type=inbox' class='barusername bar-msg'><i class='far fa-envelope'></i> $messageunread </a>
      <a href='logout.php' class='barusername bar-msg'><i class='fas fa-sign-out-alt'></i>
      </a>
    ";





  }
  
  
  
  ?>
 
      

  

</div>
  

  </div>

</div>
</header>
</div>
<!--END HEADER-->
</div>
