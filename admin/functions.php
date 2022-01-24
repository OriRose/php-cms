<?php
    function escape($string) {
        global $connection;
        return mysqli_real_escape_string($connection,trim($string));
    }
    function insertCategories() {
        global $connection;
        if(isset($_POST['submit'])){
            $cat_title = $_POST['cat_title'];
            if($cat_title == "" || empty($cat_title)){
                echo "This field should not be empty!";
            } else {
                $stmt = mysqli_prepare($connection,"INSERT INTO categories(cat_title) VALUES(?)");
                mysqli_stmt_bind_param($stmt, 's', $cat_title);
                mysqli_stmt_execute($stmt);
                if(!$stmt){
                    die("QUERY FAILED" . mysqli_error($connection));
                }
            }
        }
    }
    function findAllCategories() {
        global $connection;
        $query = "SELECT * FROM categories";
        $query_action = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($query_action)){
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<tr>
        <td>{$cat_id}</td>
        <td>{$cat_title}</td>
        <td><a href='categories.php?delete={$cat_id}'>Delete</a>
        <a href='categories.php?edit={$cat_id}'>Edit</a></td>
        </tr>";
        }
    }
    function deleteCategories(){
        global $connection;
        if(isset($_GET['delete'])){
            $target_cat_id = $_GET['delete'];
            $query = "DELETE FROM categories WHERE cat_id = {$target_cat_id}";
            $query_action = mysqli_query($connection, $query);
            header("Location: categories.php");
        }
    }
    function users_online(){
        if(isset($_GET['onlineusers'])){
            global $connection;
            if(!$connection){
                session_start();
                include("../includes/db.php");
            }
            $session = session_id();
            $time = time();
            $time_out_duration = 300;
            $time_out = $time - $time_out_duration;
    
            $query = "SELECT * FROM users_online WHERE session = '$session'";
            $query_action = mysqli_query($connection,$query);
            $count = mysqli_num_rows($query_action);
            if($count == NULL) {
                mysqli_query($connection,"INSERT INTO users_online(session,time) VALUES ('$session','$time')");
            } else {
                mysqli_query($connection,"UPDATE users_online SET time = '$time' WHERE session = '$session'");
            }
            $query_action = mysqli_query($connection,"SELECT * FROM users_online WHERE time > '$time_out'");
            echo $count_user = mysqli_num_rows($query_action);
        }
    }
    users_online();
    function username_exists($username){
        global $connection;
        $query = "SELECT user_role FROM users WHERE username = '$username'";
        $query_action = mysqli_query($connection,$query);
        if(mysqli_num_rows($query_action)>0){
            return true;
        }else{
            return false;
        }
    }
    function email_exists($email){
        global $connection;
        $query = "SELECT user_email FROM users WHERE user_email = '$email'";
        $query_action = mysqli_query($connection,$query);
        if(mysqli_num_rows($query_action)>0){
            return true;
        }else{
            return false;
        }
    }
    function ifItIsMethod($method = null){
        if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){
            return true;
        } else {
            return false;
        }
    }
    function isLoggedIn(){
        if(isset($_SESSION['user_role'])){
            return true;
        } else {
            return false;
        }
    }
    function checkIfUserIsLoggedInAndRedirect($redirectLocation = null){
        if(isLoggedIn()){
            header("Location: ".$redirectLocation);
        }
    }
    function loggedInUserId(){
        global $connection;
        if(isLoggedIn()){
            $result = mysqli_query($connection,"SELECT * FROM users WHERE username='" . $_SESSION['username'] . "'");
            $user = mysqli_fetch_array($result);
            if(mysqli_num_rows($result)>=1){
                return $user['user_id'];
            }
        }
        return false;
    }
    function userLikedThisPost($post_id =''){
        global $connection;
        $result = mysqli_query($connection,"SELECT * FROM likes WHERE user_id=" . loggedInUserId() . " AND post_id=$post_id");
        return mysqli_num_rows($result) >= 1 ? true : false;
    }
    function getPostLikes($post_id=''){
        global $connection;
        $result = mysqli_query($connection,"SELECT * FROM likes WHERE post_id=$post_id");
        echo mysqli_num_rows($result);
    }
    function isAdmin(){
        global $connection;
        if(isLoggedIn()){
            $result = mysqli_query($connection,"SELECT user_role FROM users WHERE user_id = " . $_SESSION['user_id'] );
            $row = mysqli_fetch_array($result);
            if($row['user_role']=='admin'){
                return true;
            } else {
                return false;
            }
        }
    }
?>