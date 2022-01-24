<?php
    include("delete_modal.php");

    if(isset($_POST['checkBoxArray'])){
        foreach($_POST['checkBoxArray'] as $postValueId){
            $bulk_options = $_POST['bulk_options'];
            switch($bulk_options){
                case 'published':
                    $query = "UPDATE posts SET post_status = 'published' WHERE post_id = {$postValueId}";
                    $query_action = mysqli_query($connection,$query);
                    break;
                case 'draft':
                    $query = "UPDATE posts SET post_status = 'draft' WHERE post_id = {$postValueId}";
                    $query_action = mysqli_query($connection,$query);
                    break;
                case 'delete':
                    $query = "DELETE FROM posts WHERE post_id = {$postValueId}";
                    $query_action = mysqli_query($connection,$query);
                    break;
                case 'clone':
                    $query = "SELECT * FROM posts WHERE post_id = '{$postValueId}'";
                    $query_action = mysqli_query($connection, $query);

                    while($row = mysqli_fetch_array($query_action)){
                        $post_author = $row['post_author'];
                        $post_title = $row['post_title'];
                        $post_category_id = $row['post_category_id'];
                        $post_status = $row['post_status'];
                        $post_image = $row['post_image'];
                        $post_tags = $row['post_tags'];
                        $post_comment_count = $row['post_comment_count'];
                        $post_date = $row['post_date'];
                    }
                    $query = "INSERT INTO posts(post_category_id,post_title,post_author,post_date,post_image,post_content,post_tags,post_comment_count,post_status) ";
                    $query .= "VALUES({$post_category_id},'{$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_comment_count}','{$post_status}')";
                    $query_action = mysqli_query($connection,$query);
                    if(!$query_action){
                        die("QUERY FAILED" . mysqli_error($connection));
                    }
                    break;
            }
        }
    }
?>

<form action="" method='post'>
<table class="table table-bordered table-hover">
    <div id="bulkOptionsContainer" class="col-xs-4">
        <select class="form-control" name="bulk_options" id="">
            <option value="">Select Option...</option>
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
            <option value="delete">Delete</option>
            <option value="clone">Duplicate</option>
        </select>
    </div>
    <div class="col-xs-4">
        <input type="submit" name="submit" class="btn btn-success" value="Apply">
        <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
    </div>
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAllBoxes"></th>
                                    <th>Id</th>
                                    <th>Author</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Tags</th>
                                    <th>Comments</th>
                                    <th>Date</th>
                                    <th>View Post</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                    <th>Views</th>
                                    <th>Reset Views</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // $query = "SELECT * FROM posts ORDER BY post_id DESC";
                                    $query = "SELECT posts.post_id, posts.post_author, posts.post_title, posts.post_category_id,posts.post_status,posts.post_image, ";
                                    $query .= "posts.post_tags, posts.post_comment_count, posts.post_date, posts.post_views_count, categories.cat_id, categories.cat_title FROM posts ";
                                    $query .= "LEFT JOIN categories ON posts.post_category_id = categories.cat_id";
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
                                        $post_views_count = $row['post_views_count'];
                                        $cat_id = $row['cat_id'];
                                        $cat_title = $row['cat_title'];

                                        echo "<tr>";
                                        ?>
                                            <td><input name='checkBoxArray[]' class='checkBoxes' type='checkbox' value='<?php echo $post_id; ?>'></td>
                                        <?php
                                        echo "<td>{$post_id}</td>";
                                        echo "<td>{$post_author}</td>";
                                        echo "<td>{$post_title}</td>";

                                        // $query = "SELECT * FROM categories WHERE cat_id = $post_category_id";
                                        // $query_action_secondary = mysqli_query($connection, $query);
                                        // while($row = mysqli_fetch_assoc($query_action_secondary)){
                                        //     $cat_id = $row['cat_id'];
                                        //     $cat_title = $row['cat_title'];
                                            echo "<td>{$cat_title}</td>";
                                        // }

                                        echo "<td>{$post_status}</td>";
                                        echo "<td><img src='../images/{$post_image}' class='img-responsive' width='100' alt='image'></td>";
                                        echo "<td>{$post_tags}</td>";
                                        $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                                        $query_action_secondary = mysqli_query($connection,$query);
                                        $count = mysqli_num_rows($query_action_secondary);
                                        echo "<td><a href='post_comments.php?id=$post_id'>{$count}</a></td>";
                                        // echo "<td>{$post_comment_count}</td>";
                                        echo "<td>{$post_date}</td>";
                                        echo "<td><a class='btn btn-primary' href='../post.php?p_id={$post_id}'>View Post</a></td>";
                                        echo "<td><a class='btn btn-info' href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
                                        ?>
                                        <form method="post">
                                            <input type="hidden" name="post_id" value="<?php echo $post_id;?>">
                                            <?php
                                                echo "<td><a rel='{$post_id}' href='javascript:void(0)' class='btn btn-danger delete-button'>Delete</a></td>";
                                            ?>
                                        </form>
                                        <?php
                                        // echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?'); \" href='posts.php?delete={$post_id}'>Delete</a></td>";
                                        echo "<td>{$post_views_count}</td>";
                                        echo "<td><a class='btn btn-danger' href='posts.php?reset={$post_id}'>Reset</a></td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                        </form>

                        <?php
                            if(isset($_POST['delete'])){
                                $target_post_id = $_POST['delete'];
                                $query = "DELETE FROM posts WHERE post_id = {$target_post_id}";
                                $query_action = mysqli_query($connection, $query);
                                header("Location: posts.php");
                            }if(isset($_GET['reset'])){
                                $target_post_id = $_GET['reset'];
                                $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = {$target_post_id}";
                                $query_action = mysqli_query($connection, $query);
                                header("Location: posts.php");
                            }
                        ?>

<script>
    $(document).ready(function(){
    $(".delete-button").on('click',function(){
    var id = $(this).attr("rel");
    var delete_url= "posts.php?delete=" + id;
    $(".modal-delete-link").attr("href", delete_url);
    $("#myModal").modal('show');
    })
    })
</script>
