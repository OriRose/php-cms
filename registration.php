<?php  include "includes/db.php"; ?>
<?php  include "includes/head.php"; ?>
<body>    
    <?php
    $error = [
        'username'=>'',
        'email'=>'',
        'password'=>''
    ];
    if(isset($_POST['submit'])){
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        

        if($username == ''){
            $error['username'] = 'Username cannot be empty';
        } else if (strlen($username)<4) {
            $error['username'] = 'Username too short (needs at least 4 characters)';
        }
        if(username_exists($username)){
            $error['username'] = 'A user with this username already exists';
        }
        if ($email == '') {
            $error['email'] = 'Email cannot be empty';
        }
        if(email_exists($email)){
            $error['email'] = 'A user with this email already exists';
        }
        if ($password == '') {
            $error['password'] = 'Password cannot be empty';
        }
        
        
        if($error['username'] == '' && $error['email'] == '' && $error['password'] == ''){
            $username = mysqli_real_escape_string($connection,$username);
            $email = mysqli_real_escape_string($connection,$email);
            $password = mysqli_real_escape_string($connection,$password);
            
            $query = "SELECT randSalt FROM users";
            $query_action = mysqli_query($connection, $query);
            
            $row = mysqli_fetch_array($query_action);
                
            $salt = $row['randSalt'];

            $password = crypt($password,$salt);
    
            $query = "INSERT INTO users (username,user_email,user_password,user_role) ";
            $query .= "VALUES('{$username}','{$email}','{$password}','subscriber')";
            $query_action = mysqli_query($connection,$query);
            $message = "Your registration has been submitted.";
        }
    }
    ?>


<!-- Navigation -->

<?php  include "includes/navigation.php"; ?>


<!-- Page Content -->
<div class="container">
    
    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                    <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <h6 class="text-center"><?php if(isset($message)){echo $message;} ?></h6>
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username"
                            autocomplete="on" value='<?php echo isset($username) ? $username : '' ?>'>
                            <p><?php echo $error['username']; ?></p>
                        </div>
                        <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com"
                            autocomplete="on" value='<?php echo isset($email) ? $email : '' ?>'>
                            <p><?php echo $error['email']; ?></p>
                        </div>
                        <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                            <p><?php echo $error['password']; ?></p>
                        </div>
                        
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                    
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


<hr>



<?php include "includes/footer.php";?>
<?php 
    include "includes/scripts.php"
    ?>
</body>
</html>