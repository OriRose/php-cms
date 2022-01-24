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

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
    
                <!-- <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1> -->

                <?php
                    $per_page = 5;
                    if(isset($_GET['page'])){
                        $page = $_GET['page'];
                    } else {
                        $page = '';
                    }
                    if($page == '' || $page =='1'){
                        $page_limit = 0;
                    } else {
                        $page_limit = ($page * $per_page) - $per_page;
                    }
                    if(isset($_SESSION['user_role']) && $_SESSION['user_role']=='admin'){
                        $query = "SELECT * FROM posts";
                    }
                    else {
                        $query = "SELECT * FROM posts WHERE post_status='published'";
                    }
                    $query_action = mysqli_query($connection, $query);
                    $count = mysqli_num_rows($query_action);
                    $count = ceil($count / $per_page);
                    if(isset($_SESSION['user_role']) && $_SESSION['user_role']=='admin'){
                        $query = "SELECT * FROM posts LIMIT $page_limit,$per_page";
                    }
                    else {
                        $query = "SELECT * FROM posts WHERE post_status='published' LIMIT $page_limit,$per_page";
                    }
                    $query_action = mysqli_query($connection, $query);

                    while($row = mysqli_fetch_assoc($query_action)){
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = substr($row['post_content'],0,100) . "...";
                        $post_status = $row['post_status'];
                ?>

                <!-- Blog Post -->
                <h2>
                    <a href="post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="author_posts.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo $post_content; ?></p>
                <!-- <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a> -->

                <hr>

                <?php
                    }
                    
                    if(!isset($post_id)){
                        echo "<h1 class='text-center'>No post published yet...</h1>" ;
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
        
        <ul class = "pager">
            <?php
                for($i=1 ; $i<=$count; $i++){
                    if($i == $page){
                        echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
                    } else {
                        echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                    }
                }
            ?>
        </ul>
        <!-- Footer -->
        <?php 
            include "includes/footer.php"
        ?>

    </div>
    <!-- /.container -->
    
    <?php 
        include "includes/scripts.php"
    ?>
    

</body>

</html>
