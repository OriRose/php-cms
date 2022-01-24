<?php
    if(isset($_GET['p_id'])){
        $target_post_id = escape($_GET['p_id']);
    }
    $query = "SELECT * FROM posts WHERE post_id = $target_post_id";
    $query_action = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($query_action)){
        $post_id = $row['post_id'];
        $post_author = $row['post_author'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_date = $row['post_date'];
        $post_content = $row['post_content'];
    }

    if(isset($_POST['update_post'])){
        $post_title=escape($connection,$_POST['title']);
        $post_author=escape($connection,$_POST['author']);
        $post_category_id=escape($_POST['post_category']);
        $post_status=escape($_POST['post_status']);
        $post_image=$_FILES['image']['name'];
        $post_image_tmp=$_FILES['image']['tmp_name'];
        $post_tags=escape($connection,$_POST['post_tags']);
        $post_content=escape($connection,$_POST['post_content']);

        move_uploaded_file($post_image_tmp,"../images/$post_image");

        if(empty($post_image)){
            $query = "SELECT * FROM posts WHERE post_id = {$target_post_id}";
            $query_action = mysqli_query($connection, $query);
            while($row = mysqli_fetch_array($query_action)){
                $post_image = $row['post_image'];
            }
        }
        
        $query = "UPDATE posts SET ";
        $query .= "post_title = '{$post_title}', ";
        $query .= "post_author = '{$post_author}', ";
        $query .= "post_category_id = '{$post_category_id}', ";
        $query .= "post_date = now(), ";
        $query .= "post_status = '{$post_status}', ";
        $query .= "post_tags = '{$post_tags}', ";
        $query .= "post_content = '{$post_content}', ";
        $query .= "post_image = '{$post_image}' ";
        $query .= "WHERE post_id = {$target_post_id}";

        $query_action = mysqli_query($connection, $query);
        // header("Location: posts.php");
        echo "<p class='bg-success'>Post Updated. <a href='../post.php?p_id={$post_id}'>View Post</a> or <a href='posts.php'>Edit More Posts</a></p>";
    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" value="<?php echo $post_title; ?>" class="form-control" name="title">
    </div>
    <div class="form-group">
        <select name="post_category" id="">
            <?php
                $query = "SELECT * FROM categories";
                $query_action = mysqli_query($connection, $query);
                while($row = mysqli_fetch_assoc($query_action)){
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];
                    if($cat_id == $post_category_id){
                        echo "<option selected value='{$cat_id}'>{$cat_title}</option>";
                    } else {
                        echo "<option value='{$cat_id}'>{$cat_title}</option>";
                    }
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="title">Post Author</label>
        <input type="text" value="<?php echo $post_author; ?>" class="form-control" name="author">
    </div>
    <div class="form-group">
        <select name="post_status" id="">
            <option value='<?php echo $post_status; ?>'><?php echo $post_status; ?></option>
            <?php
                if($post_status == 'published'){
                    echo "<option value='draft'>Draft</option>";
                } else {
                    echo "<option value='published'>Published</option>";
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <img src="../images/<?php echo $post_image; ?>" alt="image" width="100">
        <input name="image" type="file" />
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" value="<?php echo $post_tags; ?>" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea name="post_content" class="form-control" id="" cols="30" rows="10"><?php echo str_replace("\\",'',str_replace('\r\n','<br>', $post_content)); ?></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_post" value="Publish Post">
    </div>
</form>