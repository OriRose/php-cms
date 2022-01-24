<?php
    if(isset($_POST['create_user'])){
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

        $user_password = crypt($password,$salt);
        
        $query = "INSERT INTO users(user_firstname,user_lastname,user_role,username,user_email,user_password) ";
        $query .= "VALUES('{$user_firstname}','{$user_lastname}','{$user_role}','{$username}','{$user_email}','{$user_password}')";
        $query_action = mysqli_query($connection,$query);
        if(!$query_action){
            die("QUERY FAILED" . mysqli_error($connection));
        }
        echo "User Created: <a href='users.php'>View Users</a>";
    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_firstname">First Name</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>
    <div class="form-group">
        <label for="user_lastname">Last Name</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>
    <div class="form-group">
        <select name="user_role" id="">
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>
        </select>
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email">
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>
    
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_user" value="Add User">
    </div>
</form>