<table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Username</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <!-- <th>Signup Date</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $query = "SELECT * FROM users";
                                    $query_action = mysqli_query($connection, $query);

                                    while($row = mysqli_fetch_assoc($query_action)){
                                        $user_id = $row['user_id'];
                                        $username = $row['username'];
                                        $user_email = $row['user_email'];
                                        $user_firstname = $row['user_firstname'];
                                        $user_lastname = $row['user_lastname'];
                                        $user_image = $row['user_image'];
                                        $user_role = $row['user_role'];

                                        echo "<tr>";
                                        echo "<td>{$user_id}</td>";
                                        echo "<td>{$username}</td>";
                                        echo "<td>{$user_firstname}</td>";
                                        echo "<td>{$user_lastname}</td>";
                                        echo "<td>{$user_email}</td>";
                                        echo "<td>{$user_role}</td>";
                                        // echo "<td>Some Title</td>";
                                        // $query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
                                        // $query_action_secondary = mysqli_query($connection,$query);
                                        // while($row = mysqli_fetch_assoc($query_action_secondary)){
                                        //     $post_id = $row['post_id'];
                                        //     $post_title = $row['post_title'];
                                        //     echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";
                                        // }
                                        
                                        echo "<td><a href='users.php?change_to_admin={$user_id}'>Admin</a></td>";
                                        echo "<td><a href='users.php?change_to_sub={$user_id}'>Subscriber</a></td>";
                                        echo "<td><a href='users.php?source=edit_user&edit_user={$user_id}'>Edit</a></td>";
                                        echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>

                        <?php
                            if (isset($_SESSION['user_role'])){
                                if($_SESSION['user_role'] == 'admin'){
                                    if(isset($_GET['delete'])){
                                        $target_user_id = mysqli_real_escape_string($connection,$_GET['delete']);
                                        $query = "DELETE FROM users WHERE user_id = {$target_user_id}";
                                        $query_action = mysqli_query($connection, $query);
                                        header("Location: users.php");
                                    }
                                    if(isset($_GET['change_to_admin'])){
                                        $target_user_id = mysqli_real_escape_string($connection,$_GET['change_to_admin']);
                                        $query = "UPDATE users SET user_role = 'admin' WHERE user_id = $target_user_id";
                                        $query_action = mysqli_query($connection, $query);
                                        header("Location: users.php");
                                    }
                                    if(isset($_GET['change_to_sub'])){
                                        $target_user_id = mysqli_real_escape_string($connection,$_GET['change_to_sub']);
                                        $query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = $target_user_id";
                                        $query_action = mysqli_query($connection, $query);
                                        header("Location: users.php");
                                    }
                                }
                            }
                        ?>