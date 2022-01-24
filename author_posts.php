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
    
                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <?php
                    if(isset($_GET['p_id'])){
                        $post_id = escape($_GET['p_id']);
                        $post_author = escape($_GET['author']);
                    }
                    $query = "SELECT * FROM posts where post_author = $post_author";
                    $query_action = mysqli_query($connection, $query);

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
                    <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                </a>
                <hr>
                <p><?php echo $post_content; ?></p>

                <hr>

                <?php
                    }
                ?>
                

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

    </div>
    <!-- /.container -->
    
    <?php 
        include "includes/scripts.php"
    ?>
    

</body>

</html>
