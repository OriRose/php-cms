<?php 
    include "includes/admin_head.php";
?>
<?php
    if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
        $query = "SELECT * FROM users WHERE username = '{$username}'";
        $query_action = mysqli_query($connection, $query);
        while($row = mysqli_fetch_array($query_action)){
            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_email = $row['user_email'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_role = $row['user_role'];
            $user_password = $row['user_password'];
        }
    }
?>
<body>
    <?php
        if(isset($_POST['edit_user'])){
            $user_firstname=$_POST['user_firstname'];
            $user_lastname=$_POST['user_lastname'];
            $user_role=$_POST['user_role'];
            $username=$_POST['username'];
            $user_email=$_POST['user_email'];
            $user_password=$_POST['user_password'];
    
            $query = "SELECT randSalt FROM users";
            $query_action = mysqli_query($connection, $query);
            $row = mysqli_fetch_array($query_action);
                
            $salt = $row['randSalt'];

            $hashed_password = crypt($user_password,$salt);
            
            $query = "UPDATE users SET ";
            $query .= "user_firstname = '{$user_firstname}', ";
            $query .= "user_lastname = '{$user_lastname}', ";
            $query .= "user_role = '{$user_role}', ";
            $query .= "username = '{$username}', ";
            $query .= "user_email = '{$user_email}', ";
            $query .= "user_password = '{$hashed_password}' ";
            $query .= "WHERE username = '{$username}'";
    
            $query_action = mysqli_query($connection, $query);
            header("Location: users.php");
        }
    ?>
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
                        <form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_firstname">First Name</label>
        <input type="text" value = '<?php echo $user_firstname; ?>' class="form-control" name="user_firstname">
    </div>
    <div class="form-group">
        <label for="user_lastname">Last Name</label>
        <input type="text" value = '<?php echo $user_lastname; ?>' class="form-control" name="user_lastname">
    </div>
    <div class="form-group">
        <select name="user_role" id="">
            <option value=<?php echo $user_role; ?>><?php echo ucfirst($user_role); ?></option>
            <?php
                if ($user_role == 'admin'){
                    echo "<option value='subscriber'>Subscriber</option>";
                } else {
                    echo "<option value='admin'>Admin</option>";
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" value = '<?php echo $username; ?>' class="form-control" name="username">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" value = '<?php echo $user_email; ?>' class="form-control" name="user_email">
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" autocomplete="off" name="user_password">
    </div>
    
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="edit_user" value="Update Profile">
    </div>
</form>
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
