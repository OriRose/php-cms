<?php include "db.php"; ?>

<?php session_start(); ?>

<?php
    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $username = escape($username);
        $password = escape($password);

        $query = "SELECT * FROM users WHERE username = '{$username}'";
        $query_action = mysqli_query($connection, $query);
        
        while($row = mysqli_fetch_array($query_action)){
            $db_id = $row['user_id'];
            $db_user_firstname = $row['user_firstname'];
            $db_user_lastname = $row['user_lastname'];
            $db_user_role = $row['user_role'];
            $db_username = $row['username'];
            $db_user_password = $row['user_password'];
        }
        
        $password = crypt($password,$db_user_password);

        if($password !== $db_user_password){
            header("Location: ../index.php");
        } else {
            header("Location: ../admin");
            $_SESSION['user_id'] = $db_id;
            $_SESSION['username'] = $db_username;
            $_SESSION['firstname'] = $db_user_firstname;
            $_SESSION['lastname'] = $db_user_lastname;
            $_SESSION['user_role'] = $db_user_role;
        }
    } else {
        header("Location: ../index.php");
    }
?>