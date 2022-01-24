<?php 
    include "includes/db.php"
?>

<?php 
    include "includes/head.php"
?>

<body>

    <!-- Navigation -->
    <?php 
    include "includes/navigation.php"
    ?>

    <?php
        if(isset($_POST['liked'])){
            $post_id=$_POST['post_id'];
            $user_id=$_POST['user_id'];
            $query = "SELECT * FROM posts WHERE post_id=$post_id";
            $query_action = mysqli_query($connection,$query);
            $result = mysqli_fetch_array($query_action);
            $likes = $result['likes'];
            mysqli_query($connection,"UPDATE posts SET likes=$likes+1 WHERE post_id=$post_id");
            mysqli_query($connection,"INSERT INTO likes(user_id,post_id) VALUES($user_id,$post_id)");
        }
        if(isset($_POST['unliked'])){
            $post_id=$_POST['post_id'];
            $user_id=$_POST['user_id'];
            $query = "SELECT * FROM posts WHERE post_id=$post_id";
            $query_action = mysqli_query($connection,$query);
            $result = mysqli_fetch_array($query_action);
            $likes = $result['likes'];
            mysqli_query($connection,"UPDATE posts SET likes=$likes-1 WHERE post_id=$post_id");
            mysqli_query($connection,"DELETE FROM likes WHERE post_id=$post_id AND user_id=$user_id");
        }
    ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
    
                <!-- <h1 class="page-header">
                    Posts
                </h1> -->

                <?php
                    if(isset($_GET['p_id']) && !empty($_GET['p_id'])){
                        $post_id = $_GET['p_id'];
                        if(isset($_SESSION['user_role']) && $_SESSION['user_role']=='admin'){
                            $query = "SELECT * FROM posts WHERE post_id = $post_id";
                        } else {
                            $query = "SELECT * FROM posts WHERE post_id = $post_id AND post_status='published'";
                        }
                        $query_action = mysqli_query($connection, $query);
                        if(mysqli_num_rows($query_action)>0){

                        while($row = mysqli_fetch_assoc($query_action)){
                            $post_title = $row['post_title'];
                            $post_author = $row['post_author'];
                            $post_date = $row['post_date'];
                            $post_image = $row['post_image'];
                            $post_content = $row['post_content'];
                ?>

                <!-- Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                <hr>
                <a href="post.php?p_id=<?php echo $post_id; ?>">
                    <img class="img-responsive" src="../images/<?php echo $post_image; ?>" alt="">
                </a>
                <hr>
                <p><?php echo $post_content; ?></p>
                <?php
                    // mysqli_stmt_free_result($stmt);
                ?>
                <?php if(isLoggedIn()){ ?>
                
                <hr>

                <div class="row">
                    <p class="pull-right"><a href="" class="<?php echo userLikedThisPost($post_id) ? 'unlike' : 'like';?>"><span class="glyphicon glyphicon-thumbs-up"
                    data-toggle="tooltip" data-placement="top" title="<?php echo userLikedThisPost($post_id) ? 'Unlike' : 'Like';?>"
                    ></span> <?php echo userLikedThisPost($post_id) ? 'Unlike' : 'Like';?></a></p>
                </div>
                <?php } ?>
                <div class="row">
                    <p class="pull-right">Likes: <?php getPostLikes($post_id); ?></p>
                </div>

                <div class="clearfix"></div>

                <?php
                    }
                    $query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = $post_id";
                    $query_action = mysqli_query($connection, $query);}
                    else{
                        header("Location: index.php");
                    }
                ?>
                <!-- Blog Comments -->

                <?php
                    if(isset($_POST['create_comment'])){
                        $post_id = $_GET['p_id'];
                        $comment_author = $_POST['comment_author'];
                        $comment_email = $_POST['comment_email'];
                        $comment_content = $_POST['comment_content'];
                        if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                        $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email,comment_content, comment_status, comment_date)";
                        $query .= "VALUES($post_id, '$comment_author', '$comment_email', '$comment_content', 'Pending approval', now())";
                        $query_action = mysqli_query($connection,$query);
                        
                        $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
                        $query .= "WHERE post_id = $post_id";
                        $query_action = mysqli_query($connection,$query);
                    } else {
                        echo "<script>alert('Fields cannot be empty!')</script>";
                    }
                    }
                ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" action="" method="post">
                        <div class="form-group">
                            <label for="comment_author">Author</label>
                            <input type="text" class="form-control" name="comment_author">
                        </div>
                        <div class="form-group">
                        <label for="comment_email">Email</label>
                            <input type="email"class="form-control" name="comment_email">
                        </div>
                        <div class="form-group">
                            <label for="comment_email">Your Comment</label>
                            <textarea name="comment_content" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Comments -->
                
                <?php
                    $query = "SELECT * from comments where comment_post_id = {$post_id} ";
                    $query .= "AND comment_status='approved' ";
                    $query .= "ORDER BY comment_id DESC";
                    $query_action = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_array($query_action)){
                        $comment_author = $row['comment_author'];
                        $comment_date = $row['comment_date'];
                        $comment_content = $row['comment_content'];
                ?>

                    <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <?php echo $comment_content; ?>
                    </div>
                    </div>
                <?php
                    }} else {
                        header("Location: index.php");
                    }
                ?>
                <!-- Pager -->
                <ul class="pager">
                    <li class="previous">
                        <a href="#">&larr; Older</a>
                    </li>
                    <li class="next">
                        <a href="#">Newer &rarr;</a>
                    </li>
                </ul>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php 
            include "includes/sidebar.php"
            ?>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <?php 
            include "includes/footer.php"
        ?>

        <?php 
            include "includes/scripts.php"
        ?>

        <script>
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();
                var post_id = <?php echo $post_id;?>;
                var user_id = <?php echo loggedInUserId();?>;
                $('.like').click(function(){
                    $.ajax({
                        url:"/http-cms/post/<?php echo $post_id; ?>",
                        type:"post",
                        data:{
                            'liked': 1,
                            'post_id':post_id,
                            'user_id':user_id
                        }
                    })
                })
                $('.unlike').click(function(){
                    $.ajax({
                        url:"/http-cms/post/<?php echo $post_id; ?>",
                        type:"post",
                        data:{
                            'unliked': 1,
                            'post_id':post_id,
                            'user_id':user_id
                        }
                    })
                })
            })
        </script>

    </div>
    <!-- /.container -->
    

</body>

</html>
