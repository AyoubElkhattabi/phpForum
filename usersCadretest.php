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

?>


<table class="table table-striped">
  <thead>
    <tr>
        <th scope="col"></th>
        <th scope="col">ID</th>
        <th scope="col">Utilisateur</th>
        <th scope="col">Date d'inscription</th>
    </tr>
  </thead>
  <tbody>

  <?php
  
  echo '
  <tr>
      <td><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcT7ZCSo5G1pxb0_rdvOX5vpCShYkX1BFkjp6NLwBslj9zTsnnqx&usqp=CAU" style="width:80px;height:80px; border-radius:100px;display:block; margin:auto"></td>
      <td>10</td>
      <td>root</td>
      <td>2020/01/01</td>
    </tr>
  ';
  ?>
      
  </tbody>
</table>





<?php require_once('inc/footer.php');?>