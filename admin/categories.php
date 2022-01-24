<?php 
    include "includes/admin_head.php";
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
                        <div class="col-xs-6">
                            <?php
                               insertCategories();
                            ?>
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="cat-title">Add Category</label>
                                    <input type="text" class="form-control" name="cat_title">
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="submit" class="btn btn-primary" value="Add Category">
                                </div>
                            </form>
                            <?php
                                if(isset($_GET['edit'])){
                                    $cat_id = $_GET['edit'];
                                    include "includes/update_categories.php";
                                }
                            ?>
                            <?php
                                if(isset($_POST['update_category'])){
                                    $updated_cat_title = $_POST['cat_title'];
                                    $query = "UPDATE categories SET cat_title='{$updated_cat_title}' WHERE cat_id = {$cat_id}";
                                    $query_action = mysqli_query($connection, $query);
                                    if(!$query_action){
                                        die("QUERY FAILED" . mysqli_error($connection));
                                    }
                                }
                            ?>                
                        </div>
                        <div class="col-xs-6">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Category Title</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    findAllCategories();
                                ?>
                                <?php
                                    deleteCategories();
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

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
