<?php
    if(isset($_POST['create_post'])){
        $post_title=escape($_POST['title']);
        $post_author=escape($_POST['author']);
        $post_category_id=escape($_POST['post_category']);
        $post_status=escape($_POST['post_status']);
        $post_image=$_FILES['image']['name'];
        $post_image_tmp=$_FILES['image']['tmp_name'];
        $post_tags=escape($_POST['post_tags']);
        $post_content=escape($_POST['post_content']);
        $post_date=date('d-m-y');
        $post_comment_count=0;

        move_uploaded_file($post_image_tmp,"../images/$post_image");
        
        $query = "INSERT INTO posts(post_category_id,post_title,post_author,post_date,post_image,post_content,post_tags,post_comment_count,post_status) ";
        $query .= "VALUES({$post_category_id},'{$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_comment_count}','{$post_status}')";
        $query_action = mysqli_query($connection,$query);
        if(!$query_action){
            die("QUERY FAILED" . mysqli_error($connection));
        }
        $new_post_id = mysqli_insert_id($connection);
        echo "<p class='bg-success'>Post Created. <a href='../post.php?p_id={$new_post_id}'>View Post</a> or <a href='posts.php'>Edit More Posts</a></p>";
    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
    </div>
    <div class="form-group">
        <label for="post_category">Post Category Id</label>
        <input type="text" class="form-control" name="post_category_id">
    </div>
    <div class="form-group">
        <label for="post_category">Category</label>
        <select name="post_category" id="">
            <?php
                $query = "SELECT * FROM categories";
                $query_action = mysqli_query($connection, $query);
                while($row = mysqli_fetch_assoc($query_action)){
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];
                    echo "<option value='{$cat_id}'>{$cat_title}</option>";
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <select name="post_status" id="">
            <option value="draft">Post status</option>
            <option value="published">Published</option>
            <option value="draft">Draft</option>
        </select>
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="post_image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea name="post_content" class="form-control" id="" cols="30" rows="10"></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_post" value="Publish Post">
    </div>
</form>