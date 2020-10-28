<h1>ajouter forum</h1>
<form method="post">
    <label>categorie : </label>
    <select name="cat" class="custom-select" style="width:350px;">
        <?php
        $cat = cat_get();
        foreach($cat as $categorie){
            echo'<option value="'.$categorie['cat_id'].'">'.$categorie['cat_name'].'</option>';
        }

        ?>
    </select>
    <br><br>
    <label>status : </label>  <select id="" name="status" class="custom-select" style="width:200px;"> <option value="1">1</option> <option value="0">0</option></select>
    <br>
    <label>title  : </label> <input type="text" name="title" class="form-control" style="width:350px;" required>
    <br>
    <label>description : </label> <textarea name="description" class="form-control" style="width:350px;"></textarea>
    <br>
    <label>order : </label> <input type="number" name="order" class="form-control" style="width:350px;" required>
    <br>
    <label>image : </label> <input type="text" name="image" class="form-control" style="width:350px;" required>
    <br>
    <button type="submit" name="btnaddfrm" class="btn btn-warning"> ajouter</button>


</form>
