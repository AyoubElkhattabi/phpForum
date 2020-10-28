


<h1>Update forum</h1>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'].'?id=2&update='.$f_id;?>">
    <label>categorie : </label>
    <select name="cat" class="custom-select" style="width:350px;">
        <?php
        $cat = cat_get();
        foreach($cat as $categorie){
            if($categorie['cat_id'] == $result['cat_id'])
            echo'<option value="'.$categorie['cat_id'].'" selected>'.$categorie['cat_name'].'</option>';
            else
            echo'<option value="'.$categorie['cat_id'].'" >'.$categorie['cat_name'].'</option>';

        }

        ?>
    </select>
    <br>
    <label>status : </label>  <select id="" name="status" class="custom-select" style="width:200px;"> <option value="1">1</option> <option value="0">0</option></select>
    <br>
    <label>title  : </label> <input type="text" name="title" class="form-control" style="width:350px;" value="<?php echo $result['f_title'] ;?>" required>
    <br>
    <label>description : </label> <textarea name="description" class="form-control" style="width:350px;"><?php echo $result['f_description'] ;?></textarea>
    <br>
    <label>order : </label> <input type="number" name="order" class="form-control" style="width:350px;" value="<?php echo $result['f_order'] ;?>" required>
    <br>
    <label>image : </label> <input type="text" name="image" class="form-control" style="width:350px;" value="<?php echo $result['f_image'] ;?>" required>
    <br>
    <button type="submit" name="btnupdatefrm" class="btn btn-info"> update</button>


</form>
