<?php
    if(isset($_GET['edit_user'])){
        $target_user_id = escape($_GET['edit_user']);
        $query = "SELECT * FROM users WHERE user_id = $target_user_id";
        $query_action = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($query_action)){
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_email = $row['user_email'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
        $user_password = $row['user_password'];
        }
    

    if(isset($_POST['edit_user'])){
        $user_firstname=escape($_POST['user_firstname']);
        $user_lastname=escape($_POST['user_lastname']);
        $user_role=escape($_POST['user_role']);
        $username=escape($_POST['username']);
        $user_email=escape($_POST['user_email']);
        $user_password=escape($_POST['user_password']);

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
        $query .= "WHERE user_id = '{$target_user_id}'";

        $query_action = mysqli_query($connection, $query);
        header("Location: users.php");
    }
} else {
    header("Location: index.php");
}
?>

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
            <option value="<?php echo $user_role; ?>"><?php echo ucfirst($user_role); ?></option>
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
        <input type="submit" class="btn btn-primary" name="edit_user" value="Update User">
    </div>
</form>