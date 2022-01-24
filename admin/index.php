<?php 
    include "includes/admin_head.php"
?>

<body>

    <div id="wrapper">
        
        <!-- Navigation -->
        <?php 
            include "includes/admin_navigation.php"
        ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to Admin
                            <small><?php echo $_SESSION['username']; ?></small>
                        </h1>
                        
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <?php
                            $query = "SELECT * FROM posts";
                            $query_action = mysqli_query($connection,$query);
                            $post_count = mysqli_num_rows($query_action);
                            echo "<div class='huge'>{$post_count}</div>";
                        ?>
                        <div>Posts</div>
                    </div>
                </div>
            </div>
            <a href="posts.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <?php
                            $query = "SELECT * FROM comments";
                            $query_action = mysqli_query($connection,$query);
                            $comment_count = mysqli_num_rows($query_action);
                            echo "<div class='huge'>{$comment_count}</div>";
                        ?>
                      <div>Comments</div>
                    </div>
                </div>
            </div>
            <a href="comments.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <?php
                            $query = "SELECT * FROM users";
                            $query_action = mysqli_query($connection,$query);
                            $user_count = mysqli_num_rows($query_action);
                            echo "<div class='huge'>{$user_count}</div>";
                        ?>
                        <div> Users</div>
                    </div>
                </div>
            </div>
            <a href="users.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <?php
                            $query = "SELECT * FROM categories";
                            $query_action = mysqli_query($connection,$query);
                            $category_count = mysqli_num_rows($query_action);
                            echo "<div class='huge'>{$category_count}</div>";
                        ?>
                         <div>Categories</div>
                    </div>
                </div>
            </div>
            <a href="categories.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>

<?php
    $query = "SELECT * FROM posts WHERE post_status = 'draft'";
    $query_action = mysqli_query($connection,$query);
    $post_drafts_count = mysqli_num_rows($query_action);

    // $query = "SELECT * FROM posts WHERE post_status = 'published'";
    // $query_action = mysqli_query($connection,$query);
    $post_published_count = $post_count - $post_drafts_count;

    $query = "SELECT * FROM comments WHERE comment_status = 'rejected'";
    $query_action = mysqli_query($connection,$query);
    $comment_rejected_count = mysqli_num_rows($query_action);

    $query = "SELECT * FROM users WHERE user_role = 'subscriber'";
    $query_action = mysqli_query($connection,$query);
    $subscriber_count = mysqli_num_rows($query_action);
?>

            <div class="row">
            <script type="text/javascript">
                google.charts.load('current', {'packages':['bar']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                var data = google.visualization.arrayToDataTable([
                ['Data', 'Count'],
                <?php
                    $element_text = ['Total Posts', 'Published Posts', 'Draft Posts' , 'Categories', 'Users', 'Subscribers','Comments' , 'Rejected Comments'];
                    $element_count = [$post_count, $post_published_count, $post_drafts_count , $category_count, $user_count, $subscriber_count, $comment_count, $comment_rejected_count];

                    for($i = 0 ; $i<8 ; $i++ ){
                        echo "['{$element_text[$i]}',{$element_count[$i]}],";
                    }
                ?>
                
                
                ]);

            var options = {
                chart: {
                title: '',
                subtitle: '',
                }
            };

            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
            }
    </script>
    <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
  </head>

            </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php
        include "includes/admin_scripts.php"
    ?>

</body>

</html>
