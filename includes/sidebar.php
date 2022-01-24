<div class="col-md-4">
    <?php
        if (isset($_POST['submit'])){
            $search = escape($_POST['search']);

            $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%'";
            $query_action = mysqli_query($connection , $query);

            if(!$query_action){
                die("QUERY FAILED" . mysqli_error($connection));
            }
            else{
                
            }
        }
    ?>

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <form action="search.php" method="post">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control">
                        <span class="input-group-btn">
                            <button name="submit" class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                    </form>
                    <!-- /.input-group -->
                </div>

                <!-- Login -->
                
                <div class="well">
                <?php
                    if(isset($_SESSION['user_role'])){
                ?>
                    <h4>Logged in as <?php echo $_SESSION['username']; ?></h4>
                    <a href="/http-cms/includes/logout.php" class="btn btn-primary">Logout</a>
                <?php
                    } else {
                ?>
                    <h4>Login</h4>
                    <form action="/http-cms/includes/login.php" method="post">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Enter username">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Enter password">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" name="login" type="submit">Submit</button>
                        </span>
                    </div>
                    </form>
                    <?php
                    }
                    ?>
                    <!-- /.input-group -->
                </div>

                <!-- Blog Categories Well -->
                <div class="well">

                <?php
                    $query = "SELECT * FROM categories";
                    // $query = "SELECT * FROM categories LIMIT 3";
                    $query_action = mysqli_query($connection, $query);
                        
                ?>
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled">
                                <?php 
                                    while($row = mysqli_fetch_assoc($query_action)){
                                       $cat_title = $row['cat_title'];
                                       $cat_id = $row['cat_id'];
                                       echo "<li><a href='/http-cms/category.php?category=$cat_id'>{$cat_title}</a></li>";
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
                <?php include "widget.php" ?>

            </div>

        </div>