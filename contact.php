<?php  include "includes/db.php"; ?>
<?php  include "includes/head.php"; ?>
<body>    
    <?php
    if(isset($_POST['submit'])){
        $to = $_POST['to'];
        $subject = $_POST['subject'];
        $body = wordwrap($_POST['body'],70);
        $header = "From: " . $_POST['email'];;
        if(!empty($to) && !empty($subject) && !empty($body) && !empty($_POST['email'])){
            mail($to,$subject,$body,$header);
            $message = "Your email has been sent.";
        } else {
            $message = "Fields cannot be empty!";
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
                    <h1>Contact</h1>
                    <h6 class="text-center"><?php if(isset($message)){echo $message;} ?></h6>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="to" class="sr-only">Recipient</label>
                            <input type="email" name="to" id="to" class="form-control" placeholder="Enter recipient Email">
                        </div>
                        <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your Email">
                        </div>
                        <div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="body" id="body" cols="50" rows="10" placeholder="Type your message here"></textarea>
                        </div>
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Send">
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