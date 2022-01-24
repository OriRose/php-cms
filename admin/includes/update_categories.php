<?php
if(isset($_GET['edit'])){
    $cat_id = escape($_GET['edit']);
    $query = "SELECT * FROM categories WHERE cat_id = $cat_id";
    $query_action = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($query_action)){
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
                                    
?>
    <form action="" method="post">
        <div class="form-group">
            <label for="cat-title">Edit Category</label>
            <input type="text" value="<?php echo"$cat_title";?>" class="form-control" name="cat_title">
        </div>
        <div class="form-group">
            <input type="submit" name="update_category" class="btn btn-primary" value="Update Category">
        </div>
    </form>
<?php }}?>