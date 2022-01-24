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
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Author</th>
                            <th>Comment</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>In response to</th>
                            <th>Date</th>
                            <th>Approve</th>
                            <th>Reject</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $query = "SELECT * FROM comments WHERE comment_post_id = " . escape($_GET['id']);
                            $query_action = mysqli_query($connection, $query);

                            while($row = mysqli_fetch_assoc($query_action)){
                                $comment_id = $row['comment_id'];
                                $comment_post_id = $row['comment_post_id'];
                                $comment_author = $row['comment_author'];
                                $comment_content = $row['comment_content'];
                                $comment_status = $row['comment_status'];
                                $comment_email = $row['comment_email'];
                                $comment_date = $row['comment_date'];

                                echo "<tr>";
                                echo "<td>{$comment_id}</td>";
                                echo "<td>{$comment_author}</td>";
                                echo "<td>{$comment_content}</td>";
                                echo "<td>{$comment_email}</td>";
                                echo "<td>{$comment_status}</td>";
                                // echo "<td>Some Title</td>";
                                $query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
                                $query_action_secondary = mysqli_query($connection,$query);
                                while($row = mysqli_fetch_assoc($query_action_secondary)){
                                    $post_id = $row['post_id'];
                                    $post_title = $row['post_title'];
                                    echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";
                                }
                                
                                echo "<td>{$comment_date}</td>";
                                echo "<td><a href='post_comments.php?approve=$comment_id&id=" . $_GET['id'] . "'>Approve</a></td>";
                                echo "<td><a href='post_comments.php?reject=$comment_id&id=" . $_GET['id'] . "'>Reject</a></td>";
                                echo "<td><a href='post_comments.php?delete=$comment_id&id=" . $_GET['id'] . "'>Delete</a></td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>

                <?php
                    if(isset($_GET['reject'])){
                        $target_comment_id = escape($_GET['reject']);
                        $query = "UPDATE comments SET comment_status = 'rejected' WHERE comment_id = $target_comment_id";
                        $query_action = mysqli_query($connection, $query);
                        header("Location: post_comments.php?id=".$_GET['id']);
                    }
                    if(isset($_GET['approve'])){
                        $target_comment_id = escape($_GET['approve']);
                        $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $target_comment_id";
                        $query_action = mysqli_query($connection, $query);
                        header("Location: post_comments.php?id=".$_GET['id']);
                    }
                    if(isset($_GET['delete'])){
                        $target_comment_id = escape($_GET['delete']);
                        $query = "DELETE FROM comments WHERE comment_id = {$target_comment_id}";
                        $query_action = mysqli_query($connection, $query);
                        header("Location: post_comments.php?id=".$_GET['id']);
                    }
                ?>
            </div>
        </div>
    </div>

    <?php
        include "includes/admin_scripts.php"
    ?>

</body>

</html>
